<?php

require_once('../../config.php');
require_once($CFG->dirroot . "/blocks/course_menu/classes/forms/button.php");

use block_course_menu\course_menu;

global $CFG, $USER, $PAGE, $SITE, $DB, $OUTPUT;
require_login(1, false); //Use course 1 because this has nothing to do with an actual course, just like course 1
$id = optional_param('id', 0, PARAM_INT);
$sectionid = required_param('sectionid', PARAM_INT);
$coursemenuid = required_param('coursemenuid', PARAM_INT);

$COURSE_MENU = new course_menu($coursemenuid);
$context = context_block::instance($COURSE_MENU->get_instance());

$PAGE->set_url($CFG->wwwroot . '/blocks/course_menu/edit_buttonphp?id=' . $id . '&coursemenuid=' . $coursemenuid . '&sectionid=' . $sectionid);
$PAGE->set_title(get_string('menu_button', 'block_course_menu'));
$PAGE->set_heading(get_string('menu_button', 'block_course_menu'));
// Load JS
$PAGE->requires->js_call_amd('block_course_menu/button', 'init');

if ($id) {
    $formdata = $DB->get_record('block_course_menu_buttons', ['id' => $id]);
    $formdata->instanceid = $COURSE_MENU->get_instance();
    $formdata->buttonstylegroup['button_type'] = $formdata->button_type;
    $formdata->imagegroup['image'] = $formdata->image;
    $formdata->icongroup['icon'] = $formdata->icon;
    $formdata->iconbgcolorgroup['icon_bg_color'] = $formdata->icon_bg_color;
    $formdata->coursemenuid = $coursemenuid;
    $formdata->module = $formdata->cmid . '|' . $formdata->mod_name . '|' . $formdata->mod_title;
} else {
    $formdata = new stdClass();
    $formdata->coursemenuid = $coursemenuid;
    $formdata->instanceid = $COURSE_MENU->get_instance();
    $formdata->buttonstylegroup['button_type'] = 'btn-secondary';
    $formdata->lang = current_language();
    $formdata->display_title = true;
    $formdata->sectionid = $sectionid;
    $formdata->iconbgcolorgroup['icon_bg_color'] = '#8e8d8d';
}


$background_draft_item_id = file_get_submitted_draft_itemid('background_filemanager');
file_prepare_draft_area(
    $background_draft_item_id,
    $context->id,
    'block_course_menu',
    'button_background',
    $id,
    [
        'subdirs' => 0,
        'maxbytes' => 104857600,
        'maxfiles' => 1,
    ]
);

$formdata->background_filemanager = $background_draft_item_id;

$image_draft_item_id = file_get_submitted_draft_itemid('image_filemanager');
file_prepare_draft_area(
    $image_draft_item_id,
    $context->id,
    'block_course_menu',
    'button_image',
    $id,
    [
        'subdirs' => 0,
        'maxbytes' => 104857600,
        'maxfiles' => 1,
    ]
);

$formdata->image_filemanager = $image_draft_item_id;

$mform = new button(null, array('formdata' => $formdata));

if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect($CFG->wwwroot . '/blocks/course_menu/menu_builder.php?id=' . $coursemenuid);
} else if ($data = $mform->get_data()) {
    $sortorder = 1;
    if ($buttons = $DB->count_records('block_course_menu_buttons', ['sectionid' => $data->sectionid])) {
        $sortorder = $buttons + 1;
    }
    $data->image = $data->imagegroup['image'];
    $data->icon = $data->icongroup['icon'];
    $data->icon_bg_color = $data->iconbgcolorgroup['icon_bg_color'];
    // No longer these fields
    unset($data->imagegroup);
    unset($data->icongroup);
    unset($data->iconbgcolorgroup);

    // Split module into proper fields
    $module = explode('|', $data->module);
    $data->cmid = $module[0];
    $data->mod_name = $module[1];
    $data->mod_title = $module[2];
    unset($data->module);

    if ($data->id) {
        $id = $data->id;
        $data->timemodified = time();
        $data->usermodified = $USER->id;
        $DB->update_record('block_course_menu_buttons', $data);
    } else {
        $data->sortorder = $sortorder;
        $data->timecreated = time();
        $data->timemodified = time();
        $data->usermodified = $USER->id;
        $id = $DB->insert_record('block_course_menu_buttons', $data);
    }

    file_save_draft_area_files(
    // The $data->attachments property contains the itemid of the draft file area.
        $data->background_filemanager,

        // The combination of contextid / component / filearea / itemid
        // form the virtual bucket that file are stored in.
        $context->id,
        'block_course_menu',
        'button_background',
        $id,

        [
            'subdirs' => 0,
            'maxbytes' => 104857600,
            'maxfiles' => 1,
        ]
    );

    file_save_draft_area_files(
    // The $data->attachments property contains the itemid of the draft file area.
        $data->image_filemanager,

        // The combination of contextid / component / filearea / itemid
        // form the virtual bucket that file are stored in.
        $context->id,
        'block_course_menu',
        'button_image',
        $id,

        [
            'subdirs' => 0,
            'maxbytes' => 104857600,
            'maxfiles' => 1,
        ]
    );

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
