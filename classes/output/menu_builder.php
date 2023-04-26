<?php

namespace block_course_menu\output;

use block_course_menu\course_menu;

class menu_builder implements \renderable, \templatable
{


    public function __construct($id, $courseid)
    {
        $this->id = $id;
        $this->courseid = $courseid;
    }

    /**
     *
     * @param \renderer_base $output
     * @return type
     * @global \moodle_database $DB
     * @global type $USER
     * @global type $CFG
     */
    public function export_for_template(\renderer_base $output)
    {
        global $USER, $CFG, $DB, $COURSE;

        $COURSE_MENU = new course_menu($this->id);

        if (!$COURSE_MENU->get_courseid()) {
            $courseid = $this->courseid;
        } else {
            $courseid = $COURSE_MENU->get_courseid();
        }

        $data = [
            'id' => $this->id,
            'courseid' => $courseid,
            'sections' => $COURSE_MENU->get_menu_data(),
        ];

        return $data;
    }

}