<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace block_course_menu\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;

/**
 * Privacy Subsystem implementation for block_course_menu.
 *
 * @package    block_course_menu
 * @copyright  2026 Carlos Arce <carlosarcelopera@catalyst-ca.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    \core_privacy\local\request\core_userlist_provider,
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\plugin\provider {
    use \core_privacy\local\legacy_polyfill;

    /**
     * Returns meta data about this system.
     *
     * @param collection $collection The initialised collection to add items to.
     * @return collection A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection): collection {

        $collection->add_database_table('block_course_menu', [
            'usermodified' => 'privacy:metadata:block_course_menu:usermodified',
        ], 'privacy:metadata:block_course_menu');

        $collection->add_database_table('block_course_menu_section', [
            'usermodified' => 'privacy:metadata:block_course_menu_section:usermodified',
        ], 'privacy:metadata:block_course_menu_section');

        $collection->add_database_table('block_course_menu_button', [
            'usermodified' => 'privacy:metadata:block_course_menu_button:usermodified',
        ], 'privacy:metadata:block_course_menu_button');

        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param int $userid The user to search.
     * @return contextlist The contextlist containing the list of contexts used in this plugin.
     */
    public static function get_contexts_for_userid($userid): contextlist {
        $contextlist = new contextlist();

        // Find course contexts where this user modified menu configurations.
        $sql = "SELECT DISTINCT ctx.id
                FROM {block_course_menu} bcm
                JOIN {context} ctx ON ctx.instanceid = bcm.courseid AND ctx.contextlevel = :contextlevel
                WHERE bcm.usermodified = :userid";

        $params = ['userid' => $userid, 'contextlevel' => CONTEXT_COURSE];
        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    /**
     * Get the list of users who have data within a context.
     *
     * @param userlist $userlist The userlist containing the list of users who have data in this context.
     */
    public static function get_users_in_context(userlist $userlist) {
        $context = $userlist->get_context();

        if (!$context instanceof \context_course) {
            return;
        }

        // Find all users who modified menu configurations in this course.
        $sql = "SELECT DISTINCT bcm.usermodified
                FROM {block_course_menu} bcm
                WHERE bcm.courseid = :courseid";

        $params = ['courseid' => $context->instanceid];
        $userlist->add_from_sql('usermodified', $sql, $params);

        // Find all users who modified menu sections in this course.
        $sql = "SELECT DISTINCT bcms.usermodified
                FROM {block_course_menu_section} bcms
                JOIN {block_course_menu} bcm ON bcm.id = bcms.coursemenuid
                WHERE bcm.courseid = :courseid";

        $userlist->add_from_sql('usermodified', $sql, $params);

        // Find all users who modified menu buttons in this course.
        $sql = "SELECT DISTINCT bcmb.usermodified
                FROM {block_course_menu_button} bcmb
                JOIN {block_course_menu_section} bcms ON bcms.id = bcmb.sectionorder
                JOIN {block_course_menu} bcm ON bcm.id = bcms.coursemenuid
                WHERE bcm.courseid = :courseid";

        $userlist->add_from_sql('usermodified', $sql, $params);
    }

    /**
     * Export all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export information for.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;

        foreach ($contextlist->get_contexts() as $context) {
            if ($context->contextlevel !== CONTEXT_COURSE) {
                continue;
            }

            // Export menu configurations modified by user.
            $sql = "SELECT bcm.* FROM {block_course_menu} bcm
                    WHERE bcm.courseid = :courseid AND bcm.usermodified = :userid";
            $params = ['courseid' => $context->instanceid, 'userid' => $contextlist->get_user()->id];
            $menus = $DB->get_records_sql($sql, $params);

            if (!empty($menus)) {
                $menusdata = [];
                foreach ($menus as $menu) {
                    $menusdata[] = (object) [
                        'id' => $menu->id,
                        'instance' => $menu->instance,
                        'section_zero' => $menu->section_zero ? 'Yes' : 'No',
                        'timecreated' => \core_privacy\local\request\transform::datetime($menu->timecreated),
                        'timemodified' => \core_privacy\local\request\transform::datetime($menu->timemodified),
                    ];
                }
                writer::with_context($context)->export_data(
                    ['Course Menu'],
                    (object) ['menus' => $menusdata]
                );
            }

            // Export menu sections modified by user.
            $sql = "SELECT bcms.* FROM {block_course_menu_section} bcms
                    JOIN {block_course_menu} bcm ON bcm.id = bcms.coursemenuid
                    WHERE bcm.courseid = :courseid AND bcms.usermodified = :userid";
            $params = ['courseid' => $context->instanceid, 'userid' => $contextlist->get_user()->id];
            $sections = $DB->get_records_sql($sql, $params);

            if (!empty($sections)) {
                $sectionsdata = [];
                foreach ($sections as $section) {
                    $sectionsdata[] = (object) [
                        'id' => $section->id,
                        'title' => $section->title,
                        'lang' => $section->lang,
                        'timecreated' => \core_privacy\local\request\transform::datetime($section->timecreated),
                        'timemodified' => \core_privacy\local\request\transform::datetime($section->timemodified),
                    ];
                }
                writer::with_context($context)->export_data(
                    ['Course Menu', 'Sections'],
                    (object) ['sections' => $sectionsdata]
                );
            }

            // Export menu buttons modified by user.
            $sql = "SELECT bcmb.* FROM {block_course_menu_button} bcmb
                    JOIN {block_course_menu_section} bcms ON bcms.id = bcmb.sectionorder
                    JOIN {block_course_menu} bcm ON bcm.id = bcms.coursemenuid
                    WHERE bcm.courseid = :courseid AND bcmb.usermodified = :userid";
            $params = ['courseid' => $context->instanceid, 'userid' => $contextlist->get_user()->id];
            $buttons = $DB->get_records_sql($sql, $params);

            if (!empty($buttons)) {
                $buttonsdata = [];
                foreach ($buttons as $button) {
                    $buttonsdata[] = (object) [
                        'id' => $button->id,
                        'title' => $button->title,
                        'lang' => $button->lang,
                        'mod_name' => $button->mod_name,
                        'timecreated' => \core_privacy\local\request\transform::datetime($button->timecreated),
                        'timemodified' => \core_privacy\local\request\transform::datetime($button->timemodified),
                    ];
                }
                writer::with_context($context)->export_data(
                    ['Course Menu', 'Buttons'],
                    (object) ['buttons' => $buttonsdata]
                );
            }
        }
    }

    /**
     * Delete all data for all users in the specified context.
     *
     * @param \context $context The specific context to delete data for.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        global $DB;

        if ($context->contextlevel !== CONTEXT_COURSE) {
            return;
        }

        // Anonymize usermodified field for all menus in this course.
        $DB->set_field_select(
            'block_course_menu',
            'usermodified',
            0,
            'courseid = :courseid',
            ['courseid' => $context->instanceid]
        );

        // Anonymize usermodified field for all sections in this course.
        $sql = "SELECT bcms.id FROM {block_course_menu_section} bcms
                JOIN {block_course_menu} bcm ON bcm.id = bcms.coursemenuid
                WHERE bcm.courseid = :courseid";
        $sectionids = $DB->get_fieldset_sql($sql, ['courseid' => $context->instanceid]);
        if (!empty($sectionids)) {
            [$sectionsql, $params] = $DB->get_in_or_equal($sectionids, SQL_PARAMS_NAMED);
            $DB->set_field_select(
                'block_course_menu_section',
                'usermodified',
                0,
                "id $sectionsql",
                $params
            );
        }

        // Anonymize usermodified field for all buttons in this course.
        $sql = "SELECT bcmb.id FROM {block_course_menu_button} bcmb
                JOIN {block_course_menu_section} bcms ON bcms.id = bcmb.sectionorder
                JOIN {block_course_menu} bcm ON bcm.id = bcms.coursemenuid
                WHERE bcm.courseid = :courseid";
        $buttonids = $DB->get_fieldset_sql($sql, ['courseid' => $context->instanceid]);
        if (!empty($buttonids)) {
            [$buttonsql, $params] = $DB->get_in_or_equal($buttonids, SQL_PARAMS_NAMED);
            $DB->set_field_select(
                'block_course_menu_button',
                'usermodified',
                0,
                "id $buttonsql",
                $params
            );
        }
    }

    /**
     * Delete multiple users within a single context.
     *
     * @param approved_userlist $userlist The approved context and user information to delete information for.
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;

        $context = $userlist->get_context();

        if ($context->contextlevel !== CONTEXT_COURSE) {
            return;
        }

        $userids = $userlist->get_userids();
        [$usersql, $params] = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);

        // Anonymize usermodified field for affected menus.
        $sql = "courseid = :courseid AND usermodified $usersql";
        $params['courseid'] = $context->instanceid;
        $DB->set_field_select('block_course_menu', 'usermodified', 0, $sql, $params);

        // Anonymize usermodified field for affected sections.
        $sql = "SELECT bcms.id FROM {block_course_menu_section} bcms
                JOIN {block_course_menu} bcm ON bcm.id = bcms.coursemenuid
                WHERE bcm.courseid = :courseid AND bcms.usermodified $usersql";
        $params['courseid'] = $context->instanceid;
        $sectionids = $DB->get_fieldset_sql($sql, $params);
        if (!empty($sectionids)) {
            [$sectionsql, $sectionparams] = $DB->get_in_or_equal($sectionids, SQL_PARAMS_NAMED);
            $DB->set_field_select(
                'block_course_menu_section',
                'usermodified',
                0,
                "id $sectionsql",
                $sectionparams
            );
        }

        // Anonymize usermodified field for affected buttons.
        $sql = "SELECT bcmb.id FROM {block_course_menu_button} bcmb
                JOIN {block_course_menu_section} bcms ON bcms.id = bcmb.sectionorder
                JOIN {block_course_menu} bcm ON bcm.id = bcms.coursemenuid
                WHERE bcm.courseid = :courseid AND bcmb.usermodified $usersql";
        $params['courseid'] = $context->instanceid;
        $buttonids = $DB->get_fieldset_sql($sql, $params);
        if (!empty($buttonids)) {
            [$buttonsql, $buttonparams] = $DB->get_in_or_equal($buttonids, SQL_PARAMS_NAMED);
            $DB->set_field_select(
                'block_course_menu_button',
                'usermodified',
                0,
                "id $buttonsql",
                $buttonparams
            );
        }
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts and user information to delete information for.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;

        $userid = $contextlist->get_user()->id;

        foreach ($contextlist->get_contexts() as $context) {
            if ($context->contextlevel !== CONTEXT_COURSE) {
                continue;
            }

            // Anonymize usermodified field for affected menus.
            $DB->set_field_select(
                'block_course_menu',
                'usermodified',
                0,
                'courseid = :courseid AND usermodified = :userid',
                ['courseid' => $context->instanceid, 'userid' => $userid]
            );

            // Anonymize usermodified field for affected sections.
            $sql = "SELECT bcms.id FROM {block_course_menu_section} bcms
                    JOIN {block_course_menu} bcm ON bcm.id = bcms.coursemenuid
                    WHERE bcm.courseid = :courseid AND bcms.usermodified = :userid";
            $sectionids = $DB->get_fieldset_sql($sql, ['courseid' => $context->instanceid, 'userid' => $userid]);
            if (!empty($sectionids)) {
                [$sectionsql, $params] = $DB->get_in_or_equal($sectionids, SQL_PARAMS_NAMED);
                $DB->set_field_select(
                    'block_course_menu_section',
                    'usermodified',
                    0,
                    "id $sectionsql",
                    $params
                );
            }

            // Anonymize usermodified field for affected buttons.
            $sql = "SELECT bcmb.id FROM {block_course_menu_button} bcmb
                    JOIN {block_course_menu_section} bcms ON bcms.id = bcmb.sectionorder
                    JOIN {block_course_menu} bcm ON bcm.id = bcms.coursemenuid
                    WHERE bcm.courseid = :courseid AND bcmb.usermodified = :userid";
            $buttonids = $DB->get_fieldset_sql($sql, ['courseid' => $context->instanceid, 'userid' => $userid]);
            if (!empty($buttonids)) {
                [$buttonsql, $params] = $DB->get_in_or_equal($buttonids, SQL_PARAMS_NAMED);
                $DB->set_field_select(
                    'block_course_menu_button',
                    'usermodified',
                    0,
                    "id $buttonsql",
                    $params
                );
            }
        }
    }
}
