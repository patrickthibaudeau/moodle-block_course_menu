<?php

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->dirroot/lib/formslib.php");

/**
 * Module instance settings form
 */
class import extends moodleform
{

    function definition()
    {

        global $CFG, $USER, $DB, $PAGE;
        $formdata = $this->_customdata['formdata'];
        $mform = &$this->_form;

        $context = context_block::instance($formdata->instanceid);

        $course_modules = $this->get_mods($context->get_course_context()->instanceid);
        $modules = [];
        $modules [''] = get_string('select_module', 'block_course_menu');
        foreach ($course_modules as $cm) {
            $modules[$cm->id . '|' . $cm->modname . '|' . $cm->name] = $cm->name . ' (' . $cm->pluginname . ')';
        }

//-------------------------------------------------------------------------------

        $mform->addElement("hidden", "coursemenuid");
        $mform->setType("coursemenuid", PARAM_INT);

        $mform->addElement('filepicker', 'file', get_string('file'), null,
            array('maxbytes' => $CFG->maxbytes, 'accepted_types' => '.json'));


// add standard buttons, common to all modules
        $this->add_action_buttons();

// set the defaults
        $this->set_data($formdata);
    }

    /**
     * Validate the form data.
     * @param array $data
     * @param array $files
     * @return array|bool
     */
    public function validation($data, $files)
    {
        global $CFG, $DB;
        $err = [];

        $data = (object)$data;
//        if ($data->id == 0) {
//            if ($exists = $DB->get_record('yulearn_hrbp', ['userid' => $data->userid])) {
//                $err['userid'] = get_string('user_has_record', 'local_yulearn', $CFG->wwwroot . '/local/yulearn/admin/edithrbp.php?id=' . $exists->id);
//            }
//        }

        if (count($err) == 0) {
            return true;
        } else {
            return $err;
        }
    }

    /**
     * Returns array course modules. Excludes labels and modules in the process of being deleted.
     * @param $courseid
     * @return array
     * @throws coding_exception
     * @throws moodle_exception
     */
    private function get_mods($courseid)
    {
        global $CFG, $DB;
        include_once($CFG->dirroot . '/question/editlib.php');
        $mods = get_fast_modinfo($courseid);
        $sections = $mods->get_sections();
        $modules = [];
        $i = 0;
        foreach ($sections as $section) {
            foreach ($section as $key => $cmid) {
                $module = get_module_from_cmid($cmid);
                // Do not add modules in deletion progress
                if ($module[1]->deletioninprogress != 1) {
                    // Only add modules that are not labels
                    if ($module[1]->modname != 'label') {
                        // Create module object
                        $data = new stdClass();
                        $data->section = $key;
                        $data->id = $module[1]->id;
                        $data->instance = $module[1]->instance;
                        $data->modname = $module[1]->modname;
                        $data->name = $module[1]->name;
                        $data->pluginname = get_string('pluginname', $module[1]->modname);
                        // Add module to array
                        $modules[$i] = $data;
                        unset($data);
                        $i++;
                    }
                }
            }
        }

        return $modules;
    }

}
