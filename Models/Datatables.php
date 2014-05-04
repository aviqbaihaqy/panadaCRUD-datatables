<?php
namespace Models;
use Resources;

class Datatables {

	public function __construct( ) {
		$this->db = new Resources\Database;
	}
		
	/* update */
	public function Update($value,$where){
		if( $this->db->update('tbdos',$value,$where) )
			 return $this->getLastInsert($where['IDTBDOS']);
	}
	
	/*delete*/
	public function Delete($where){
		$this->db->where('IDTBDOS', 'in', $where);
		$this->db->delete('tbdos');
	}
	
	/*insert*/
	public function Create($data){
		if( $this->db->insert('tbdos', $data) )
            return $this->getLastInsert($this->db->insertId());
        
        return false;
	}
	
	public function getOne( $criteria = array() ){
        
        return $this->db->getOne('tbdos', $criteria);
    }
	
	private function getLastInsert($where){
		return $this->db
				->where('IDTBDOS', '=', $where)
				->getAll("tbdos");
	}
}
