<?php
	
	if(isset($userData)) {
		$id 		= isset($userData['id']) ? $userData['id'] : '';
		$fname 		= isset($userData['fname']) ? $userData['fname'] : '';
		$lname 		= isset($userData['lname']) ? $userData['lname'] : '';
		$phone 		= isset($userData['telephone']) ? $userData['telephone'] : '';
		$email 		= isset($userData['email']) ? $userData['email'] : '';
		$gender 	= isset($userData['gender']) ? $userData['gender'] : '';
		$picture 	= isset($userData['picture']) ? $userData['picture'] : '';
		$button 	= isset($userData['update_btn']) ? $userData['update_btn'] : 'Register';

		$formId = 'registerUser';

		if($button == 'Update') {

			$formId = 'updateUser';

		}
	}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<form id="<?php echo isset($formId)? $formId : 'registerUser';?>" class="<?php echo isset($formId)? $formId : 'registerUser';?>" method="post" enctype="multipart/form-data" style="width: 67%;margin-left : 35%">

	<input type="hidden" id="primaryKeyId" name="primaryKeyId" value="<?php echo isset($id) ? $id : '';?>">

	<div class="col-md-4 mt-3 mb-3">				
		<h3 style="text-align:center;"><b><?php echo isset($formId)? 'User update form' : 'User registration form';?></b></h3>
	</div>
	<br>	

	<div class="col-md-4 mt-3 mb-3">				
		<input type="text" class="form-control" placeholder="First Name" id="fname" name="fname" value="<?php echo isset($fname) ? $fname : '';?>">
	</div>
	<br>

	<div class="col-md-4 mt-3">
		<input type="text" class="form-control" placeholder="Last Name" id="lname" name="lname" value="<?php echo isset($lname) ? $lname : '';?>">
	</div>
	<br>

	<div class="col-md-4 mt-3">
		<input type="email" class="form-control" placeholder="Email" id="email" name="email" value="<?php echo isset($email) ? $email : '';?>">
	</div>
	<br>

	<div class="col-md-4 mt-3">
		<input type="text" class="form-control" placeholder="Password" minlength="8" maxlength="16" id="password" name="password">
	</div>
	<br>

	<div class="col-md-4 mt-3">
		<input type="mobile" class="form-control" patern="[0-9]{3} [0-9]{3} [0-9]{4}" maxlength="10" minlength="10" title="Ten digits code" placeholder="Telephone" id="telephone" name="telephone" value="<?php echo isset($phone) ? $phone : '';?>">
	</div>
	<br>

	<div class="col-md-4 mt-3">
		<a>
			Gender :&nbsp; 
		</a>	
		<select id="gender" name="gender" value="<?php echo isset($gender) ? $gender : '';?>">
		  <option value="">Select Gender</option>
		  <option value="m">Male</option>
		  <option value="f">Female</option>
		  <option value="other">Other</option>				  
		</select>							
	</div>
	<br>

	<div class="col-md-4 mt-3 form-group">
		<a>
			Profile Picture
		</a>
		<input type="file" class="form-control" accept="image/*" id="picture" name="file" value="<?php echo isset($picture) ? $picture : '';?>">
	</div>	
	<br>
	<?php if(isset($button) && $button == 'Update') { ?>

		<div class="col-md-4 mt-3">
			<button type="button" onclick="updateUserBtn();" class="btn btn-primary">Update</button>
		</div>		

	<?php } else { ?>

		<div class="col-md-4 mt-3">
			<button type="submit" class="btn btn-primary">Register</button>
		</div>		

	<?php }?>

</form>

<div id="usersview">
</div>

<script type="text/javascript">
  	
	$('#registerUser').off('click');
	$(document).off('submit', '#registerUser').on('submit', '#registerUser', function(event){      	
    	
    	event.preventDefault(); 	

		$('select').attr("required", true);
		$('input').attr('required', true);

        var formData 	= new FormData(this);
		var baseUrl 	= 'http://practicaltest.com/';

        $.ajax({
            url: baseUrl + 'register/addNewuser',
            data: formData,
            type: 'POST',
            cache:false,
            contentType: false,
            processData: false,		            
            
            success: function (r) {
            	
            	let response = JSON.parse(r);
                
                if (response.status == true) {
					
					alert(response.message);
					loadUserDetailsList();	                	

                }
            }            

        });
    });


	function updateUserBtn() {

        var id 			= $('#primaryKeyId').val();
		var fname 		= $('#fname').val();
		var lname 		= $('#lname').val();
		var email 		= $('#email').val();
		var password 	= $('#password').val();
		var gender 		= $('#gender').val();
		var telephone 	= $('#telephone').val();
		var picture 	= $('#picture').val();		

		var baseUrl = 'http://practicaltest.com/';

        $.ajax({
            url: baseUrl + 'register/updateUserData',
            data: {id: id, fname: fname, lname: lname, email: email, password: password, gender: gender, telephone: telephone, picture: picture},
            type: 'POST',
            
            success: function (response) {

            	console.log(response);
            	
            	let res = JSON.parse(response);
            	console.log(res);

            	if(res.status = true) {

            		alert(res.message);
            		loadUserDetailsList();
            	
            	} else {

            		alert(res.message);
            	}
            }
        });
    }


	function loadUserDetailsList() {

		var baseUrl = 'http://practicaltest.com/';

        $.ajax({
            url: baseUrl + 'register/getUseLists',
            type: 'POST',
            cache:false,
            contentType: false,
            processData: false,		            
            
            success: function (html) {
            	$('#registerUser').html(" ");
            	$("#usersview").html(html);
            }            

        });
	}

</script>