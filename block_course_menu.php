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
 * Block course_menu is defined here.
 *
 * @package     block_course_menu
 * @copyright   2023 Patrick Thibaudeau ,thibaud@yorku.ca>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_course_menu extends block_base {

    /**
     * Initializes class member variables.
     */
    public function init() {
        // Needed by Moodle to differentiate between blocks.
        $this->title = get_string('pluginname', 'block_course_menu');
    }

    /**
     * Returns the block contents.
     *
     * @return stdClass The block contents.
     */
    public function get_content() {
        global $DB, $USER, $PAGE;

        $show_in_section_zero = false;
        // Get block data
        $block_data = $DB->get_record('block_course_menu', array('instance' => $this->instance->id));

        if (!$block_data) {
            $id = $DB->insert_record('block_course_menu', array(
                'instance' => $this->instance->id,
                'usermodified' => $USER->id,
                'timecreated' => time(),
                'timemodified' => time()));
            $block_data = $DB->get_record('block_course_menu', array('id' => $id));
        }

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        if ($block_data->section_zero == 1) {
            $this->title = null;
        }

        $PAGE->requires->js_call_amd('block_course_menu/block', 'init');;
        // Get renderable content.
        $output = $PAGE->get_renderer('block_course_menu');
        $block = new \block_course_menu\output\block($block_data->id, $block_data->section_zero);

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        $this->content->text = $output->render_block($block);;

        return $this->content;
    }

    /**
     * Defines configuration data.
     *
     * The function is called immediately after init().
     */
    public function specialization() {

        // Load user defined title and make sure it's never empty.
        if (empty($this->config->title)) {
            $this->title = get_string('pluginname', 'block_course_menu');
        } else {
            $this->title = $this->config->title;
        }
    }

    /**
     * Enables global configuration of the block in settings.php.
     *
     * @return bool True if the global configuration is enabled.
     */
    public function has_config() {
        return true;
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
    public function applicable_formats() {
        return array(
            'course-view' => true,
        );
    }
}
