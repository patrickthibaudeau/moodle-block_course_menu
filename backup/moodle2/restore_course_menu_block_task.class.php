<?php

require_once($CFG->dirroot . '/blocks/course_menu/backup/moodle2/restore_course_menu_block_stepslib.php'); // We have structure steps

class restore_course_menu_block_task extends restore_block_task
{

    protected function define_my_settings() {
    }

    protected function define_my_steps() {
        // rss_client has one structure step
        $this->add_step(new restore_course_menu_block_structure_step('course_menu_structure', 'course_menu.xml'));
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

    public function get_configdata_encoded_attributes() {
        return array(); // No special handling of configdata
    }

    static public function define_decode_contents() {
        return array();
    }

    static public function define_decode_rules() {
        return array();
    }
}