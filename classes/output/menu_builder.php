<?php

namespace block_course_menu\output;

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

        $langs = get_string_manager()->get_list_of_translations();
        $data = [
            'id' => $this->id,
            'langs' => $langs,
        ];
        print_object($data);
        return $data;
    }

}