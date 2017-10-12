<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Form_validation extends CI_Form_validation {
 
	protected $CI;
 
	function __construct()
	{
		parent::__construct();
 
		$this->CI =& get_instance();
	}
	
	public function fraction($str)
	{
		$this->CI->form_validation->set_message('fraction', 'The %s field must be a valid fraction.');
	 
		return ( ! preg_match("/^(\d++(?! */))? *-? *(?:(\d+) */ *(\d+))?.*$/", $str)) ? FALSE : TRUE;
	}
	
	public function valid_url($str)
	{
		$this->CI->form_validation->set_message('valid_url', 'The %s field must be a valid url..');
		
		if (filter_var($str, FILTER_VALIDATE_URL) === FALSE) {
			return FALSE;
		}		
		
		return TRUE;
	}
}