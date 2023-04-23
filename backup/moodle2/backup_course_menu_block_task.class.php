<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    block_course_menu
 * @subpackage backup-moodle2
 * @copyright 2023 onwards Patrick Thibaudeau (York University) {@link https://yorku.ca}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/blocks/course_menu/backup/moodle2/backup_course_menu_block_stepslib.php'); // We have structure steps

class backup_course_menu_block_task extends backup_block_task
{

    protected function define_my_settings()
    {
    }

    protected function define_my_steps()
    {
        $this->add_step(new backup_course_menu_block_structure_step('course_menu_structure', 'course_menu.xml'));
    }

    public function get_fileareas()
    {
        $fileAreas = array(
            'section_background',
            'section_image',
            'button_background',
            'button_image'
        );
       return $fileAreas;
    }

    public function get_configdata_encoded_attributes()
    {
        return array();
    }

    static public function encode_content_links($content) {
        return $content; // No special encoding of links
    }
}