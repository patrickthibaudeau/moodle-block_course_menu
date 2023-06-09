<?php

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->dirroot/lib/formslib.php");

/**
 * Module instance settings form
 */
class section extends moodleform
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
//-------------------------------------------------------------------------------
        $mform->addElement("hidden", "id");
        $mform->setType("id", PARAM_INT);
        $mform->addElement("hidden", "coursemenuid");
        $mform->setType("coursemenuid", PARAM_INT);
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

        $mform->addElement('header', 'general', get_string('course'));

        // Language
//        $mform->addElement('select', 'lang', get_string('language', 'block_course_menu'), $languages);
//        $mform->setType('lang', PARAM_TEXT);

        // Title
        $mform->addElement('text', 'title', get_string('title', 'block_course_menu'));
        $mform->setType('title', PARAM_TEXT);
        $mform->addRule('title', get_string('field_required', 'block_course_menu'), 'required', null, 'client');

        // Show Title
        $mform->addElement('selectyesno', 'display_title', get_string('show_title', 'block_course_menu'));
        $mform->setType('display_title', PARAM_INT);

        // Text color
        $text_colors = [
            '#000000' => get_string('black', 'block_course_menu'),
            '#FFFFFF' => get_string('white', 'block_course_menu'),
            '#FFFF00' => get_string('yellow', 'block_course_menu'),
            '#FF00FF' => get_string('magenta', 'block_course_menu'),
            '#FF0000' => get_string('red', 'block_course_menu'),
            '#00FFFF' => get_string('cyan', 'block_course_menu'),
            '#00FF00' => get_string('lime', 'block_course_menu'),
            '#0000FF' => get_string('blue', 'block_course_menu'),
        ];
        $mform->addElement('select','text_color',
            get_string('text_color', 'block_course_menu'), $text_colors);
        $mform->setType('text_color', PARAM_TEXT);

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

        // Icon
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

}
