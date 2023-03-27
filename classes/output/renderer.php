<?php
namespace block_course_menu\output;

class renderer extends \plugin_renderer_base {
    /**
     *
     * @param \templatable $branchList
     * @return type
     */
    public function render_block(\templatable $userInfo) {
        $data = $userInfo->export_for_template($this);
        return $this->render_from_template('block_course_menu/block', $data);
    }
}