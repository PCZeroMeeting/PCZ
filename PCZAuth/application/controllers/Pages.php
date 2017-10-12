<?php
class Pages extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
		$this->load->add_package_path(APPPATH.'third_party/ion_auth/');
		$this->load->library('ion_auth');
		/*
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}*/
		/*
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');*/
	}
	
	public function Displaylinks($data = '')
	{ 
		$widgetid = $this->input->get('widgetid', TRUE); 
 
		if(!empty($widgetid)){
			$data["widgetid"] = $widgetid;
		}
			
        $this->load->view('templates/header', $data);
        $this->load->view('pages/home', $data);
        $this->load->view('templates/footer');
	}	

	
	public function view($page = 'home')
	{
			if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
			{
					// Whoops, we don't have a page for that!
					show_404();
			}

			$data['title'] = ucfirst($page); // Capitalize the first letter

			$this->load->view('templates/header', $data);
			$this->load->view('pages/'.$page, $data);
			$this->load->view('templates/footer', $data);
	}
}