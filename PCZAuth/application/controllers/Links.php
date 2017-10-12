<?php
//require_once(APPPATH.'libraries/Simple_html_dom.php');
//require_once(APPPATH.'libraries/Common.php');

		

class Links extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
		  
		$this->load->add_package_path(APPPATH.'third_party/ion_auth/');		
		$this->load->library('ion_auth'); 
		$this->load->model('weblinksdata_model');
		$this->load->model('widgetsdata_model');
		$this->load->model('reactiondata_model');
		$this->load->helper('url_helper');
		/*
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');*/
	}
	
	public function Index($page = '')
	{
			//if ( ! file_exists(APPPATH.'views/links/'.$page.'.php'))
			//{
					// Whoops, we don't have a page for that!
					//show_404();
			//}
			echo file_get_html('http://www.google.com/')->plaintext;
			//$data['title'] = ucfirst($page); // Capitalize the first letter

			//$this->load->view('templates/header', $data);
			//$this->load->view('pages/'.$page, $data);
			
			
			//$this->load->view('templates/footer', $data);
			

			
	} 
	public function Scrape($data = '')
	{
			if ( ! file_exists(APPPATH.'views/links/scrape.php'))
			{
					// Whoops, we don't have a page for that!
					show_404();
			}

			$plaintText = "";
			
			
			if(empty($data)){
				$data = $this->input->get('data', TRUE);
			}
			

			if(!empty($data)){
				$decodeddata = urldecode($data); 
				$plaintText = file_get_html($decodeddata)->plaintext;
			}

			$data1['plaintText'] = $plaintText;
			//$this->load->view('templates/header', $data);
			$this->load->view('links/scrape', $data1);
						
			//$this->load->view('templates/footer', $data);
	}
 
	public function create()
	{
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$widgetid = $this->input->get('widgetid', TRUE);
		$fullscreenmode = $this->input->get('fullscreenmode', TRUE); 		
		$data['title'] = 'Add Link';

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('link', 'Link', 'required|valid_url');
		//$this->form_validation->set_rules('link', 'Link', 'valid_url');
		$this->form_validation->set_rules('tags', 'Tags', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('priority', 'Priority', 'numeric');
		
		if ($this->form_validation->run() === FALSE)
		{
			$filter = $this->input->get('filter', TRUE); 

			//$this->load->view('templates/header', $data);
			$title = ucwords($this->input->post('title'));
			$tags = strtolower($this->input->post('tags'));
			$link= $this->input->post('link');
			$description = $this->input->post('description');
			$priority= $this->input->post('priority');
			$data['title'] = $title;
			if(!empty($filter))
			{
				if (strpos($tags, $filter) === false) {
					$tags = $tags." ".$filter." hide_this";
				}
			}
			$data['tags'] = $tags;
			$data['link'] = $link;
			$data['description'] = $description;
			$data['priority'] = $priority;
						
			$data['inserted'] = false;
			$data['loadthemes'] = true;
			$data['widgetid'] = $widgetid;
			$data['fullscreenmode'] = $fullscreenmode;
			
			$this->load->view('templates/headerajax', $data);
			$this->load->view('links/create',$data);
			$this->load->view('templates/footerajax');
			//$this->load->view('templates/footer');

		}
		else
		{
			$this->load->helper('url');
			
			$title = ucwords($this->input->post('title'));
			$tags = strtolower($this->input->post('tags'));
			$link= $this->input->post('link');
			$description= $this->input->post('description');
			$priority = $this->input->post('priority');
			//$createdById= $this->input->post('createdById');
			$widgetid = $this->input->post('widgetid');		
			$fullscreenmode = $this->input->post('fullscreenmode');	
			if(empty($createdById)) $createdById = 0;
			$isActive = true;
			$userData = $this->ion_auth->user()->row();

			if(!empty($userData))
			{
				$createdById = $userData->id; 
			}
			$description = nl2br($description);
			
			$this->weblinksdata_model->insert_entry($title,$link,$tags,$description,$createdById,$priority,$isActive);
			$data['inserted'] = true;
			$data['loadthemes'] = true;
			$data['widgetid'] = $widgetid;
			//$this->load->view('templates/header', $data);
			//$this->load->view('links/create_success',$data);
			//$this->load->view('templates/footer');
			$data["success"] = true;
			if($fullscreenmode == 1){
				//redirect('links/displaylinks/'.$widgetid);
				redirect('/?widgetid='.$widgetid, 'refresh');
			}
			else {
				redirect('links/create_success/'.$widgetid);			
			}
		}
	}
	
	public function edit($id = 0)
	{
		
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Edit Link';
		$this->form_validation->set_rules('id', 'Id', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('link', 'Link', 'required|valid_url');
		//$this->form_validation->set_rules('link', 'Link', 'valid_url');
		$this->form_validation->set_rules('tags', 'Tags', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('priority', 'Priority', 'numeric');
		if(empty($id) || $id == 0)
		{
			$id = $this->input->post('id', TRUE); 
		}
		
		if(empty($id) || $id == 0)
		{
			$id = $this->input->get('id', TRUE); 
		}		
		
		$widgetid = $this->input->get('widgetid', TRUE); 
		$fullscreenmode = $this->input->get('fullscreenmode', TRUE); 
		
		if($id > 0)
		{
			$linkData = $this->weblinksdata_model->getWeblinksData($id);
			$id = $linkData->id;
			$title = $linkData->title;
			$tags = $linkData->tags;
			$link = $linkData->link;
			$description = $linkData->description;
			$createdById = $linkData->createdById;
			$priority = $linkData->priority;
			$userData = $this->ion_auth->user()->row();
			if($createdById != $userData->id && !$this->ion_auth->is_admin())
			{
				show_404();	
			}
		}
		else if($id == 0 && !$this->ion_auth->is_admin())
		{
			show_404();
		}
		
		if ($this->form_validation->run() === FALSE)
		{
			//$this->load->view('templates/header', $data); 
			//$title = ucwords($this->input->post('title'));
			//$tags = strtolower($this->input->post('tags'));
			//$link= $this->input->post('link');
			//$description= ucwords($this->input->post('description'));
			$data['id'] = $id;
			$data['title'] = $title;
			$data['tags'] = $tags;
			$data['link'] = $link;
			$data['description'] = $description;
			$data['priority'] = $priority;
			$data['inserted'] = false;
			$data['loadthemes'] = true;
			$data['widgetid'] = $widgetid;
			$data['fullscreenmode'] = $fullscreenmode;
			$this->load->view('templates/headerajax', $data);
			$this->load->view('links/edit',$data);
			$this->load->view('templates/footerajax');
			//$this->load->view('templates/footer');

		}
		else
		{
			$this->load->helper('url'); 
			$id = $this->input->post('id');
			$title = ucwords($this->input->post('title'));
			$tags = strtolower($this->input->post('tags'));
			$link= $this->input->post('link');
			$description= $this->input->post('description');
			$priority = $this->input->post('priority');			
			$widgetid = $this->input->post('widgetid');		
			$fullscreenmode = $this->input->post('fullscreenmode');		
			
			//$createdById= $this->input->post('createdById');			
			if(empty($createdById)) $createdById = 0;
			
			$isActive = true;
			$description = nl2br($description);
			$this->weblinksdata_model->update_entry($id,$title,$link,$tags,$description,$priority,$isActive);
			$data['inserted'] = true;
			$data['loadthemes'] = true;
			$data['widgetid'] = $widgetid;
			//$this->load->view('templates/header', $data);
			//$this->load->view('links/create_success',$data);
			//$this->load->view('templates/footer');
			$data["success"] = true;
			if($fullscreenmode == 1){
				//redirect('links/displaylinks/'.$widgetid);
				redirect('/?widgetid='.$widgetid, 'refresh');
			}
			else {
				redirect('links/create_success/'.$widgetid);
			}
		}
	}
	
		//Get ajax
	public function get_weblink($id = 0)
	{
 		try { 
	  
			if(empty($id) || $id == 0)
			{
				$id = $this->input->post('id', TRUE); 
			}
			
			if(empty($id) || $id == 0)
			{
				$id = $this->input->get('id', TRUE); 
			}	

			if($id == 0)
			{
				echo json_encode(array('issuccess'=>false,'message'=>'Id is required.')); 
				die();
			}
			$weblinksdata = null; 
			
			if($id > 0)
			{
				$weblinksdata = $this->weblinksdata_model->getWeblinksData($id);
			} 
			
			echo json_encode(array('issuccess'=>true,'message'=>'success','data'=>$weblinksdata)); 			
		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			echo json_encode(array('issuccess'=>false,'message'=>$e->getMessage())); 
		}
	}

	public function deleterow($id = 0)
	{
		
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Edit Link';
		$this->form_validation->set_rules('id', 'Id', 'required'); 
		if(empty($id) || $id == 0)
		{
			$id = $this->input->post('id', TRUE); 
		}
		
		if(empty($id) || $id == 0)
		{
			$id = $this->input->get('id', TRUE); 
		}		
		
		if($id > 0)
		{
			$linkData = $this->weblinksdata_model->getWeblinksData($id);
			if(empty($linkData))
			{
				show_404();	
			}
			
			//print_r($linkData);
			
			$id = $linkData->id;
			
			$createdById = $linkData->createdById;
			$userData = $this->ion_auth->user()->row();
			if($createdById != $userData->id && !$this->ion_auth->is_admin())
			{
				show_404();	
			}
		}
		else if($id == 0 && !$this->ion_auth->is_admin())
		{
			show_404();
		}
		
		if ($this->form_validation->run() === FALSE)
		{
			//$this->load->view('templates/header', $data); 
			//$title = ucwords($this->input->post('title'));
			//$tags = strtolower($this->input->post('tags'));
			//$link= $this->input->post('link');
			//$description= ucwords($this->input->post('description'));
			$data['id'] = $id; 
			$data['inserted'] = false;
			$data['loadthemes'] = true;
			
			$this->load->view('templates/headerajax', $data);
			$this->load->view('links/deleterow',$data);
			$this->load->view('templates/footerajax');
			//$this->load->view('templates/footer');

		}
		else
		{
			$this->load->helper('url'); 
			$id = $this->input->post('id');		 
			$createdById= $this->input->post('createdById');			
			if(empty($createdById)) $createdById = 0;
			
			
			$isActive = true;
			
			$this->weblinksdata_model->delete_entry($id);
			$data['inserted'] = true;
			$data['loadthemes'] = true;
			
			//$this->load->view('templates/header', $data);
			//$this->load->view('links/create_success',$data);
			//$this->load->view('templates/footer');
			$data["success"] = true;
			redirect('links/success',$data);			
		}
	}
	
	public function Displaylist()
	{

		$data['link_items'] = $this->weblinksdata_model->getLinks(0,1000);


        $this->load->view('templates/header', $data);
        $this->load->view('links/displaylist', $data);
        $this->load->view('templates/footer');
	}
	
	//here is the start page
	public function Displaylinks($data = '')
	{
		//$_SESSION["LEVI"] = "test";
		//print_r($_SESSION);
		$widgetid = $this->input->get('widgetid', TRUE); 
 
		if(!empty($widgetid)){
			$data["widgetid"] = $widgetid;
		}
			
        $this->load->view('templates/header', $data);
        $this->load->view('links/displaylinks', $data);
        $this->load->view('templates/footer');
	}	

	//Get
	public function GetDisplaylist($page = 0,$rows = 10,$category='',$createdbyid = -1,$filterOut = "",$votingordering="")
	{	
		try { 
	
			$userData = $this->ion_auth->user()->row();
			//$arr = $this->weblinksdata_model->get_last_ten_entries();
			if(empty($page) || empty($rows))
			{
				$page = $this->input->get('page', TRUE);
				$rows = $this->input->get('rows', TRUE);
			}
			if(empty($category))
			{
				$category = $this->input->get('category', TRUE); 
			}
			
			if(empty($filterOut))
			{
				$filterOut = $this->input->get('filterout', TRUE); 
			}			
			
			if(empty($votingordering))
			{
				$votingordering = $this->input->get('votingordering', TRUE); 
			}
			
			if(!empty($userData))
			{
				$createdbyid = $userData->id;
			} 
			
			if(empty($createdbyid) || $createdbyid == -1 )
			{
				//$createdbyid = 0;
				//if(is_int($this->input->get('createdbyid', TRUE)))
				//{
					$createdbyid = intval($this->input->get('createdbyid', TRUE)); 
				//}
			}
			
			
			$arr = $this->weblinksdata_model->getLinksByPageNumber($page,$rows,$category,$createdbyid,$filterOut,$votingordering);
			//return $this->output->set_content_type('application/json; charset=utf-8')->set_status_header(500)
			//->set_output(json_encode($arr));
			//array('results'=>$results,'rows'=>$rows,'pagecount' => $pageCount);
			//array_push($arr,'issuccess'=>true,'message'=>'success');
			$arr += array('issuccess' => true);
			$arr += array('message' => 'success');
			
			echo json_encode($arr); 
		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			echo json_encode(array('issuccess'=>true,'message'=>$e->getMessage())); 
		}
	}
	////////////////////////////////////////////Widget
	//post ajax
	public function create_widget($title='',$filter='',$group='',$description='',$votingtype='',$votingordering = '',$votingexpirydate ='',$isActive=false)
	{
 		try { 
	 
			$this->load->helper('url'); 
			$title = ucwords($this->input->post('title')); 
			$filter= $this->input->post('filter');
			$group= $this->input->post('group');
			$description= $this->input->post('description');
			$votingtype = $this->input->post('votingtype');
			$votingordering = $this->input->post('votingordering');
			$votingexpirydate = $this->input->post('votingexpirydate');	
			//$createdById= $this->input->post('createdById');
			if(empty($createdById)) $createdById = 0;
			$isActive = true;			
			$userData = $this->ion_auth->user()->row();
			if(empty($userData))
			{
				echo json_encode(array('issuccess'=>false,'message'=>"You need to login to create widget.")); 	
				die();				
			}
			
			if(empty($title) || empty($filter) || empty($group)  || $title == "" || $filter== "" || $group== "")
			{	
				$columns = "";
				if(empty($title) || empty($title)) $columns .= "Title,";
				if(empty($filter) || empty($filter)) $columns .= "Filter,";
				if(empty($group) || empty($group)) $columns .= "Group,";
				
				$columns = trim(str_replace(",#######","",$columns."#######"));
				
				echo json_encode(array('issuccess'=>false,'message'=>$columns." is required.")); 	
				die();
			}
			
			if(!empty($userData))
			{
				$createdById = $userData->id; 
			} 
			$widgetid = $this->widgetsdata_model->insert_entry($title,$filter,$group,$description,$createdById,$votingtype,$votingordering,$votingexpirydate,$isActive);
			
			echo json_encode(array('issuccess'=>true,'message'=>'success','widgetid'=>$widgetid)); 			
		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			echo json_encode(array('issuccess'=>false,'message'=>$e->getMessage())); 
		}
	}
	
	//post ajax
	public function edit_widget($id = 0)
	{
		
 		try { 
	  
			if(empty($id) || $id == 0)
			{
				$id = $this->input->post('id', TRUE); 
			}
			
			if(empty($id) || $id == 0)
			{
				$id = $this->input->get('id', TRUE); 
			}	

			if($id === 0)
			{
				echo json_encode(array('issuccess'=>false,'message'=>'Id is required.')); 
				die();
			}
			$widgetData = null;
			$title = "";
			$filter = "";
			$group = "";
			$description = "";
			$createdById = 0;
			$userData = null;
			
			if($id > 0)
			{
				$widgetData = $this->widgetsdata_model->getWidgetsdata($id);
				$id = $widgetData->id;
				$title = $widgetData->title;
				$filter = $widgetData->filter_query; 
				$group = $widgetData->group_name; 
				$description = $widgetData->description;
				$votingtype = $widgetData->votingtype;
				$votingordering = $widgetData->votingordering;
				$votingexpirydate = $widgetData->votingexpirydate;	

				$createdById = $widgetData->createdById;
				$userData = $this->ion_auth->user()->row();
				if($createdById != $userData->id && !$this->ion_auth->is_admin())
				{
					echo json_encode(array('issuccess'=>false,'message'=>'User have no rights.')); 
					die();
				}
			}
			else if($id == 0 && !$this->ion_auth->is_admin())
			{
				echo json_encode(array('issuccess'=>false,'message'=>'User have no rights.')); 
				die();
			}
	 
			$this->load->helper('url'); 
			$id = $this->input->post('id');
			$title = ucwords($this->input->post('title'));
			$filter = strtolower($this->input->post('filter')); 
			$group = strtolower($this->input->post('group')); 
			$description= $this->input->post('description'); 
			if(empty($createdById)) $createdById = 0;
			$votingtype = $this->input->post('votingtype');
			$votingordering = $this->input->post('votingordering');
			$votingexpirydate = $this->input->post('votingexpirydate');	
			
			$isActive = true;
			
			$this->widgetsdata_model->update_entry($id,$title,$filter,$group,$description,$votingtype,$votingordering,$votingexpirydate,$isActive);
	 
			echo json_encode(array('issuccess'=>true,'message'=>'success','widgetid'=>$id)); 			
		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			echo json_encode(array('issuccess'=>false,'message'=>$e->getMessage())); 
		}
	}
	
	//Get ajax
	public function get_widget($id = 0)
	{
 		try { 
	  
			if(empty($id) || $id == 0)
			{
				$id = $this->input->post('id', TRUE); 
			}
			
			if(empty($id) || $id == 0)
			{
				$id = $this->input->get('id', TRUE); 
			}	

			if($id == 0)
			{
				echo json_encode(array('issuccess'=>false,'message'=>'Id is required.')); 
				die();
			}
			$widgetData = null;
			$title = "";
			$filter = "";
			$description = "";
			$createdById = 0;
			$userData = null;
			
			if($id > 0)
			{
				$widgetData = $this->widgetsdata_model->getWidgetsdata($id);
				 
				$createdById = $widgetData->createdById;
				$userData = $this->ion_auth->user()->row();
				if($createdById != $userData->id && !$this->ion_auth->is_admin())
				{
					echo json_encode(array('issuccess'=>false,'message'=>'User have no rights.')); 
					die();
				}
			}
			else if($id == 0 && !$this->ion_auth->is_admin())
			{
				echo json_encode(array('issuccess'=>false,'message'=>'User have no rights.')); 
				die();
			}
			
			echo json_encode(array('issuccess'=>true,'message'=>'success','data'=>$widgetData)); 			
		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			echo json_encode(array('issuccess'=>false,'message'=>$e->getMessage())); 
		}
	}
		
	//post ajax
	public function deleterow_widget($id = 0)
	{ 
		
 		try { 
	  	
			if(empty($id) || $id == 0)
			{
				$id = $this->input->post('id', TRUE); 
			}
			
			if(empty($id) || $id == 0)
			{
				$id = $this->input->get('id', TRUE); 
			}		
			$widgetData = null;
			if($id > 0)
			{
				$widgetData = $this->widgetsdata_model->getWidgetsdata($id);
				if(empty($widgetData))
				{
					echo json_encode(array('issuccess'=>false,'message'=>'Record not found.')); 
					die();
				}
				
				//print_r($widgetData);
				
				$id = $widgetData->id;
				
				$createdById = $widgetData->createdById;
				$userData = $this->ion_auth->user()->row();
				if(!$this->ion_auth->is_admin())
				{
					echo json_encode(array('issuccess'=>false,'message'=>'No access rights.')); 
					die();
				}
			}
			else if($id == 0 && !$this->ion_auth->is_admin())
			{
				echo json_encode(array('issuccess'=>false,'message'=>'No access rights!')); 
				die();
			}
	 
			$this->load->helper('url');  
			 
			$this->widgetsdata_model->delete_entry($id);
			echo json_encode(array('issuccess'=>true,'message'=>"success")); 
 		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			echo json_encode(array('issuccess'=>false,'message'=>$e->getMessage())); 
		}
	}
				
	public function create_success($widgetid = 0)
	{	$data['loadthemes'] = true;
		$data['widgetid']=$widgetid;
		$this->load->view('templates/headerajax', $data);
		$this->load->view('links/create_success',$data);
		$this->load->view('templates/footerajax');
	}
	public function success($data = '')
	{	$data['loadthemes'] = true;
		$this->load->view('templates/headerajax', $data);
		$this->load->view('links/success',$data);
		$this->load->view('templates/footerajax');
	}

	//Get
	public function GetWidgetDisplaylist($page = 0,$rows = 10,$category='',$createdbyid = -1)
	{	
		try { 
	
			$userData = $this->ion_auth->user()->row();
			//$arr = $this->widgetsdata_model->get_last_ten_entries();
			if(empty($page) || empty($rows))
			{
				$page = $this->input->get('page', TRUE);
				$rows = $this->input->get('rows', TRUE);
			}
			if(empty($category))
			{
				$category = $this->input->get('category', TRUE); 
			}
			
			if(!empty($userData))
			{
				$createdbyid = $userData->id;
			} 
			
			if(empty($createdbyid) || $createdbyid == -1 )
			{
				//$createdbyid = 0;
				//if(is_int($this->input->get('createdbyid', TRUE)))
				//{
					$createdbyid = intval($this->input->get('createdbyid', TRUE)); 
				//}
			}
			
			
			$arr = $this->widgetsdata_model->getWidgetsByPageNumber($page,$rows,$category,$createdbyid);
			//return $this->output->set_content_type('application/json; charset=utf-8')->set_status_header(500)
			//->set_output(json_encode($arr));
			//array('results'=>$results,'rows'=>$rows,'pagecount' => $pageCount);
			//array_push($arr,'issuccess'=>true,'message'=>'success');
			$arr += array('issuccess' => true);
			$arr += array('message' => 'success');
			
			echo json_encode($arr); 
		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			echo json_encode(array('issuccess'=>false,'message'=>$e->getMessage())); 
		}
	}	

	/*
	how it works
1. when the user press up it will add reactiondata record
2. when the user press up and his reaction already exists it will edit his reaction
3. only one reaction per user/weblinksdata or user/widgetsdata
4. up will add priority while down will decrease its priority
5. removing up or down will remove what has been added or subtracted in priority
6. reaction up and down edit is enabled if your login

NOTES
-when the user pressed up and he press up again it will remove his up
-when the user pressed down and he pressed down again it will remove his down
-if he the user pressed up and he press down then it will replace his reaction
	*/
	//post ajax

	public $UP = "up";
	public $DOWN = "down";
	public $VOTE = "vote";
	
	//$reference = 'weblinksdata' or 'widgetsdata'
	//$referenceId = number
	//$reaction = 'up' or 'down' or 'vote'
	//$oldreaction = 'up' or 'down'
	private function SaveReaction($reference="weblinksdata",$referenceId =0,$reaction = "up",$oldreaction = "",$createdById = -1,$widgetId = 0)	
	{
		try { 
			//$this->weblinksdata_model->
			//$this->widgetsdata_model->
			//$reaction = 
			// we don't need the old reaction
			$dataparam = "reference=".$reference.";referenceId=".$referenceId.";reaction=".$reaction.";oldreaction=".$oldreaction.";createdById=".$createdById.";";
			$ok = false;
			$lastVoteRefId = 0;
			if(strtolower($reference) == "weblinksdata"){
				// retrieve if there is an existing reaction
				$data = null;
				if($reaction == $this->VOTE){
					$data = $this->reactiondata_model->getvote($widgetId,$createdById);
					if(isset($data)){
						$lastVoteRefId = $data->referenceId;
					}
				}
				else {
					$data = $this->reactiondata_model->getReactiondataByReferenceId($referenceId);
				}

				if(isset($data)){
					if($data->reaction != $reaction){
						if($reaction == $this->UP){
							$this->weblinksdata_model->increase_reactionUp($referenceId);
							$this->weblinksdata_model->decrease_reactionDown($referenceId);
							$ok = true;
						}
						else if($reaction == $this->DOWN){
							$this->weblinksdata_model->decrease_reactionUp($referenceId);
							$this->weblinksdata_model->increase_reactionDown($referenceId);
							$ok = true;
						}
						else if($reaction == $this->VOTE){
							if($referenceId != $data->referenceId){
								$this->weblinksdata_model->decrease_votes($data->referenceId);
							}
							$this->weblinksdata_model->increase_votes($referenceId);
							$ok = true;
						}
						$this->reactiondata_model->update_entry($data->id,$reaction,$reference,$referenceId);							
					}
					else { // same
						if($reaction == $this->UP){
							$this->weblinksdata_model->decrease_reactionUp($referenceId);	 
							$ok = true;
							$this->reactiondata_model->deleteByReferenceId($referenceId);
						}
						else if($reaction == $this->DOWN){
							$this->weblinksdata_model->decrease_reactionDown($referenceId);	
							$ok = true;
							$this->reactiondata_model->deleteByReferenceId($referenceId);
						}
						else if($reaction == $this->VOTE){
							if($referenceId != $data->referenceId){
								$this->weblinksdata_model->decrease_votes($data->referenceId);
								$this->weblinksdata_model->increase_votes($referenceId);
								$this->reactiondata_model->update_entry($data->id,$reaction,$reference,$referenceId);	
							}
							else {
								$this->weblinksdata_model->decrease_votes($data->referenceId);
								$this->reactiondata_model->deleteByReferenceId($referenceId);
							}
							$ok = true;
						}
						
					}
				}
				else {
					//insert
					$this->reactiondata_model->insert_entry($reaction,$reference,$referenceId,$createdById);
					if($reaction == $this->UP){
						$this->weblinksdata_model->increase_reactionUp($referenceId);
						$ok = true;
					}
					else if($reaction == $this->DOWN){
						$this->weblinksdata_model->increase_reactionDown($referenceId);			
						$ok = true;
					}
					else if($reaction == $this->VOTE){
						$this->weblinksdata_model->increase_votes($referenceId);			
						$ok = true;
					}
				}
			}
			else if(strtolower($reference) == "widgetsdata"){
			// retrieve if there is an existing reaction
				$data = $this->reactiondata_model->getReactiondataByReferenceId($referenceId);
				if(isset($data)){
					if($data->reaction != $reaction){
						if($reaction == $this->UP){
							$this->widgetsdata_model->increase_reactionUp($referenceId);
							$this->widgetsdata_model->decrease_reactionDown($referenceId);
							$ok = true;
						}
						else if($reaction == $this->DOWN){
							$this->widgetsdata_model->decrease_reactionUp($referenceId);
							$this->widgetsdata_model->increase_reactionDown($referenceId);
							$ok = true;
						}
						$this->reactiondata_model->update_entry($data->id,$reaction,$reference,$referenceId);							
					}
					else { // same
						if($reaction == $this->UP){
							$this->widgetsdata_model->decrease_reactionUp($referenceId);	 
							$ok = true;
						}
						else if($reaction == $this->DOWN){
							$this->widgetsdata_model->decrease_reactionDown($referenceId);	
							$ok = true;
						}
						$this->reactiondata_model->deleteByReferenceId($referenceId);
					}
				}
				else {
					//insert
					$this->reactiondata_model->insert_entry($reaction,$reference,$referenceId,$createdById);
					if($reaction == $this->UP){
						$this->widgetsdata_model->increase_reactionUp($referenceId);
						$ok = true;
					}
					else if($reaction == $this->DOWN){
						$this->widgetsdata_model->increase_reactionDown($referenceId);			
						$ok = true;
					}					
				}
			}
			//return false;
			return array('issuccess'=>$ok,'message'=>($ok ? "success" : "error"),'lastVoteRefId'=>$lastVoteRefId,'dataparam'=>$dataparam ); 
		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			return array('issuccess'=>false,'message'=>$e->getMessage()); 
		}		
	}
	
	//$reference = 'weblinksdata' or 'widgetsdata'
	//$referenceId = number
	//$reaction = 'up' or 'down'
	//$oldreaction = 'up' or 'down'	
	//POST
	public function Save_Reaction($reference="weblinksdata",$referenceId =0,$reaction = "up",$oldreaction = "-",$widgetId = 0)
	{
 		try { 
	 
			$this->load->helper('url');  
			
			$reference= $this->input->post('reference');
			$referenceId= $this->input->post('referenceId',TRUE);
			$reaction= $this->input->post('reaction');
			$oldreaction= $this->input->post('oldreaction');
			$widgetId= $this->input->post('widgetId'); 
			$createdById = 0;
			$isActive = true;			
			$userData = $this->ion_auth->user()->row();
			if(empty($userData))
			{
				echo json_encode(array('issuccess'=>false,'message'=>"You need to login to save reaction.")); 	
				die();				
			}
			
			
			
			if(empty($reference) || empty($referenceId) || empty($reaction) || empty($oldreaction)  || $reference == "" || $referenceId== 0 || $reaction== "" || $oldreaction== "")
			{	
				$columns = "";
				if(empty($reference) || $reference == "") $columns .= "Reference,";
				if(empty($referenceId) || $referenceId == "") $columns .= "ReferenceId,";
				if(empty($reaction) || $reaction == "") $columns .= "Reaction,";
				if(empty($oldreaction) || $oldreaction == "") $columns .= "Oldreaction,";
				
				$columns = trim(str_replace(",#######","",$columns."#######"));
				
				echo json_encode(array('issuccess'=>false,'message'=>$columns." is required.")); 	
				die();
			}
			
			if((empty($widgetId) || $widgetId === 0) && $reaction == $this->VOTE)
			{
				echo json_encode(array('issuccess'=>false,'message'=>"Voting requires widgetid.")); 	
				die();
			}
			
			if(!empty($userData))
			{
				$createdById = $userData->id; 
			} 
			$dataretArray = $this->SaveReaction($reference,$referenceId,$reaction,$oldreaction,$createdById,$widgetId);
			$referencedata = null;
			
			if($reference=="weblinksdata"){
				$referencedata = $this->weblinksdata_model->getWeblinksData($referenceId);
			}
			else if($reference=="widgetsdata"){
				$referencedata = $this->widgetsdata_model->getWidgetsdata($referenceId);
			}
			$reactionData = $this->reactiondata_model->getReactiondataByReferenceId($referenceId);
						
			$dataretArray['referenceData'] = $referencedata;
			$dataretArray['reactionData'] = $reactionData;
			
			echo json_encode($dataretArray); 			
		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			echo json_encode(array('issuccess'=>false,'message'=>$e->getMessage())); 
		}
	}
	
	public function GetUserReaction($referenceId=0,$createdById=0)
	{
		try { 
		
			$userData = $this->ion_auth->user()->row();
			//$arr = $this->weblinksdata_model->get_last_ten_entries();
			if(empty($referenceId) || empty($createdById))
			{
				$referenceId = $this->input->get('referenceId', TRUE);
				$createdById = $this->input->get('createdById', TRUE);
			}
			
			$reactionData = $this->reactiondata_model->GetReactionByUserAndReference($referenceId,$createdById);
			echo json_encode(array('issuccess'=>true,'message'=>"success",'reactionData' => $reactionData)); 
		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			echo json_encode(array('issuccess'=>false,'message'=>$e->getMessage())); 
		}		
	}
}

?>
<?php
		
///print_r($_SESSION);
if (session_status() == PHP_SESSION_NONE) {

}
else
{
	
}
//if(!isset($_SESSION)){
	//session_name("TEST");
	//session_start();
//}


//$_SESSIONGLOBAL = &$_SESSION;	


?>