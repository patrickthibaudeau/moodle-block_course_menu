<?php

require_once( '../../config.php');

require_login(1, false);

global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

$course_menu_id = required_param('coursemenuid', PARAM_INT);

use block_course_menu\course_menu;

$COURSE_MENU = new course_menu($course_menu_id);
$course = $DB->get_record('course', ['id' => $COURSE_MENU->get_courseid()]);

$data = json_encode($COURSE_MENU->get_menu_data());

$filename = $course->shortname . '_course_menu.json';

header('Content-disposition: attachment; filename=' . $filename);
header('Content-type: application/json');

echo $data;