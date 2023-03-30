<?php

namespace block_course_menu\output;

class block implements \renderable, \templatable
{


    public function __construct($block_data_id, $show_in_section_zero = false)
    {
        $this->block_data_id = $block_data_id;
        $this->show_in_section_zero = $show_in_section_zero;
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

        $context = \context_course::instance($COURSE->id);

        // Does the user have permission to edit this block?
        $editor = false;
        if (has_capability('block/course_menu:edit', $context)) {
            $editor = true;
        }

        $langs = get_string_manager()->get_list_of_translations();
        $data = [
            'id' => $this->block_data_id,
            'editor' => $editor,
            'show_in_section_zero' => $this->show_in_section_zero,
            'langs' => $langs,
        ];
        return $data;
    }

}