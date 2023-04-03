<?php

namespace block_course_menu\output;

use block_course_menu\course_menu;

class menu_builder implements \renderable, \templatable
{


    public function __construct($id)
    {
        $this->id = $id;
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

        $data = [
            'id' => $this->id,
            'courseid' => $COURSE_MENU->get_courseid(),
            'sections' => $COURSE_MENU->get_menu_data_for_editing(),
        ];
//print_object($data);
        return $data;
    }

}