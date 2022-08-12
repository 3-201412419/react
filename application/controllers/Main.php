<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

/**
 * @description 메인 컨트롤러
 * @author 김효진, @version 1.0
 */
class Main extends CI_Controller {
	public function __construct() {
		parent::__construct();

	}

	public function index() {
		$this->load->view('include/head');
		// $this->load->view('include/header');

		$this->load->view('main');
	}

	


}
