<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @description 공통 클래스
 */
class Common {
	/**
	 * @description 전화번호, 생년월일, 사업자번호 하이픈(-) 정규식
	 * @return string
	 */
	public static function format_number($number, $type) {
		$number = preg_replace('/[^0-9]/', '', $number);
		$length = strlen($number);

		switch($type) {
			case 1: // 일반 전화번호 또는 휴대폰번호
				if ($length == 11) {
					return preg_replace("/([0-9]{3})([0-9]{4})([0-9]{4})/", "$1-$2-$3", $number);
					break;
				} else if ($length == 10) {
					return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $number);
					break;
				} else if ($length == 8) {
					return preg_replace("/([0-9]{4})([0-9]{4})/", "$1-$2", $number);
					break;
				}
			case 2: // 생년월일
				return preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "$1-$2-$3", $number);
				break;
			case 3: // 사업자번호
				if ($length == 10) {
					return preg_replace("/([0-9]{3})([0-9]{2})([0-9]{5})/", "$1-$2-$3", $number);
					break;
				} else if ($length == 13) {
					return preg_replace("/([0-9]{4})([0-9]{2})([0-9]{6})([0-9]{1})/", "$1-$2-$3-$4", $number);
					break;
				}
			default:
				return $number;
				break;
		}
	}

	/**
	 * @description ikey row
	 */
	public static function get_column($table, $ikey, $column) {
		$ci =& get_instance();
		$ci->load->model('Common_m');

		if (isset($table) && isset($ikey) && isset($column)) {
			$result = $ci->Common_m->get_column($table, $ikey, $column);
			return $result;
		} else {
			return '';
		}
	}

	/**
	 * @description data row
	 */
	public static function get_column2($table, $data, $column) {
		$ci =& get_instance();
		$ci->load->model('Common_m');

		if (isset($table) && isset($data) && isset($column)) {
			$result = $ci->Common_m->get_column2($table, $data, $column);
			return $result;
		} else {
			return '';
		}
	}

	/**
	 * @description date customize
	 */
	public static function my_date($date) {
		if ($date != null || $date != '') {
			$date = date('Y-m-d', strtotime($date));
		} else {
			$date = '';
		}
		return $date;
	}

	/**
	 * @description send email
	 */
	public static function send_email($to, $title, $contents) {
		$ci =& get_instance();
		$ci->load->library('email');

		$config['smtp_host'] = "smtp.daum.net"; 		// 스마트웍스
        $config['smtp_user'] = "taggingbox_mast";	// daum 계정
        $config['smtp_pass'] = "f9hvtGpUCXKA";			// daum 비밀번호
        $config['smtp_port'] = "465";
        $config['smtp_crypto'] = "tls";         
        $config['charset']  = 'utf-8';
        $config['newline']  = "\r\n";

		$ci->email->initialize($config);
		$ci->email->from('mail@taggingbox.io', 'TEXTWAY');	// 보내는 메일주소, 보내는 사람명
		$ci->email->to($to);
		$ci->email->subject($title);
		$ci->email->message($contents);
		if (!$ci->email->send()) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * @description pagination customize
	 * @see manual http://www.ciboard.co.kr/user_guide/kr/libraries/pagination.html
	 */
	public static function my_pagination($p, $s='', $title, $val, $kind) {
		$ci =& get_instance();
		$ci->load->model('Common_m');
		$ci->load->model($kind.'_m');

		$config = array();
		$config['base_url'] = base_url().$p['site_url'];
		$search = $p['s'];

		if ($search == 't') {
			// switch ($kind) {
			// 	case 'Notice':
			// 		$config['total_rows'] = $ci->Notice_m->get_search_count($title, $val);
			// 	break;
			// }

			$config['reuse_query_string'] = FALSE;
			$config['suffix'] = '?'.$_SERVER['QUERY_STRING'];
			$config['first_url'] = $config['base_url'].$config['suffix'];
		} else {
			$config['total_rows'] = $ci->Common_m->get_count($p['table'], $p['where']);
		}

		$data['total_cnt'] = $config['total_rows'];
		$config['per_page'] = $p['per_page'];
		$config['uri_segment'] = $p['uri_segment'];

		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = '<<';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '>>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_link'] = FALSE;
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = FALSE;
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['num_links'] = $p['num_links'];

		$ci->pagination->initialize($config);
		$page = ($ci->uri->segment($p['uri_segment'])) ? $ci->uri->segment($p['uri_segment']) : 0;
		$data['links'] = $ci->pagination->create_links();

		/**
		 * @param limit, offset
		 */
		if ($search == 't') {
			// switch($kind) {
			// 	case 'Notice':
			// 		$data['list'] = $ci->Notice_m->get_search_list($page, $config['per_page'], $title, $val);
			// 	break;
			// }
		} else {
			$data['list'] = $ci->Common_m->get_list($p['table'], $config['per_page'], $page, $p['where']);
		}

		// header, asize 디자인 유지용 파라미터
		$data['site_url'] = $p['site_url'];
		$data['title'] = $p['title'];
		$data['page'] = $page;

		$data['params'] = $s;

		return $data;
	}
}