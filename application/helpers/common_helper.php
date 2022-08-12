<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

/**
 * @description call toast
 */
function toast($msg = '', $sticky = '', $type = '') {
	echo '<script src="/public/js/jquery-1.12.0.min.js"></script>';
	echo '<script src="/public/js/jquery.toast.js"></script>';
	echo '<link rel="stylesheet" href="/public/css/jquery.toast.css">';
	echo "
		<script type='text/javascript'>
			$(function() {
				$.toast.config.align = 'right';
				$.toast.config.width = 400;
				$.toast('".$msg."', {sticky: Boolean('".$sticky."'), type: '".$type."'});
			});
		</script>
	";
}

/**
 * @description call bpopup
 */
function bpopup($class = '') {
	echo '<script src="/public/js/jquery.bpopup.min.js"></script>';
	echo '<script src="/public/js/common.js?<?=time()?>"></script>';
	echo "
		<script type='text/javascript'>
			$(function() {
				$('".$class."').bPopup({
					modalClose: false,
					opacity: 0.8,
					positionStyle: 'absolute',
					speed: 300,
					transition: 'fadeIn',
					transitionClose: 'fadeOut',
					zIndex: 99997,
					// modalColor: 'transparent'
				});
			});
		</script>
	";
}

/**
 * @description location replace
 * @param $url
 */
function replace($url = '/') {
	echo '
		<script type="text/javascript">
			window.location.replace("'.$url.'");
		</script>
	';
}

function locate_url($url) {
	echo '
		<script type="text/javascript">
			if (history.replaceState) {
				history.replaceState(null, document.title, "'.$url.'");
				history.go(0);
			} else {
				location.replace("'.$url.'");
			}
		</script>
	';
}