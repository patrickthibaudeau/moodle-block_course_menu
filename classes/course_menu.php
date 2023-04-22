<?php
/*
 * Author: Admin User
 * Create Date: 31-03-2023
 * License: LGPL 
 * 
 */

namespace block_course_menu;

use block_course_menu\crud;

class course_menu extends crud
{


    /**
     *
     * @var int
     */
    private $id;

    /**
     *
     * @var int
     */
    private $instance;

    /**
     *
     * @var int
     */
    private $courseid;

    /**
     *
     * @var int
     */
    private $section_zero;

    /**
     *
     * @var int
     */
    private $usermodified;

    /**
     *
     * @var int
     */
    private $timecreated;

    /**
     *
     * @var string
     */
    private $timecreated_hr;

    /**
     *
     * @var int
     */
    private $timemodified;

    /**
     *
     * @var string
     */
    private $timemodified_hr;

    /**
     *
     * @var string
     */
    private $table;


    /**
     *
     *
     */
    public function __construct($id = 0)
    {
        global $CFG, $DB, $DB;

        $this->table = 'block_course_menu';

        parent::set_table($this->table);

        if ($id) {
            $this->id = $id;
            parent::set_id($this->id);
            $result = $this->get_record($this->table, $this->id);
        } else {
            $result = new \stdClass();
            $this->id = 0;
            parent::set_id($this->id);
        }

        $this->instance = $result->instance ?? 0;
        $this->courseid = $result->courseid ?? 0;
        $this->section_zero = $result->section_zero ?? 0;
        $this->usermodified = $result->usermodified ?? 0;
        $this->timecreated = $result->timecreated ?? 0;
        $this->timecreated_hr = '';
        if ($this->timecreated) {
            $this->timecreated_hr = $this->strftime(get_string('strftimedate'), $result->timecreated);
        }
        $this->timemodified = $result->timemodified ?? 0;
        $this->timemodified_hr = '';
        if ($this->timemodified) {
            $this->timemodified_hr = $this->strftime(get_string('strftimedate'), $result->timemodified);
        }
    }

    /**
     * @return id - bigint (18)
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * @return instance - bigint (18)
     */
    public function get_instance()
    {
        return $this->instance;
    }

    /**
     * @return instance - bigint (18)
     */
    public function get_courseid()
    {
        return $this->courseid;
    }

    /**
     * @return section_zero - tinyint (2)
     */
    public function get_section_zero()
    {
        return $this->section_zero;
    }

    /**
     * @return usermodified - bigint (18)
     */
    public function get_usermodified()
    {
        return $this->usermodified;
    }

    /**
     * @return timecreated - bigint (18)
     */
    public function get_timecreated()
    {
        return $this->timecreated;
    }

    /**
     * @return timemodified - bigint (18)
     */
    public function get_timemodified()
    {
        return $this->timemodified;
    }

    /**
     * @param Type: bigint (18)
     */
    public function set_id($id)
    {
        $this->id = $id;
    }

    /**
     * @param Type: bigint (18)
     */
    public function set_instance($instance)
    {
        $this->instance = $instance;
    }

    /**
     * @param Type: tinyint (2)
     */
    public function set_section_zero($section_zero)
    {
        $this->section_zero = $section_zero;
    }

    /**
     * @param Type: bigint (18)
     */
    public function set_usermodified($usermodified)
    {
        $this->usermodified = $usermodified;
    }

    /**
     * @param Type: bigint (18)
     */
    public function set_timecreated($timecreated)
    {
        $this->timecreated = $timecreated;
    }

    /**
     * @param Type: bigint (18)
     */
    public function set_timemodified($timemodified)
    {
        $this->timemodified = $timemodified;
    }

    /**
     * Return array of menu data.
     * @return array
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function get_menu_data()
    {
        global $DB, $CFG;
        // get block context
        $context = \context_block::instance($this->instance);
        $section_data = [];
        $section_count = 0;
        $sections = $DB->get_records('block_course_menu_sections', ['coursemenuid' => $this->id], 'sortorder');
        foreach ($sections as $section) {
            $section_data[$section_count] = new \stdClass();
            $section_data[$section_count]->id = $section->id;
            $section_data[$section_count]->sortorder = $section->sortorder;
            $section_data[$section_count]->coursemenuid = $section->coursemenuid;
            $section_data[$section_count]->title = $section->title;
            $section_data[$section_count]->display_title = $section->display_title;
            $section_data[$section_count]->button_type = $section->button_type;
            // Get background image
            $section_data[$section_count]->background_image = '';
            $fs = get_file_storage();
            $background_files = $fs->get_area_files(
                $context->id,
                'block_course_menu',
                'section_background',
                $section->id);

            foreach ($background_files as $file) {
                $filename = $file->get_filename();
                if ($filename && $filename != '.') {
                    $url = $CFG->wwwroot . '/pluginfile.php/' .
                        $context->id .
                        '/block/course_menu/section_background/' .
                        $file->get_itemid() .
                        $file->get_filepath() .
                        '/' . $filename;

                    $section_data[$section_count]->background_image = $url;
                }
            }

            $image_files = $fs->get_area_files(
                $context->id,
                'block_course_menu',
                'section_image',
                $section->id);

            $section_data[$section_count]->image = '';
            $section_data[$section_count]->icon = '';
            foreach ($image_files as $file) {
                $filename = $file->get_filename();

                if (trim($filename) && trim($filename) != '.') {
                    $url = $CFG->wwwroot . '/pluginfile.php/' .
                        $context->id .
                        '/block/course_menu/section_image/' .
                        $file->get_itemid() .
                        $file->get_filepath() .
                        '/' . $filename;

                    $section_data[$section_count]->image = $url;
                }
            }
            if (!$section_data[$section_count]->image) {
                if (!$section->icon) {
                    if ($section->image) {
                        $section_data[$section_count]->image = $CFG->wwwroot . '/blocks/course_menu/' . $section->image;
                    }
                } else {
                    $section_data[$section_count]->icon = $section->icon;
                }
            }

            // Get buttons
            $buttons = [];
            $count = 0;
            $buttons_data = $DB->get_records('block_course_menu_buttons',
                [
                    'coursemenuid' => $this->id,
                    'sectionorder' => $section->sortorder,
                    ], 'sortorder');
            foreach ($buttons_data as $button) {
                $buttons[$count]['id'] = $button->id;
                $buttons[$count]['coursemenuidid'] = $this->id;
                $buttons[$count]['sectionorder'] = $button->sectionorder;
                $buttons[$count]['title'] = $button->title;
                $buttons[$count]['display_title'] = $button->display_title;
                $buttons[$count]['button_type'] = $button->button_type;
                $buttons[$count]['cmid'] = $button->cmid;
                $buttons[$count]['mod_name'] = $button->mod_name;
                // Get background image
                $buttons[$count]['background_image'] = '';
                $fs = get_file_storage();
                $background_files = $fs->get_area_files(
                    $context->id,
                    'block_course_menu',
                    'button_background',
                    $section->id);

                foreach ($background_files as $file) {
                    $filename = $file->get_filename();
                    if ($filename && $filename != '.') {
                        $url = $CFG->wwwroot . '/pluginfile.php/' .
                            $context->id .
                            '/block/course_menu/button_background/' .
                            $file->get_itemid() .
                            $file->get_filepath() .
                            '/' . $filename;

                        $buttons[$count]['background_image'] = $url;
                    }
                }

                $buttons[$count]['image'] = '';
                $buttons[$count]['icon'] = '';

                $image_files = $fs->get_area_files(
                    $context->id,
                    'block_course_menu',
                    'button_image',
                    $section->id);

                foreach ($image_files as $file) {
                    $filename = $file->get_filename();
                    if ($filename && $filename != '.') {
                        $url = $CFG->wwwroot . '/pluginfile.php/' .
                            $context->id .
                            '/block/course_menu/button_image/' .
                            $file->get_itemid() .
                            $file->get_filepath() .
                            '/' . $filename;

                        $buttons[$count]['image'] = $url;
                    }

                }

                if (!$buttons[$count]['image']) {
                    if (!$button->icon) {
                        if ($button->image) {
                            $buttons[$count]['image'] = $CFG->wwwroot . '/blocks/course_menu/' . $button->image;
                        }
                    } else {
                        $buttons[$count]['icon'] = $button->icon;
                    }
                }
                $buttons[$count]['icon_bg_color'] = $button->icon_bg_color;
                $count++;
            }
            $section_data[$section_count]->buttons = $buttons;
            $section_count++;
        }

        return $section_data;
    }

}