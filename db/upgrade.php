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

/**
 * Plugin upgrade steps are defined here.
 *
 * @package     block_course_menu
 * @category    upgrade
 * @copyright   2023 Patrick Thibaudeau ,thibaud@yorku.ca>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute block_course_menu upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_block_course_menu_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2023032600) {

        // Define table block_course_menu to be created.
        $table = new xmldb_table('block_course_menu');

        // Adding fields to table block_course_menu.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('instance', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('section_zero', XMLDB_TYPE_INTEGER, '1', null, null, null, '0');
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table block_course_menu.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for block_course_menu.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023032600, 'course_menu');
    }

    if ($oldversion < 2023032700) {

        // Define table block_course_menu_section to be created.
        $table = new xmldb_table('block_course_menu_section');

        // Adding fields to table block_course_menu_section.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('instanceid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('lang', XMLDB_TYPE_CHAR, '6', null, null, null, 'en');
        $table->add_field('title', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('icon', XMLDB_TYPE_CHAR, '50', null, null, null, null);
        $table->add_field('use_image', XMLDB_TYPE_INTEGER, '1', null, null, null, '0');
        $table->add_field('num_columns', XMLDB_TYPE_INTEGER, '1', null, null, null, '3');
        $table->add_field('css', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('sortorder', XMLDB_TYPE_INTEGER, '4', null, null, null, '0');
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table block_course_menu_section.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for block_course_menu_section.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table block_course_menu_button to be created.
        $table = new xmldb_table('block_course_menu_button');

        // Adding fields to table block_course_menu_button.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('sectionid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('lang', XMLDB_TYPE_CHAR, '6', null, null, null, 'en');
        $table->add_field('title', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('icon', XMLDB_TYPE_CHAR, '50', null, null, null, null);
        $table->add_field('cmid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('mod_title', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('url', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('use_image', XMLDB_TYPE_INTEGER, '1', null, null, null, '0');
        $table->add_field('styles', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('sortorder', XMLDB_TYPE_INTEGER, '4', null, null, null, '0');
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table block_course_menu_button.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for block_course_menu_button.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023032700, 'course_menu');
    }

    if ($oldversion < 2023033002) {

        // Define field display_title to be added to block_course_menu_section.
        $table = new xmldb_table('block_course_menu_section');
        $field = new xmldb_field('display_title', XMLDB_TYPE_INTEGER, '1', null, null, null, '1', 'title');

        // Conditionally launch add field display_title.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field use_image to be dropped from block_course_menu_section.
        $table = new xmldb_table('block_course_menu_section');
        $field = new xmldb_field('use_image');

        // Conditionally launch drop field use_image.
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023033002, 'course_menu');
    }

    if ($oldversion < 2023033003) {

        // Define field image to be added to block_course_menu_section.
        $table = new xmldb_table('block_course_menu_section');
        $field = new xmldb_field('image', XMLDB_TYPE_CHAR, '100', null, null, null, null, 'icon');

        // Conditionally launch add field image.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023033003, 'course_menu');
    }

    if ($oldversion < 2023033100) {

        // Rename field instanceid on table block_course_menu_section to NEWNAMEGOESHERE.
        $table = new xmldb_table('block_course_menu_section');
        $field = new xmldb_field('instanceid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'id');

        // Launch rename field instanceid.
        $dbman->rename_field($table, $field, 'coursemenuid');

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023033100, 'course_menu');
    }

    if ($oldversion < 2023040100) {

        // Define field button_type to be added to block_course_menu_section.
        $table = new xmldb_table('block_course_menu_section');
        $field = new xmldb_field('button_type', XMLDB_TYPE_CHAR, '50', null, null, null, 'btn-primary', 'display_title');

        // Conditionally launch add field button_type.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023040100, 'course_menu');
    }

    if ($oldversion < 2023040102) {

        // Define table block_course_menu_button to be dropped.
        $table = new xmldb_table('block_course_menu_button');

        // Conditionally launch drop table for block_course_menu_button.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }

        // Define table block_course_menu_button to be created.
        $table = new xmldb_table('block_course_menu_button');

        // Adding fields to table block_course_menu_button.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('sectionid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('lang', XMLDB_TYPE_CHAR, '6', null, null, null, 'en');
        $table->add_field('title', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('display_title', XMLDB_TYPE_INTEGER, '1', null, null, null, '1');
        $table->add_field('button_type', XMLDB_TYPE_CHAR, '50', null, null, null, 'btn-primary');
        $table->add_field('icon', XMLDB_TYPE_CHAR, '50', null, null, null, null);
        $table->add_field('image', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('cmid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('mod_title', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('url', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('sortorder', XMLDB_TYPE_INTEGER, '4', null, null, null, '0');
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table block_course_menu_button.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for block_course_menu_button.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023040102, 'course_menu');
    }

    if ($oldversion < 2023040103) {

        // Define field mod_name to be added to block_course_menu_button.
        $table = new xmldb_table('block_course_menu_button');
        $field = new xmldb_field('mod_name', XMLDB_TYPE_CHAR, '100', null, null, null, null, 'cmid');

        // Conditionally launch add field mod_name.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023040103, 'course_menu');
    }

    if ($oldversion < 2023040200) {

        // Define field icon_bg_color to be added to block_course_menu_button.
        $table = new xmldb_table('block_course_menu_button');
        $field = new xmldb_field('icon_bg_color', XMLDB_TYPE_CHAR, '10', null, null, null, '#8e8d8d', 'icon');

        // Conditionally launch add field icon_bg_color.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023040200, 'course_menu');
    }

    if ($oldversion < 2023040204) {

        // Define field courseid to be added to block_course_menu.
        $table = new xmldb_table('block_course_menu');
        $field = new xmldb_field('courseid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'instance');

        // Conditionally launch add field courseid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023040204, 'course_menu');
    }

    if ($oldversion < 2023042202) {

        // Define field coursemenuid to be added to block_course_menu_button.
        $table = new xmldb_table('block_course_menu_button');
        $field = new xmldb_field('coursemenuid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'id');

        // Conditionally launch add field coursemenuid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Rename field sectionid on table block_course_menu_button to NEWNAMEGOESHERE.
        $table = new xmldb_table('block_course_menu_button');
        $field = new xmldb_field('sectionid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'id');

        // Launch rename field sectionid.
        $dbman->rename_field($table, $field, 'sectionorder');

        // Define index coursemenu_sectionorder_idx (not unique) to be added to block_course_menu_button.
        $table = new xmldb_table('block_course_menu_button');
        $index = new xmldb_index('coursemenu_sectionorder_idx', XMLDB_INDEX_NOTUNIQUE, ['coursemenuid', 'sectionorder']);

        // Conditionally launch add index coursemenu_sectionorder_idx.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Update existing menu items
        $sql = "SELECT 
             cm.id as coursemenuid,
            cms.id as coursemenusectionid,
            cms.sortorder as sectionorder
        FROM 
            {block_course_menu} cm Inner Join
            {block_course_menu_section} cms On cm.id = cms.coursemenuid";
        $menus = $DB->get_recordset_sql($sql, []);
        foreach ($menus as $menu) {
            if ($buttons = $DB->get_records('block_course_menu_button',['sectionorder' => $menu->coursemenusectionid])) {
                foreach($buttons as $button) {

                    $params = [
                        'id' => $button->id,
                        'coursemenuid' => $menu->coursemenuid,
                        'sectionorder' => $menu->sectionorder,
                    ];
                    $DB->update_record('block_course_menu_button', $params);
                }
            }
        }

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023042202, 'course_menu');
    }

    if ($oldversion < 2023042204) {

        // Define table block_course_menu_section to be renamed to NEWNAMEGOESHERE.
        $table = new xmldb_table('block_course_menu_sections');

        // Launch rename table for block_course_menu_section.
        $dbman->rename_table($table, 'block_course_menu_section');

        // Define table block_course_menu_button to be renamed to NEWNAMEGOESHERE.
        $table = new xmldb_table('block_course_menu_buttons');

        // Launch rename table for block_course_menu_button.
        $dbman->rename_table($table, 'block_course_menu_button');

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023042204, 'course_menu');
    }

    if ($oldversion < 2023042300) {

        // Define field text_color to be added to block_course_menu_button.
        $table = new xmldb_table('block_course_menu_button');
        $field = new xmldb_field('text_color', XMLDB_TYPE_CHAR, '10', null, null, null, '#000000', 'display_title');

        // Conditionally launch add field text_color.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field text_color to be added to block_course_menu_section.
        $table = new xmldb_table('block_course_menu_section');
        $field = new xmldb_field('text_color', XMLDB_TYPE_CHAR, '10', null, null, null, '#000000', 'display_title');

        // Conditionally launch add field text_color.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023042300, 'course_menu');
    }
    return true;
}
