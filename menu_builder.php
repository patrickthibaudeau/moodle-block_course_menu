<?php
/**
 * *************************************************************************
 * *                           YULearn ELMS                               **
 * *************************************************************************
 * @package     local                                                     **
 * @subpackage  yulearn                                                   **
 * @name        YULearn ELMS                                              **
 * @copyright   UIT - Innovation lab & EAAS                               **
 * @link                                                                  **
 * @author      Patrick Thibaudeau                                        **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */

require_once( '../../config.php');

global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

$id = optional_param('id', 0, PARAM_INT); //Block Instance ID
$courseid = optional_param('courseid', 0, PARAM_INT); //Block Instance ID

$context = context_block::instance($id);

if (!has_capability('block/course_menu:edit', $context)) {
    redirect($CFG->wwwroot, get_string('nopermissions', 'block_course_menu'));
}

require_login(1, false); //Use course 1 because this has nothing to do with an actual course, just like course 1

$PAGE->set_url('/blocks/course_menu/menu_builder.ph', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_title(get_string('menu_builder', 'block_course_menu'));
$PAGE->set_heading(get_string('menu_builder', 'block_course_menu'));

$PAGE->requires->js_call_amd('block_course_menu/menu_builder', 'init');;

// Get renderable content.
$output = $PAGE->get_renderer('block_course_menu');
$menu = new \block_course_menu\output\menu_builder($id, $courseid);
echo $OUTPUT->header();

echo $output->render_menu_builder($menu);

echo $OUTPUT->footer();


