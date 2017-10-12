<?php
 
	ob_start();
	include('index.php');
	ob_end_clean();
	$CI =& get_instance();
	$CI->load->library('session'); //if it's not autoloaded in your CI setup

	print_r($CI->session->userdata);
	echo "<br />";
	print_r($_SESSION); 
	
	//print_r($MY_SESSION);
?>