<?php 
function admin_url($url = '') {
	$CI = & get_instance();
	$admin_url = trim($CI->config->item('admin_url'), '/');
	return $admin_url . '/' . trim($url, '/');
}
