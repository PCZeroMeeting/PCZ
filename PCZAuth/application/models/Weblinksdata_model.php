<?php
class Weblinksdata_model extends CI_Model {

        public $id;
		public $title;
        public $tags;
        public $link;
		public $description;
		public $createdDate;
		public $createdById;
		public $reactionUp;
		public $reactionDown;
		public $priority;
		public $votes;
		public $isActive;
		public $TABLENAME = 'weblinksdata';
		
        public function get_last_ten_entries()
        {
                $query = $this->db->get($this->TABLENAME, 10);
				return $query->result_array();
        }

		public function getLinksByPageNumber($page_no,$rowsPerPage,$category = "",$createdById = -1,$filterOut = "",$votingordering="")
        {	
			$category = strtolower($category);
		
			$limit = $rowsPerPage;
			$offset = max($page_no - 1, 0) * $limit;
			if($category=="all") $category = "";
			$whereData = "";
			$isOwn = false;
			$andCreatedBy ="";
			if(strpos($category,"own") !== false)
			{
				$category = trim(str_replace("own","",$category));
				$andCreatedBy .= ' createdById = '.$createdById.' ';
				$isOwn = true;
			}
			$isOtherCategoryExists = false;
			if($category != "")
			{
				$categoryArray = explode(" ",$category);
				foreach ($categoryArray as $key => $value)
				{
					$whereData .= ' tags like "%'.trim($value).'%" or ';
				}
				$whereData = $whereData.'#######';
				if(strpos($whereData,"or #######") !== false)
				{
					$isOtherCategoryExists = true;
				}
				
				$whereData = str_replace("or #######"," ",$whereData);
				$whereData = str_replace("#######"," ",$whereData);
				
				if($isOtherCategoryExists === true && $isOwn === true)
				{
					$whereData = "(".$whereData.") and ".$andCreatedBy;					
				}
				
				$whereData = "where ".$whereData;
			}
			else if($isOwn === true){
				$whereData = "where ".$andCreatedBy;
			}
			
			if(!empty($filterOut))
			{
				if (strpos($whereData, 'where') !== false) 
				{
					$whereData .= ' and tags not like "%'.$filterOut.'%"';
				}
				else 
				{
					$whereData .= ' where tags not like "%'.$filterOut.'%"';
				}
			}			
 			$orderData = " w.createdDate desc ";
			switch($votingordering)
			{
				case "loserfirst":
					$orderData = " if(isnull(w.reactionUp),0,w.reactionUp) - if(isnull(w.reactionDown),0.01,w.reactionDown) asc, w.priority asc, w.createdDate desc ";
					break;
				case "winnerfirst":
					$orderData = " (0 + if(isnull(w.reactionUp),0,w.reactionUp) - if(isnull(w.reactionDown),0.01,w.reactionDown)) desc, w.priority asc, w.createdDate desc ";
					break;
				case "newest":
					$orderData = " w.createdDate desc ";
					break;
				case "oldest":
					$orderData = " w.createdDate asc ";
					break;
				case "priority":
					$orderData = " w.priority asc,w.createdDate desc ";
					break;
				default:
					$orderData = " w.createdDate desc ";
					break;
			}
			
			$queryString = 'Select SQL_CALC_FOUND_ROWS (TIMESTAMPDIFF(MINUTE,w.createddate,NOW()) < 60) as isnew,
			w.id,
			w.title,
			w.link,
			w.tags,
			w.description,
			w.createdDate,
			w.createdById,
			w.isActive ,
			w.reactionUp,
			w.reactionDown,
			w.priority,
			w.votes,
			u.username,
			u.id as userid
			FROM '.$this->TABLENAME.' w 
			left join users u on w.createdById = u.id
			'.$whereData.' 
			order by '.$orderData.' LIMIT '.$limit.' OFFSET '.$offset.'';
			 
			$query = $this->db->query($queryString,FALSE);
			
			$results = $query->result_array();
			$rows = $this->db->query('SELECT FOUND_ROWS() count;')->row()->count;
			$pageCount = 1;
			if($rowsPerPage > 0)
			{
				$pageCount = ceil($rows / $rowsPerPage);
				if($pageCount <= 0)
				{
					$pageCount = 1;
				}
			}
			
			//for($i = 0; $i < count($result); $i++)
			//{
				//html_escape
				//$result
			//}
			return array('results'=>$results,'rows'=>$rows,'pagecount' => $pageCount
			,"query"=>$queryString
			);
        }
		
        public function getLinks($limit,$offset)
        {			     
				$this->db->order_by("createdDate", "DESC");
				$query = $this->db->get_where($this->TABLENAME, null, $limit, $offset);
				
				return $query->result_array();				
        }		

		public function getWeblinksData($id)
		{
			$query = $this->db->get_where($this->TABLENAME, array('id' => $id));
			return $query->row();
		}

        public function insert_entry($title,$link,$tags,$description,$createdById,$priority,$isActive)
        {
			$this->tags = $tags;
			$this->title = clean_fordb($title);
			$this->link = $link;
			$this->description = clean_fordb($description); 
			$this->createdById = $createdById;
			$this->isActive = $isActive;
			$this->priority = $priority;
			
			$dataArray = array(
				'tags' => $this->tags,
				'title' => $this->title,
				'link' => $this->link,
				'description' => $this->description ,
				'createdById' => $this->createdById ,
				'isActive' => $this->isActive,
				'priority' => $this->priority,
			);
			$this->db->set('createdDate', 'NOW()', FALSE);
			$this->db->insert($this->TABLENAME, $dataArray);
        }

        public function update_entry($id,$title,$link,$tags,$description,$priority,$isActive)
        {
			$updatearr = array('tags' => $tags,
							'link' => $link,
							'title' => clean_fordb($title),
							'description' => clean_fordb($description),
							'isActive' => $isActive	,
							'priority' => $priority,
						);
			$this->db->where('id', $id);
			$this->db->update($this->TABLENAME, $updatearr);
			$updated_status = $this->db->affected_rows();
 
			if($updated_status)
			{
				return $id;
			}
			else
			{
				return false;
			}
        }
		
		public function delete_entry($id){
			$this->db->where('id', $id);
			$this->db->delete($this->TABLENAME);
		}

		public function increase_votes($id)
		{
			 $queryString = 'update '.$this->TABLENAME.'  set votes = if(ISNULL(votes),0,votes) + 1  
							where id = '.$id;
			$query = $this->db->query($queryString,FALSE);
			//$results = $query->result_array();			
		}
		
		public function decrease_votes($id)
		{
			 $queryString = 'update '.$this->TABLENAME.'  set votes = if(ISNULL(votes),0,votes) - 1  
							where id = '.$id;
			$query = $this->db->query($queryString,FALSE);
			//$results = $query->result_array();			
		}
		
		public function increase_reactionUp($id)
		{
			 $queryString = 'update '.$this->TABLENAME.'  set reactionUp = if(ISNULL(reactionUp),0,reactionUp) + 1  
							where id = '.$id;
			$query = $this->db->query($queryString,FALSE);
			//$results = $query->result_array();			
		}
		
		public function decrease_reactionUp($id)
		{
			 $queryString = 'update '.$this->TABLENAME.'  set reactionUp = if(ISNULL(reactionUp),0,reactionUp) - 1  
							where id = '.$id;
			$query = $this->db->query($queryString,FALSE);
			//$results = $query->result_array();			
		}		
		
		public function decrease_reactionDown($id)
		{
			 $queryString = 'update '.$this->TABLENAME.'  set reactionDown = if(ISNULL(reactionDown),0,reactionDown) - 1  
							where id = '.$id;
			$query = $this->db->query($queryString,FALSE);
			//$results = $query->result_array();			
		}	
		
		public function increase_reactionDown($id)
		{
			 $queryString = 'update '.$this->TABLENAME.'  set reactionDown = if(ISNULL(reactionDown),0,reactionDown) + 1  
							where id = '.$id;
			$query = $this->db->query($queryString,FALSE);
			//$results = $query->result_array();			
		}		
}