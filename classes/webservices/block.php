<?php


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
 * External Web Service Template
 *
 * @package    block_course_menu
 * @copyright  2011 Moodle Pty Ltd (http://moodle.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->libdir . "/externallib.php");
require_once("$CFG->dirroot/config.php");

class block_course_menu_external_block extends external_api
{


    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function update_section_zero_parameters()
    {
        return new external_function_parameters(
            array(
                'id' => new external_value(PARAM_INT, 'ID from block_course_menu table', false, 0),
                'value' => new external_value(PARAM_INT, 'Whether to show the block in section zero or not',
                    false, 0)
            )
        );
    }

    /**
     * @param $id // Block instance ID
     * @param $value // Whether to show the block in section zero or not
     * @return bool
     * @throws invalid_parameter_exception
     */
    public static function update_section_zero($id, $value)
    {
        global $CFG, $USER, $DB;
        //Parameter validation
        $params = self::validate_parameters(self::update_section_zero_parameters(), array(
                'id' => $id,
                'value' => $value
            )
        );

        $DB->update_record('block_course_menu', [
                'id' => $id,
                'section_zero' => $value,
                'usermodified' => $USER->id,
                'timemodifed' => time()
            ]
        );

        return true;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function update_section_zero_returns()
    {
        return new external_value(PARAM_INT, 'Boolean');
    }

    // Update button sort order

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function update_button_order_parameters()
    {
        return new external_function_parameters(
            array(
                'id' => new external_value(PARAM_INT, 'ID from block_course_menu table', false, 0),
                'sort_order' => new external_value(PARAM_INT, 'Sort Order',
                    false, 0)
            )
        );
    }

    /**
     * @param $id // Block instance ID
     * @param $value // Whether to show the block in section zero or not
     * @return bool
     * @throws invalid_parameter_exception
     */
    public static function update_button_order($id, $sort_order)
    {
        global $CFG, $USER, $DB;
        //Parameter validation
        $params = self::validate_parameters(self::update_button_order_parameters(), array(
                'id' => $id,
                'sort_order' => $sort_order
            )
        );

        $DB->update_record('block_course_menu_button', [
                'id' => $id,
                'sortorder' => $sort_order,
                'usermodified' => $USER->id,
                'timemodifed' => time()
            ]
        );

        return true;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function update_button_order_returns()
    {
        return new external_value(PARAM_INT, 'Boolean');
    }

    // Update section sort order

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function update_section_order_parameters()
    {
        return new external_function_parameters(
            array(
                'id' => new external_value(PARAM_INT, 'ID from block_course_menu table', false, 0),
                'sort_order' => new external_value(PARAM_INT, 'Sort Order',
                    false, 0)
            )
        );
    }

    /**
     * @param $id // Block instance ID
     * @param $value // Whether to show the block in section zero or not
     * @return bool
     * @throws invalid_parameter_exception
     */
    public static function update_section_order($id, $sort_order)
    {
        global $CFG, $USER, $DB;
        //Parameter validation
        $params = self::validate_parameters(self::update_section_order_parameters(), array(
                'id' => $id,
                'sort_order' => $sort_order
            )
        );

        $DB->update_record('block_course_menu_section', [
                'id' => $id,
                'sortorder' => $sort_order,
                'usermodified' => $USER->id,
                'timemodifed' => time()
            ]
        );

        return true;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function update_section_order_returns()
    {
        return new external_value(PARAM_INT, 'Boolean');
    }

    // Delete button

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function delete_button_parameters()
    {
        return new external_function_parameters(
            array(
                'id' => new external_value(PARAM_INT, 'ID from block_course_menu table', false, 0)
            )
        );
    }

    /**
     * @param $id // Block instance ID
     * @param $value // Whether to show the block in section zero or not
     * @return bool
     * @throws invalid_parameter_exception
     */
    public static function delete_button($id)
    {
        global $CFG, $USER, $DB;
        //Parameter validation
        $params = self::validate_parameters(self::delete_button_parameters(), array(
                'id' => $id,
            )
        );

        $DB->delete_records('block_course_menu_button', [
                'id' => $id
            ]
        );

        return true;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function delete_button_returns()
    {
        return new external_value(PARAM_INT, 'Boolean');
    }

    // Delete section

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function delete_section_parameters()
    {
        return new external_function_parameters(
            array(
                'coursemenuid' => new external_value(PARAM_INT, 'Course menu ID', false, 0),
                'sortorder' => new external_value(PARAM_INT, 'Sort order of section', false, 0),
            )
        );
    }

    /**
     * @param $id // Block instance ID
     * @param $value // Whether to show the block in section zero or not
     * @return bool
     * @throws invalid_parameter_exception
     */
    public static function delete_section($coursemenuid, $sortorder)
    {
        global $CFG, $USER, $DB;
        //Parameter validation
        $params = self::validate_parameters(self::delete_section_parameters(), array(
                'coursemenuid' => $coursemenuid,
                'sortorder' => $sortorder,
            )
        );

        // Get section based on course menu id and sortorder
        $section = $DB->get_record('block_course_menu_section', [
            'coursemenuid' => $coursemenuid,
            'sortorder' => $sortorder
        ]);

        // Get all buttons based on course menu id and sortorder
        $buttons = $DB->get_records('block_course_menu_button', [
                'coursemenuid' => $coursemenuid,
                'sortorder' => $sortorder
        ]);

        // Delete all buttons
        foreach($buttons as $button) {
            $DB->delete_records('block_course_menu_button', [
                    'id' => $button->id
                ]
            );
        }

        // Delete section
        $DB->delete_records('block_course_menu_section', [
                'id' => $section->id
            ]
        );

        return true;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function delete_section_returns()
    {
        return new external_value(PARAM_INT, 'Boolean');
    }
}
