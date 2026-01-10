<?php

require_once('../../config.php');
require_once($CFG->dirroot . "/blocks/course_menu/classes/forms/import.php");

use block_course_menu\course_menu;

global $CFG, $USER, $PAGE, $SITE, $DB, $OUTPUT;
require_login(1, false); //Use course 1 because this has nothing to do with an actual course, just like course 1
$course_menu_id = optional_param('coursemenuid', 0, PARAM_INT);


$COURSE_MENU = new course_menu($course_menu_id);

$context = context_block::instance($COURSE_MENU->get_instance());

$PAGE->set_url(new moodle_url('/blocks/course_menu/import?id=&coursemenuid=' . $course_menu_id));
$PAGE->set_title(get_string('import', 'block_course_menu'));
$PAGE->set_heading(get_string('import', 'block_course_menu'));

$formdata = new stdClass();
$formdata->coursemenuid = $course_menu_id;
$formdata->instanceid = $COURSE_MENU->get_instance();

$mform = new import(null, array('formdata' => $formdata));

if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect($CFG->wwwroot . '/blocks/course_menu/menu_builder.php?id=' . $course_menu_id);
} else if ($data = $mform->get_data()) {

    // Delete all sections and buttons for this course menu
    $DB->delete_records('block_course_menu_section', ['coursemenuid' => $data->coursemenuid]);
    $DB->delete_records('block_course_menu_button', ['coursemenuid' => $data->coursemenuid]);

    $sections = json_decode($mform->get_file_content('file'));
//    print_object('&nbsp;');
//    print_object('&nbsp;');
//    print_object('&nbsp;');
//    print_object('&nbsp;');
//    print_object($data);
//
    $COURSE_MENU = new course_menu($data->coursemenuid);

    $mods = $COURSE_MENU->get_mods($COURSE_MENU->get_courseid());

    foreach ($sections as $section) {
        $buttons = $section->buttons;
        unset($section->id);
        unset($section->buttons);
        $section->coursemenuid = $data->coursemenuid;
        // If image is from plugin, remove the plugin path
        if (strpos($section->image, '/blocks/course_menu/images/') !== false) {
            $section->image = str_replace(
                '/blocks/course_menu/',
                '',
                strstr($section->image,'/blocks/course_menu/images/', false)
            );
        }

        $mods = $COURSE_MENU->get_mods($COURSE_MENU->get_courseid());
        $new_section_id = $DB->insert_record('block_course_menu_section', $section);
        foreach ($buttons as $button) {
            unset($button->id);
            unset($button->coursemenuidid);
            $button->coursemenuid = $data->coursemenuid;
            // If image is from plugin, remove the plugin path
            if (strpos($button->image, '/blocks/course_menu/images/') !== false) {
                $button->image = str_replace(
                    '/blocks/course_menu/',
                    '',
                    strstr($button->image,'/blocks/course_menu/images/', false)
                );
            }
            foreach($mods as $mod){
                if($mod->modname == $button->mod_name && $mod->name == $button->mod_title){
                    $button->cmid = $mod->id;
                    break;
                }
            }

            $new_button_id = $DB->insert_record('block_course_menu_button', $button);
        }

    }

    redirect($CFG->wwwroot . '/blocks/course_menu/menu_builder.php?id=' . $data->coursemenuid);
} else {
    //Set form data
    $mform->set_data($mform);
}
//**********************
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();
//**********************
//*** DISPLAY CONTENT **
//**********************
$mform->display();
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();
