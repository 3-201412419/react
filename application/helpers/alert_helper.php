<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

/**
 * @description output msg, location replace
 * @param $msg, $url
 */
function alert($msg = '', $url = '') {
	echo '
		<script type="text/javascript">
			alert("'.$msg.'");
			location.replace("'.$url.'");
		</script>
	';
}

/**
 * @description alert_only
 * @param $msg
 */
function alert_only($msg = '') {
	echo '<script type="text/javascript">alert("'.$msg.'");</script>';
}

/**
 * @description window close
 * @param $msg
 */
function alert_close($msg) {
	echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
	echo '<script type="text/javascript">alert("'.$msg.'"); window.close();</script>';
	exit;
}