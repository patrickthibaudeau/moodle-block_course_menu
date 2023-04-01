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

    /**
     *
     * @param \templatable $branchList
     * @return type
     */
    public function render_menu_builder(\templatable $userInfo) {
        $data = $userInfo->export_for_template($this);
        return $this->render_from_template('block_course_menu/menu_builder', $data);
    }

    /**
     *
     * @param \templatable $branchList
     * @return type
     */
    public function render_icons(\templatable $icons) {
        $data = $icons->export_for_template($this);
        return $this->render_from_template('block_course_menu/icon_modal', $data);
    }

    /**
     *
     * @param \templatable $branchList
     * @return type
     */
    public function render_images(\templatable $images) {
        $data = $images->export_for_template($this);
        return $this->render_from_template('block_course_menu/image_modal', $data);
    }

    /**
     *
     * @param \templatable $branchList
     * @return type
     */
    public function render_buttons(\templatable $buttons) {
        $data = $buttons->export_for_template($this);
        return $this->render_from_template('block_course_menu/button_modal', $data);
    }
}