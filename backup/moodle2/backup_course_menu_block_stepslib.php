<?php

class backup_course_menu_block_structure_step extends backup_block_structure_step
{

    /**
     * @inheritDoc
     */
    protected function define_structure()
    {
        global $DB;
        $block_course_menu = $DB->get_record('block_course_menu', array('instance' => $this->task->get_blockid()));
                // Define each element
        $course_menu = new backup_nested_element('course_menu', ['id'], [
            'instance',
            'courseid',
            'section_zero'
        ]);

        $course_menu_sections = new backup_nested_element('course_menu_sections');
        $course_menu_section = new backup_nested_element('course_menu_section', ['id'], [
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
        ]);
        $course_menu_buttons = new backup_nested_element('course_menu_buttons');
        $course_menu_button = new backup_nested_element('course_menu_button', ['id'], [
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
        ]);

        $wrapper = $this->prepare_block_structure($course_menu);

        // Set children
        $course_menu->add_child($course_menu_sections);
        $course_menu_sections->add_child($course_menu_section);
        $course_menu->add_child($course_menu_buttons);
        $course_menu_buttons->add_child($course_menu_button);

        // Set sources
        $course_menu->set_source_table('block_course_menu',
            ['instance' => backup::VAR_BLOCKID]);
        $course_menu_section->set_source_table('block_course_menu_section',
            ['coursemenuid' => backup::VAR_PARENTID]);
        $course_menu_button->set_source_table('block_course_menu_button',
            ['coursemenuid' => backup::VAR_PARENTID]);

        return  $wrapper;
    }
}