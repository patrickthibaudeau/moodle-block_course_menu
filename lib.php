<?php



function block_course_menu_pluginfile($course, $birecord_or_cm, $context, $filearea, $args, $forcedownload, array $options = array())
{
    global $CFG, $USER, $DB;

    if ($context->contextlevel != CONTEXT_BLOCK) {
        send_file_not_found();
    }


    // If block is in course context, then check if user has capability to access course.
    if ($context->get_course_context(false)) {
        require_course_login($course);
    } else if ($CFG->forcelogin) {
        require_login();
    } else {
        // Get parent context and see if user have proper permission.
        $parentcontext = $context->get_parent_context();
        if ($parentcontext->contextlevel === CONTEXT_COURSECAT) {
            // Check if category is visible and user can view this category.
            if (!core_course_category::get($parentcontext->instanceid, IGNORE_MISSING)) {
                send_file_not_found();
            }
        } else if ($parentcontext->contextlevel === CONTEXT_USER && $parentcontext->instanceid != $USER->id) {
            // The block is in the context of a user, it is only visible to the user who it belongs to.
            send_file_not_found();
        }
        // At this point there is no way to check SYSTEM context, so ignoring it.
    }

    $fileAreas = array(
        'section_background',
        'section_image',
        'button_background',
        'button_image'
    );

    if (!in_array($filearea, $fileAreas)) {
        return false;
    }


    $itemid = array_shift($args);
    $filename = array_pop($args);
    $path = !count($args) ? '/' : '/' . implode('/', $args) . '/';

    $fs = get_file_storage();

    $file = $fs->get_file($context->id, 'block_course_menu', $filearea, $itemid, $path, $filename);

    // If the file does not exist.
    if (!$file) {
        send_file_not_found();
    }

    send_stored_file($file, 86400, 0, $forcedownload); // Options.
}