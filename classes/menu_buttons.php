<?php
/*
 * Author: Admin User
 * Create Date: 31-03-2023
 * License: LGPL 
 * 
 */
namespace block_course_menu;

use block_course_menu\crud;

class menu_buttons extends crud {


	/**
	 *
	 *@var int
	 */
	private $id;

	/**
	 *
	 *@var int
	 */
	private $sectionid;

	/**
	 *
	 *@var string
	 */
	private $lang;

	/**
	 *
	 *@var string
	 */
	private $title;

	/**
	 *
	 *@var string
	 */
	private $icon;

	/**
	 *
	 *@var int
	 */
	private $cmid;

	/**
	 *
	 *@var string
	 */
	private $mod_title;

	/**
	 *
	 *@var string
	 */
	private $url;

	/**
	 *
	 *@var int
	 */
	private $use_image;

	/**
	 *
	 *@var string
	 */
	private $styles;

	/**
	 *
	 *@var int
	 */
	private $sortorder;

	/**
	 *
	 *@var int
	 */
	private $usermodified;

	/**
	 *
	 *@var int
	 */
	private $timecreated;

	/**
	 *
	 *@var string
	 */
	private $timecreated_hr;

	/**
	 *
	 *@var int
	 */
	private $timemodified;

	/**
	 *
	 *@var string
	 */
	private $timemodified_hr;

	/**
	 *
	 *@var string
	 */
	private $table;


    /**
     *  
     *
     */
	public function __construct($id = 0){
  	global $CFG, $DB, $DB;

		$this->table = 'block_course_menu_buttons';

		parent::set_table($this->table);

      if ($id) {
         $this->id = $id;
         parent::set_id($this->id);
         $result = $this->get_record($this->table, $this->id);
      } else {
        $result = new \stdClass();
         $this->id = 0;
         parent::set_id($this->id);
      }

		$this->sectionid = $result->sectionid ?? 0;
		$this->lang = $result->lang ?? '';
		$this->title = $result->title ?? '';
		$this->icon = $result->icon ?? '';
		$this->cmid = $result->cmid ?? 0;
		$this->mod_title = $result->mod_title ?? '';
		$this->url = $result->url ?? '';
		$this->use_image = $result->use_image ?? 0;
		$this->styles = $result->styles ?? '';
		$this->sortorder = $result->sortorder ?? 0;
		$this->usermodified = $result->usermodified ?? 0;
		$this->timecreated = $result->timecreated ?? 0;
          $this->timecreated_hr = '';
          if ($this->timecreated) {
		        $this->timecreated_hr = strftime(get_string('strftimedate'),$result->timecreated);
          }
		$this->timemodified = $result->timemodified ?? 0;
      $this->timemodified_hr = '';
          if ($this->timemodified) {
		        $this->timemodified_hr = strftime(get_string('strftimedate'),$result->timemodified);
          }
	}

	/**
	 * @return id - bigint (18)
	 */
	public function get_id(){
		return $this->id;
	}

	/**
	 * @return sectionid - bigint (18)
	 */
	public function get_sectionid(){
		return $this->sectionid;
	}

	/**
	 * @return lang - varchar (6)
	 */
	public function get_lang(){
		return $this->lang;
	}

	/**
	 * @return title - varchar (255)
	 */
	public function get_title(){
		return $this->title;
	}

	/**
	 * @return icon - varchar (50)
	 */
	public function get_icon(){
		return $this->icon;
	}

	/**
	 * @return cmid - bigint (18)
	 */
	public function get_cmid(){
		return $this->cmid;
	}

	/**
	 * @return mod_title - varchar (255)
	 */
	public function get_mod_title(){
		return $this->mod_title;
	}

	/**
	 * @return url - varchar (1333)
	 */
	public function get_url(){
		return $this->url;
	}

	/**
	 * @return use_image - tinyint (2)
	 */
	public function get_use_image(){
		return $this->use_image;
	}

	/**
	 * @return styles - varchar (255)
	 */
	public function get_styles(){
		return $this->styles;
	}

	/**
	 * @return sortorder - smallint (4)
	 */
	public function get_sortorder(){
		return $this->sortorder;
	}

	/**
	 * @return usermodified - bigint (18)
	 */
	public function get_usermodified(){
		return $this->usermodified;
	}

	/**
	 * @return timecreated - bigint (18)
	 */
	public function get_timecreated(){
		return $this->timecreated;
	}

	/**
	 * @return timemodified - bigint (18)
	 */
	public function get_timemodified(){
		return $this->timemodified;
	}

	/**
	 * @param Type: bigint (18)
	 */
	public function set_id($id){
		$this->id = $id;
	}

	/**
	 * @param Type: bigint (18)
	 */
	public function set_sectionid($sectionid){
		$this->sectionid = $sectionid;
	}

	/**
	 * @param Type: varchar (6)
	 */
	public function set_lang($lang){
		$this->lang = $lang;
	}

	/**
	 * @param Type: varchar (255)
	 */
	public function set_title($title){
		$this->title = $title;
	}

	/**
	 * @param Type: varchar (50)
	 */
	public function set_icon($icon){
		$this->icon = $icon;
	}

	/**
	 * @param Type: bigint (18)
	 */
	public function set_cmid($cmid){
		$this->cmid = $cmid;
	}

	/**
	 * @param Type: varchar (255)
	 */
	public function set_mod_title($mod_title){
		$this->mod_title = $mod_title;
	}

	/**
	 * @param Type: varchar (1333)
	 */
	public function set_url($url){
		$this->url = $url;
	}

	/**
	 * @param Type: tinyint (2)
	 */
	public function set_use_image($use_image){
		$this->use_image = $use_image;
	}

	/**
	 * @param Type: varchar (255)
	 */
	public function set_styles($styles){
		$this->styles = $styles;
	}

	/**
	 * @param Type: smallint (4)
	 */
	public function set_sortorder($sortorder){
		$this->sortorder = $sortorder;
	}

	/**
	 * @param Type: bigint (18)
	 */
	public function set_usermodified($usermodified){
		$this->usermodified = $usermodified;
	}

	/**
	 * @param Type: bigint (18)
	 */
	public function set_timecreated($timecreated){
		$this->timecreated = $timecreated;
	}

	/**
	 * @param Type: bigint (18)
	 */
	public function set_timemodified($timemodified){
		$this->timemodified = $timemodified;
	}

}