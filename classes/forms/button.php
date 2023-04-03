<?php

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->dirroot/lib/formslib.php");

/**
 * Module instance settings form
 */
class button extends moodleform
{

    function definition()
    {

        global $CFG, $USER, $DB, $PAGE;
        $formdata = $this->_customdata['formdata'];
        $mform = &$this->_form;

        $languages = get_string_manager()->get_list_of_translations();
        $icons = [
            'fa-align-left' => '&#xf036; fa-align-left',
        ];


        $context = context_block::instance($formdata->instanceid);


        $course_modules = $this->get_mods($context->get_course_context()->instanceid);
        $modules = [];
        $modules [''] = get_string('select_module', 'block_course_menu');
        foreach ($course_modules as $cm) {
            $modules[$cm->id . '|' . $cm->modname . '|' . $cm->name] = $cm->name . ' (' . $cm->pluginname . ')';
        }

//-------------------------------------------------------------------------------
        $mform->addElement("hidden", "id");
        $mform->setType("id", PARAM_INT);
        $mform->addElement("hidden", "coursemenuid");
        $mform->setType("coursemenuid", PARAM_INT);
        $mform->addElement("hidden", "sectionid");
        $mform->setType("sectionid", PARAM_INT);
        // Get renderable content.
        $output = $PAGE->get_renderer('block_course_menu');
        $icons = new \block_course_menu\output\icons($output);
        $mform->addElement('html', $output->render($icons));
        // Images
        $images = new \block_course_menu\output\images($output);
        $mform->addElement('html', $output->render($images));
        // Buttons
        $buttons = new \block_course_menu\output\buttons($output);
        $mform->addElement('html', $output->render($buttons));
        // Colors
        $colors = new \block_course_menu\output\icon_bg_color($output);
        $mform->addElement('html', $output->render($colors));

        $mform->addElement('header', 'general', get_string('general'));

        // Language
//        $mform->addElement('select', 'lang', get_string('language', 'block_course_menu'), $languages);
//        $mform->setType('lang', PARAM_TEXT);

        // Title
        $mform->addElement('text', 'title', get_string('title', 'block_course_menu'));
        $mform->setType('title', PARAM_TEXT);
        $mform->addRule('title', get_string('field_required', 'block_course_menu'), 'required');

        // Show Title
        $mform->addElement('selectyesno', 'display_title', get_string('show_title', 'block_course_menu'));
        $mform->setType('display_title', PARAM_INT);

        // Link to activity
        $mform->AddElement('select', 'module', get_string('link_activity', 'block_course_menu'), $modules);
        $mform->setType('module', PARAM_TEXT);
        $mform->addRule('module', get_string('field_required', 'block_course_menu'), 'required');

        // Button style
        $button_array = [];
        $button_array[] =& $mform->createElement('text', 'button_type', null);
        $button_array[] =& $mform->createElement('button', 'btn_button_type', get_string('select'));
        $mform->addGroup($button_array, 'buttonstylegroup', get_string('button_style', 'block_course_menu'));
        $mform->setType('buttonstylegroup[button_type]', PARAM_TEXT);

        // Background image
        $mform->addElement('filemanager', 'background_filemanager',
            get_string('background_image', 'block_course_menu'), null, array('maxbytes' => 104857600,
                'subdirs' => 0,
                'maxfiles' => 1,
                'accepted_types' => array('web_image')));

        // Default Images
        $image_array = [];
        $image_array[] =& $mform->createElement('text', 'image', null);
        $image_array[] =& $mform->createElement('button', 'btn_image', get_string('select'));
        $mform->addGroup($image_array, 'imagegroup', get_string('default_images', 'block_course_menu'));
        $mform->setType('imagegroup[image]', PARAM_TEXT);

        // Icon
        $icon_array = [];
        $icon_array[] =& $mform->createElement('text', 'icon', null);
        $icon_array[] =& $mform->createElement('button', 'btn_icon', get_string('select'));
        $mform->addGroup($icon_array, 'icongroup', get_string('icon', 'block_course_menu'));
        $mform->setType('icongroup[icon]', PARAM_TEXT);

        $icon_bg_color_array = [];
        $icon_bg_color_array[] =& $mform->createElement('text', 'icon_bg_color', null);
        $icon_bg_color_array[] =& $mform->createElement('button', 'btn_icon_bg_color', get_string('select'));
        $mform->addGroup($icon_bg_color_array, 'iconbgcolorgroup', get_string('icon_bg_color', 'block_course_menu'));
        $mform->setType('iconbgcolorgroup[icon_bg_color]', PARAM_TEXT);

        // Image
        $mform->addElement('filemanager', 'image_filemanager',
            get_string('image', 'block_course_menu'), null, array('maxbytes' => 104857600,
                'subdirs' => 0,
                'maxfiles' => 1,
                'accepted_types' => array('web_image')));





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
    private function get_mods($courseid) {
        global $CFG, $DB;
        include_once ($CFG->dirroot.'/question/editlib.php');
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
                        $data->pluginname = get_string('pluginname',$module[1]->modname);
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
