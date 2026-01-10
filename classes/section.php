<?php
/*
 * Author: Admin User
 * Create Date: 31-03-2023
 * License: LGPL 
 * 
 */

namespace block_course_menu;

use block_course_menu\crud;

class section extends crud
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
    private $coursemenuid;

    /**
     *
     * @var string
     */
    private $lang;

    /**
     *
     * @var string
     */
    private $title;

    /**
     *
     * @var int
     */
    private $display_title;

    /**
     *
     * @var string
     */
    private $icon;

    /**
     *
     * @var string
     */
    private $image;

    /**
     *
     * @var int
     */
    private $num_columns;

    /**
     *
     * @var string
     */
    private $css;

    /**
     *
     * @var int
     */
    private $sortorder;

    /**
     *
     * @var int
     */
    private $usermodified;

    /**
     *
     * @var int
     */
    private $instanceid;

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

        $this->table = 'block_course_menu_section';

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

        $this->coursemenuid = $result->coursemenuid ?? 0;
        $this->lang = $result->lang ?? '';
        $this->title = $result->title ?? '';
        $this->display_title = $result->display_title ?? 0;
        $this->icon = $result->icon ?? '';
        $this->image = $result->image ?? '';
        $this->num_columns = $result->num_columns ?? 0;
        $this->css = $result->css ?? '';
        $this->sortorder = $result->sortorder ?? 0;
        $this->usermodified = $result->usermodified ?? 0;
        $this->timecreated = $result->timecreated ?? 0;
        $this->timecreated_hr = '';
        if ($this->timecreated) {
            $this->timecreated_hr = strftime(get_string('strftimedate'), $result->timecreated);
        }
        $this->timemodified = $result->timemodified ?? 0;
        $this->timemodified_hr = '';
        if ($this->timemodified) {
            $this->timemodified_hr = strftime(get_string('strftimedate'), $result->timemodified);
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
     * @return instanceid - bigint (18) // block instance id
     */
    public function get_instanceid()
    {
        global $DB;
        if ($course_menu = $DB->get_record('block_course_menu', array('id' => $this->coursemenuid))) {
            return $course_menu->instance;
        } else {
            return 0;
        }
    }

    /**
     * @return coursemenuid - bigint (18)
     */
    public function get_coursemenuid()
    {
        return $this->coursemenuid;
    }

    /**
     * @return lang - varchar (6)
     */
    public function get_lang()
    {
        return $this->lang;
    }

    /**
     * @return title - varchar (255)
     */
    public function get_title()
    {
        return $this->title;
    }

    /**
     * @return display_title - tinyint (2)
     */
    public function get_display_title()
    {
        return $this->display_title;
    }

    /**
     * @return icon - varchar (50)
     */
    public function get_icon()
    {
        return $this->icon;
    }

    /**
     * @return image - varchar (100)
     */
    public function get_image()
    {
        return $this->image;
    }

    /**
     * @return num_columns - tinyint (2)
     */
    public function get_num_columns()
    {
        return $this->num_columns;
    }

    /**
     * @return css - longtext (-1)
     */
    public function get_css()
    {
        return $this->css;
    }

    /**
     * @return sortorder - smallint (4)
     */
    public function get_sortorder()
    {
        return $this->sortorder;
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
    public function set_coursemenuid($coursemenuid)
    {
        $this->coursemenuid = $coursemenuid;
    }

    /**
     * @param Type: varchar (6)
     */
    public function set_lang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * @param Type: varchar (255)
     */
    public function set_title($title)
    {
        $this->title = $title;
    }

    /**
     * @param Type: tinyint (2)
     */
    public function set_display_title($display_title)
    {
        $this->display_title = $display_title;
    }

    /**
     * @param Type: varchar (50)
     */
    public function set_icon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @param Type: varchar (100)
     */
    public function set_image($image)
    {
        $this->image = $image;
    }

    /**
     * @param Type: tinyint (2)
     */
    public function set_num_columns($num_columns)
    {
        $this->num_columns = $num_columns;
    }

    /**
     * @param Type: longtext (-1)
     */
    public function set_css($css)
    {
        $this->css = $css;
    }

    /**
     * @param Type: smallint (4)
     */
    public function set_sortorder($sortorder)
    {
        $this->sortorder = $sortorder;
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

}