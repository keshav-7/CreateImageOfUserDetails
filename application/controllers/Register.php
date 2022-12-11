<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('registerForm');
	}

	public function addNewuser() 
	{

		$inputData = $this->input->post();

		if(!empty($inputData)) {

		    $file_name = $_FILES['file']['name'];

		    $temp_name = $_FILES['file']['tmp_name']; // tmp_name

		    if(isset($file_name) && !empty($file_name)) {
		        
	            $location = IMAGE_FILE_PATH;

		        if(move_uploaded_file($temp_name, $location . $file_name)){
		            
		        }
		    
		    }  else {
		    
		        echo 'please upload an image file';
		    }
			
			$fname 		= isset($inputData['fname']) ? trim($inputData['fname']) : '';
			$lname 		= isset($inputData['lname']) ? trim($inputData['lname']) : '';
			$email 		= isset($inputData['email']) ? trim($inputData['email']) : '';
			$password 	= isset($inputData['password']) ? trim($inputData['password']) : '';
			$telephone 	= isset($inputData['telephone']) ? trim($inputData['telephone']) : '';
			$gender 	= isset($inputData['gender']) ? $inputData['gender'] : '';
			
			$inserArray = [
							'fname' 	=> $fname, 
							'lname' 	=> $lname, 
							'email' 	=> $email, 
							'password' 	=> $password, 
							'gender' 	=> $gender, 
							'telephone' => $telephone, 
							'picture' 	=> isset($file_name) ? $file_name : ''
						];

			$this->load->model('new_user');
			
			$insertId = $this->new_user->inserNewUser($inserArray);

			if(!empty($insertId)) {

				echo json_encode(['status' => true, 'message'=> 'User Added Successfully.']);
				exit;

			} else {

				echo json_encode(['status' => false, 'message'=> 'User not added.']);
				exit;			
			}
		}
    }


    public function getUseLists() {

		$this->load->model('new_user');
		
		$userDetails = $this->new_user->getUserData();
		
		if(!empty($userDetails)) {

			$userData['user_lists'] = $userDetails;
			$userData['status'] 	= true;
		
			$this->load->view('user_list', $userData);
		
		} else {

			$userData['status'] = true;	
		
		}


    }

    public function updateUserDetails() {

    	$inputData = $this->input->post();
		$this->load->model('new_user');
    	$userData['userData'] = $this->new_user->getUserData($inputData['id']);
		$userData['userData']['update_btn'] = 'Update';
    	$this->load->view('registerForm', $userData);   	

    }

    public function updateUserData() {

    	$inputData = $this->input->post();

    	if(!empty($inputData['id'])) {

		    if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {

			    $file_name = $_FILES['file']['name'];

			    $temp_name = $_FILES['file']['tmp_name'];		    	
		        
	            $location = 'upload/';
		        
		        if(move_uploaded_file($temp_name, $location . $file_name)){
		            
		        }
		    
		    }

		    if(!empty($file_name)) {

				$this->db->where('id', $inputData['id']);
				$this->db->update('user_details', array('picture' => $file_name));

		    }

			if(!empty($inputData['fname'])) {

				$this->db->where('id', $inputData['id']);
				$this->db->update('user_details', array('fname' => trim($inputData['fname'])));

			}

			if(!empty($inputData['lname'])) {

				// print_r($inputData['lname']);

				$this->db->where('id', $inputData['id']);
				$this->db->update('user_details', array('lname' => trim($inputData['lname'])));

			}

			if(!empty($inputData['email'])) {

				$this->db->where('id', $inputData['id']);
				$this->db->update('user_details', array('email' => trim($inputData['email'])));

			}

			if(!empty($inputData['password'])) {

				$this->db->where('id', $inputData['id']);
				$this->db->update('user_details', array('password' => trim($inputData['password'])));

			}

			if(!empty($inputData['telephone'])) {

				$this->db->where('id', $inputData['id']);
				$this->db->update('user_details', array('telephone' => trim($inputData['telephone'])));

			}
			
			if(!empty($inputData['gender'])) {
				
				$this->db->where('id', $inputData['id']);
				$this->db->update('user_details', array('gender' => $inputData['gender']));

			}

			echo json_encode(['status' => true, 'message'=> 'User data updated successfully.']);
			exit;			
		
		}
    }

    public function deleteUserData() {

    	$postData = $this->input->post();

    	if(!empty($postData['id'])) {
			
			$this->load->model('new_user');
			
			$user_data = $this->new_user->getUserData($postData['id']);

			if(isset($user_data['picture']) && !unlink(IMAGE_FILE_PATH.$user_data['picture'])) {

			}

			$response = $this->new_user->deleteUserRowData($postData['id']);

			if($response !== FALSE) {

				echo json_encode(['status' => true, 'message'=> 'User deleted successfully.']);
				exit;

			} else {

				echo json_encode(['status' => false, 'message'=> 'User not found.']);
				exit;				
			
			}

    	} else {

			echo json_encode(['status' => false, 'message'=> 'Something went wrong.']);
			exit;    		
    	
    	}
    }


	public function takeUserDetailsScreenShot() {

		$postData = $this->input->post();

		if(!empty($postData)) {
	
			$location = IMAGE_FILE_PATH . "screenShots/";

			$image_parts = explode(";base64,", $postData['image']);

			$image_base64 = base64_decode($image_parts[1]);

			$filename = $postData['fname'].uniqid().'.png';

			$file = $location . $filename;

			file_put_contents($file, $image_base64);

			$result = $this->sendEmail($postData['fname'], $postData['email'], $filename);

			if($result) {
			
				echo json_encode(['status' => true, 'message'=> 'Email sent successfully with image.']);
				exit;

			} else {

				echo json_encode(['status' => false, 'message'=> 'Something went wrong.']);
				exit;				
			
			}
		}		
	}


	public function sendEmail($userName, $userEmail, $file) {
		
	    $from  	 = 'keshav@gmail.com'; 
	    $to 	 = $userEmail; 
	    $subject = "Your details image created."; 
	    $message = "Hi " . $userName;                   

	    $file_name = chunk_split(base64_encode($file));
	    $boundary  = md5("random"); 

	    
	    $headers = "MIME-Version: 1.0\r\n"; 
	    $headers .= "From:".$from."\r\n"; 
	    $headers .= "Content-Type: multipart/mixed;"; 
	    $headers .= "boundary = $boundary\r\n"; 

	    
	    $body = "--$boundary\r\n";
	    $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
	    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
	    $body .= chunk_split(base64_encode($message));
	         
	    
	    $body .= "--$boundary\r\n";
	    $body .="Content-Transfer-Encoding: base64\r\n";
	    $body .="X-Attachment-Id: ".rand(1000, 99999)."\r\n\r\n";
	    $body .= $file_name; 

	    $sentMailResult = mail($to, $subject, $body, $headers);

	    $this->load->model('new_user');
	    
	    $response = $this->new_user->insertEmail($userName, $userEmail, $file);

	    if($response) {

	    	return TRUE;
	    }

	}    
}