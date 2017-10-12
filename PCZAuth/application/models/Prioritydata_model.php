<?php
class Prioritydata_model extends CI_Model {

        public $id;
		public $parentreference;
        public $parentreferenceId;
		public $childreference;
		public $childreferenceId;
		public $childpriority;
		public $createdDate;
		public $createdById;
		
		public $TABLENAME = "prioritydata"; 
		
        public function get_last_ten_entries()
        {
                $query = $this->db->get($this->TABLENAME, 10);
				return $query->result_array();
        }
 
  
        public function getPrioritydata($limit,$offset)
        {			     
				$this->db->order_by("createdDate", "DESC");
				$query = $this->db->get_where($this->TABLENAME, null, $limit, $offset);
				
				return $query->result_array();				
        }		

		public function getPrioritydata($id)
		{
			$query = $this->db->get_where($this->TABLENAME, array('id' => $id));
			return $query->row();
		}
		
		public function getPriorityDataByParentReferenceId($parentreferenceId)
		{
			$query = $this->db->get_where($this->TABLENAME, array('parentreferenceId' => $parentreferenceId));
			return $query->result_array();
		}
		
		public function getPriorityData($parentreferenceId,$childreferenceId)
		{
			$query = $this->db->get_where($this->TABLENAME, array('parentreferenceId' => $parentreferenceId,'childreferenceId' => $childreferenceId));
			return $query->result_array();
		}
		
 
		
        public function insert_entry($parentreference,$parentreferenceId,$childreference,$childreferenceId,$childpriority,$createdById)
        {
			$this->parentreference = $parentreference;
			$this->parentreferenceId = $parentreferenceId;
			$this->childreference = $childreference; 
			$this->childreferenceId = $childreferenceId; 
			$this->childpriority = $childpriority; 
			//$this->createdDate = $createdDate; 
			$this->createdById = $createdById;
			
			$dataArray = array( 
				'parentreference' => $this->parentreference,
				'parentreferenceId' => $this->parentreferenceId,
				'childreference' => $this->childreference,
				'childreferenceId' => $this->childreferenceId,
				'childpriority' => $this->childpriority,
				'createdDate' => $this->createdDate,
				'createdById' => $this->createdById 
			);
			$this->db->set('createdDate', 'NOW()', FALSE);
			$this->db->insert($this->TABLENAME, $dataArray);
        }

        public function update_entry( $id,$parentreference,$parentreferenceId,$childreference,$childreferenceId,$childpriority)
        {
			$updatearr = array( 
				'parentreference' => $parentreference,
				'parentreferenceId' => $parentreferenceId,
				'childreference' => $childreference,
				'childreferenceId' => $childreferenceId,
				'childpriority' => $childpriority
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

		public function deleteByParentReferenceId($parentreferenceId){
			$this->db->where('parentreferenceId', $parentreferenceId);
			$this->db->delete($this->TABLENAME);
		}
		
		public function deletePriorityData($parentreferenceId,$childreferenceId){
			$array = array('parentreferenceId' => $parentreferenceId, 'childreferenceId' => $childreferenceId);
			$this->db->where($array);
			$this->db->delete($this->TABLENAME);
		}
		
		public function delete_entry($id){
			$this->db->where('id', $id);
			$this->db->delete($this->TABLENAME);
		}

}