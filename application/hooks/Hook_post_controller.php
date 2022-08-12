<?php
class Hook_post_controller {
	private $CI;

	function __construct() {
		$this->CI =& get_instance();
	}

	function load_config() {
		$this->CI->load->database();
		$this->CI->load->helper(array('form', 'url', 'alert', 'common'));
		$this->CI->load->library(array('pagination', 'session', 'form_validation', 'Common'));
	}
}