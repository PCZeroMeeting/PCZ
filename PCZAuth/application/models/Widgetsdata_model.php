<?php
class Widgetsdata_model extends CI_Model {

        public $id;
		public $title;
        public $filter_query;
		public $group_name;
		public $description;
		public $createdDate;
		public $createdById;
		public $reactionUp;
		public $reactionDown;
		public $votingtype;
		public $votingordering;
		public $votingexpirydate;
		public $isActive;
		public $TABLENAME = 'widgetsdata';
		
        public function get_last_ten_entries()
        {
                $query = $this->db->get($this->TABLENAME, 10);
				return $query->result_array();
        }
 
		public function getWidgetsByPageNumber_1($page_no,$rowsPerPage,$createdById = -1)
		{
			$limit = $rowsPerPage;
			$offset = max($page_no - 1, 0) * $limit; 
			$whereData = '';
			$isOwn = false;
			$andCreatedBy = ' createdById = '.$createdById.' ';			
			
			$isOtherCategoryExists = false;
 
			$whereData = "where ".$andCreatedBy;
		 
			$queryString = "";
			
			$queryString = 'Select SQL_CALC_FOUND_ROWS (TIMESTAMPDIFF(MINUTE,createddate,NOW()) < 60) as isnew,
			id,
			title, 
			filter_query,
			group_name,
			description,
			createdDate,
			createdById,
			votingtype,
			votingordering,
			votingexpirydate,
			isActive FROM '.$this->TABLENAME.'  '.$whereData.' order by createdDate desc LIMIT '.$limit.' OFFSET '.$offset.'';
			 
			
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
			return array('results'=>$results,'rows'=>$rows,'pagecount' => $pageCount,"query"=>$queryString);
		}
		 
        public function getWidget($limit,$offset)
        {			     
				$this->db->order_by("createdDate", "DESC");
				$query = $this->db->get_where($this->TABLENAME, null, $limit, $offset);
				
				return $query->result_array();				
        }		

		public function getWidgetsdata($id)
		{
			$query = $this->db->get_where($this->TABLENAME, array('id' => $id));
			$retdata = $query->row();
 
			return $retdata;
		}

		public function getWidgetsByPageNumber($page_no,$rowsPerPage,$category = "",$createdById = -1)
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
					$whereData .= ' group_name like "%'.trim($value).'%" or ';
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
			else if($category == ""){
				$whereData = "where group_name=''";
			}
			
			$queryString = 'Select SQL_CALC_FOUND_ROWS (TIMESTAMPDIFF(MINUTE,createddate,NOW()) < 60) as isnew,
			id,
			title,
			filter_query,
			group_name,
			description,
			createdDate,
			createdById,
			reactionUp,
			reactionDown,
			votingtype,
			votingordering,
			DATE_FORMAT(votingexpirydate, "%m/%d/%Y %H:%i") as votingexpirydate ,
			isActive FROM '.$this->TABLENAME.'  '.$whereData.' order by createdDate desc LIMIT '.$limit.' OFFSET '.$offset.'';

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
			
			return array('results'=>$results,'rows'=>$rows,'pagecount' => $pageCount
			,"query"=>$queryString
			);
        }
				
        public function insert_entry($title,$filter_query,$group_name,$description,$createdById,$votingtype,
			$votingordering,$votingexpirydate,$isActive)
        {
			$this->title = clean_fordb($title);
			$this->filter_query = $filter_query;
			$this->group_name = clean_fordb($group_name);
			$this->description = clean_fordb($description); 
			$this->createdById = $createdById;
			$this->isActive = $isActive;
			$this->votingtype = $votingtype;
			$this->votingordering = $votingordering;
			$this->votingexpirydate = $votingexpirydate;
			
			$dataArray = array( 
				'title' =>  $this->title,
				'filter_query' => $this->filter_query,
				'group_name' => $this->group_name,
				'description' =>$this->description ,
				'createdById' => $this->createdById ,
				'votingtype' => $this->votingtype,
				'votingordering' => $this->votingordering,
				'votingexpirydate' => $this->votingexpirydate,
				'isActive' => $this->isActive
			);
			$this->db->set('createdDate', 'NOW()', FALSE);
			$this->db->insert($this->TABLENAME, $dataArray);
			$insert_id = $this->db->insert_id();
			return $insert_id;
        }

        public function update_entry($id,$title,$filter_query,$group_name,$description,$votingtype,
			$votingordering,$votingexpirydate,$isActive)
        {
			$updatearr = array('filter_query' => $filter_query, 
							'group_name' => clean_fordb($group_name), 
							'title' => clean_fordb($title),
							'description' => clean_fordb($description),				
							'votingtype' => $votingtype,
							'votingordering' => $votingordering,
							'votingexpirydate' => $votingexpirydate,
							'isActive' => $isActive								
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
		
		//using filter of widget then retrieve all the weblinkdata. With the weblinkdata we then get the reactiondata and check if createid exists

}