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

        // Define table block_course_menu_sections to be created.
        $table = new xmldb_table('block_course_menu_sections');

        // Adding fields to table block_course_menu_sections.
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

        // Adding keys to table block_course_menu_sections.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for block_course_menu_sections.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table block_course_menu_buttons to be created.
        $table = new xmldb_table('block_course_menu_buttons');

        // Adding fields to table block_course_menu_buttons.
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

        // Adding keys to table block_course_menu_buttons.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for block_course_menu_buttons.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Course_menu savepoint reached.
        upgrade_block_savepoint(true, 2023032700, 'course_menu');
    }


    return true;
}