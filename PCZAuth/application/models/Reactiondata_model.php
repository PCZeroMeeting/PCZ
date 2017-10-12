<?php
class Reactiondata_model extends CI_Model {

        public $id;
		public $reaction;
        public $reference;
		public $referenceId;
		public $createdDate;
		public $createdById;
		
		public $TABLENAME = "reactiondata";
		
        public function get_last_ten_entries()
        {
                $query = $this->db->get($this->TABLENAME, 10);
				return $query->result_array();
        }
 
  
        public function getReaction($limit,$offset)
        {			     
				$this->db->order_by("createdDate", "DESC");
				$query = $this->db->get_where($this->TABLENAME, null, $limit, $offset);
				
				return $query->result_array();				
        }		

		public function getReactiondata($id)
		{
			$query = $this->db->get_where($this->TABLENAME, array('id' => $id));
			return $query->row();
		}
		
		public function getReactiondataByReferenceId($referenceId)
		{
			$data = array('referenceId' => $referenceId );
			$query = $this->db->get_where($this->TABLENAME, $data);
			return $query->row();
		}
		
		public function getReactiondataByCreatedByReferenceId($referenceId, $createdById)
		{
			$data = array('referenceId' => $referenceId,
						'createdById' => $createdById);
			$query = $this->db->get_where($this->TABLENAME, $data);
			return $query->row();
		}
		
		public function GetReactionByUserAndReference($referenceId,$createdById)
		{
			$queryString = 'select reaction,referenceId from '.$this->TABLENAME.' where createdById = '.$createdById.' and referenceId='.$referenceId.' order by reaction desc';
			$query = $this->db->query($queryString,FALSE);
 
			return $query->row();
			//return $query->result_array();
		}
		
        public function insert_entry($reaction,$reference,$referenceId,$createdById)
        {
			$this->reaction = $reaction;
			$this->reference = $reference;
			$this->referenceId = $referenceId; 
			$this->createdById = $createdById; 
			
			$dataArray = array( 
				'reaction' => $this->reaction,
				'reference' => $this->reference,
				'referenceId' => $this->referenceId, 
				'createdById' => $this->createdById 
			);
			$this->db->set('createdDate', 'NOW()', FALSE);
			$this->db->insert($this->TABLENAME, $dataArray);
        }

        public function update_entry($id,$reaction,$reference,$referenceId)
        {
			$updatearr = array('reaction' => $reaction, 
							'reference' => $reference,					
							'referenceId' => $referenceId 		
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

		public function deleteByReferenceId($referenceId){
			$this->db->where('referenceId', $referenceId);
			$this->db->delete($this->TABLENAME);
		}
		
		public function delete_entry($id){
			$this->db->where('id', $id);
			$this->db->delete($this->TABLENAME);
		}
		
		public function getvote($widgetid,$createdById)
		{
			//$queryString = 'select reaction,referenceId from '.$this->TABLENAME.' where createdById = '.$createdById.' and referenceId='.$referenceId.' order by reaction desc';
			$queryString = 'select r.id,r.referenceId,r.reaction  from widgetsdata widget
				join weblinksdata w on w.tags like concat("%",widget.filter_query,"%")
				join reactiondata r on w.id = r.referenceid
				where widget.id = '.$widgetid.' 
				 and r.reaction = "vote"
				 and r.createdById = '.$createdById;
 
			$query = $this->db->query($queryString,FALSE);
			//echo $queryString;
			//die();
			$data = $query->row(); 
			return $data;
		}
}