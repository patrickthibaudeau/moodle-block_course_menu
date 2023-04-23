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

require_once('../../config.php');

global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false); //Use course 1 because this has nothing to do with an actual course, just like course 1

$PAGE->set_url('/blocks/course_menu/menu_builder.ph', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_title(get_string('menu_builder', 'block_course_menu'));
$PAGE->set_heading(get_string('menu_builder', 'block_course_menu'));

echo $OUTPUT->header();

$sql = "SELECT 
             cm.id as coursemenuid,
            cms.id as coursemenusectionid,
            cms.sortorder as sectionorder
        FROM 
            {block_course_menu} cm Inner Join
            {block_course_menu_section} cms On cm.id = cms.coursemenuid";
$menus = $DB->get_recordset_sql($sql, []);
foreach ($menus as $menu) {
    if ($buttons = $DB->get_records('block_course_menu_button',['sectionorder' => $menu->coursemenusectionid])) {
        foreach($buttons as $button) {

            $params = [
                'id' => $button->id,
                'coursemenuid' => $menu->coursemenuid,
                'sectionorder' => $menu->sectionorder,
            ];
            $DB->update_record('block_course_menu_button', $params);
        }
    }
}

echo $OUTPUT->footer();


