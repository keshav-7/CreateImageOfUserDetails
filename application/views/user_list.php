<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .editBtn {
    	background-color: skyblue;
    }
	
	.deleteBtn {

    	background-color: orangered;
	}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://elevenstechwebtutorials.com/demo/jquery/convert-html-to-image-using-jquery/js/html2canvas.min.js"></script>
<script src="https://elevenstechwebtutorials.com/demo/jquery/convert-html-to-image-using-jquery/js/html2canvas.esm.js"></script>
<script src="https://elevenstechwebtutorials.com/demo/jquery/convert-html-to-image-using-jquery/js/html2canvas.js"></script>
<form id="userList" method="post" enctype="multipart/form-data">
	<div class="container mt-5">
		<table class="table" style="width: 100%;">
			<tr>
				<th>Id</th>				
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Gender</th>
				<th>Picture</th>
				<th>Edit</th>
				<th>Delete</th>
				<th>Send Email</th>

			</tr>
			<?php if(!empty($user_lists)) {
				foreach($user_lists as $user_list) {
					$imgpath = 'http://practicaltest.com/upload/';?>
					<tr style="text-align: center;" id="detailImage_<?php echo $user_list['id'];?>">
						<td><?php echo $user_list['id'] ?></td>						
						<td><?php echo $user_list['fname'] ?></td>
						<td><?php echo $user_list['lname'] ?></td>
						<td><?php echo $user_list['email'] ?></td>
						<td><?php echo $user_list['telephone'] ?></td>
						<td><?php echo $user_list['gender'] ?></td>
						<td><img src="<?php echo $imgpath.$user_list['picture'] ?>" alt="profilePic" style="width:100px;height:100px;"></td>
						<td><input type="button" class="editBtn" value="Edit" onclick="updateUserDetail('<?php echo $user_list['id']?>');"></td>
						<td><input type="button" class="deleteBtn" value="Delete" onclick="deleteUser('<?php echo $user_list['id']?>');"></td>
						<td><input type="button" class="sendEmail" value="Send Email" onclick="sendImageToEmail('<?php echo $user_list['id']?>', '<?php echo $user_list['fname']?>', '<?php echo $user_list['email']?>');"></td>						
						<br><br>
					</tr><?php
				}
			}?>

		</table>	
	</div>
</form>

<div id="updateUsersForm">
</div>

<script type="text/javascript">

	function updateUserDetail(id) {

		var baseUrl = 'http://practicaltest.com/';

        $.ajax({
            url: baseUrl + 'register/updateUserDetails',
            data: {'id':id},                        
            type: 'POST',
            
            success: function (html) {

            	$('#userList').html(" ");
            	$("#updateUsersForm").html(html);
            }            

        });			

	}


	function deleteUser(id) {

		var baseUrl = 'http://practicaltest.com/';

        $.ajax({
            url: baseUrl + 'register/deleteUserData',
            data: {'id':id},                        
            type: 'POST',
            async:false,
            
            success: function (res) {
    
            	let r = JSON.parse(res);
    
            	if(r.status == true) {

            		alert(r.message);
	            	loadUserLists();
            	}
            }            

        });
	}


	function loadUserLists() {

		var baseUrl = 'http://practicaltest.com/';

        $.ajax({
            url: baseUrl + 'register/getUseLists',
            type: 'POST',
            cache:false,
            contentType: false,
            processData: false,		            
            
            success: function (html) {
            	$('#registerUser').html(' ');
            	$("#usersview").html(html);
            }            

        });
	}

	function sendImageToEmail(id, user, email) {

		var captureLength = 'detailImage_' + id;

		screenshot(id, captureLength, user, email);	

	}

    function screenshot(id, captureLength, user, email) {

        html2canvas(document.querySelector("#"+captureLength)).then(function(canvas) {
                        
            var base64URL = canvas.toDataURL('image/jpeg').replace('image/jpeg', 'image/octet-stream');
                       
            $.ajax({
                url: 'http://practicaltest.com/register/takeUserDetailsScreenShot',
                type: 'post',
                data: {image: base64URL, fname: user, id: id, email: email},
                success: function(data){
                    let response = JSON.parse(data);

                    if(response.status == true) {
                    	alert(response.message);
                    	loadUserLists();
                    }
                }
            });
        });
    }			
</script>