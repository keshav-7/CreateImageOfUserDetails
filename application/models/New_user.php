<?php 

class New_user extends CI_Model {

	public function inserNewUser($userDetails) {

		$this->db->insert('user_details', $userDetails);
		
		return $this->db->insert_id();

	}

	public function getUserData($id = '') {
		
		$this->db->select('id, fname, lname, email, gender, telephone, picture');
		$this->db->from('user_details');

		if(!empty($id)) {

			$this->db->where('id', $id);	
			return $this->db->get()->row_array();
		
		} else {
		
			$this->db->where('fname !=', '');
			$this->db->order_by('id', 'asc');
			return $this->db->get()->result_array();
		}
		
	}

	public function deleteUserRowData($id) {

	    $this->db->where('id', $id);
	    return $this->db->delete('user_details');
	
	}


	public function insertEmail($userName, $userEmail, $file) {

		$inserArray = ['user_name' => $userName, 'attachement' => $file, 'status' => 1];

		$this->db->insert('email_pool', $inserArray);

		return $this->db->insert_id();

	}	

}
?>