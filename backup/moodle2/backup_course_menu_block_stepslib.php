<?php

class backup_course_menu_block_structure_step extends backup_block_structure_step
{

    /**
     * @inheritDoc
     */
    protected function define_structure()
    {
        global $DB;

        // get course menu
        $block_course_menu = $DB->get_record('block_course_menu', array('instance' => $this->task->get_blockid()));
                // Define each element
        $course_menu = new backup_nested_element('course_menu', array('id'), null);


        $course_menu_sections = new backup_nested_element('course_menu_sections');
        $course_menu_section = new backup_nested_element('course_menu_section', array('id'), array(
            'coursemenuid',
            'lang',
            'title',
            'display_title',
            'button_type',
            'icon',
            'image',
            'num_columns',
            'css',
            'sortorder'
        ));
        $course_menu_buttons = new backup_nested_element('course_menu_buttons');
        $course_menu_button = new backup_nested_element('course_menu_button', array('id'), array(
            'coursemenuid',
            'sectionorder',
            'title',
            'display_title',
            'button_type',
            'icon',
            'icon_bg_color',
            'image',
            'cmid',
            'mod_name',
            'mod_title',
            'url',
            'sortorder'
        ));

        // Set children
        $course_menu->add_child($course_menu_sections);
        $course_menu_sections->add_child($course_menu_section);
        $course_menu->add_child($course_menu_buttons);
        $course_menu_buttons->add_child($course_menu_button);

        // Set sources
        $course_menu->set_source_table('block_course_menu', array('id' => $block_course_menu->id));
//
//        $course_menu_sections->set_source_sql(
//            "SELECT * FROM {block_course_menu_section} WHERE coursemenuid = ?",
//            array(backup::VAR_PARENTID));
//
//        $course_menu_buttons->set_source_sql("SELECT * FROM {block_course_menu_button} WHERE coursemenuid = ?",
//            array(backup::VAR_PARENTID));

        return $this->prepare_block_structure($course_menu);
    }
}