<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>PHP Registration Form</title>
		<link rel="stylesheet" href="asset/css/screen.css">

		<link href="asset/css/jquery-ui.css" rel="stylesheet">
	<script type="text/javascript" src="asset/js/lib/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="asset/js/lib/jquery-ui.js"></script>

	<script src="asset/js/dist/jquery.validate.js"></script>
	
	
	<script>
	
	$.validator.setDefaults({
		submitHandler: function(form) {
			alert('okbos');
			form.submit();
			
			
		}
	});
	
	$.validator.addMethod('isIdNumber', function (value, element, param) {
		if((value.substring(0, 2) === '08' || value.substring(0, 2) === '62') && (value.length >= '10' && value.length <= '12')){
			return true;
		}else{
			return false;
		}
		
	}, 'Please input valid indonesian number');

	$().ready(function() {
		// validate the comment form when it is submitted
		$("#commentForm").validate({
			rules: {
				mnumber: {
				  required: true,
				  digits: true,
				  isIdNumber:true,
				  remote: "/PhpRegistration/checkno.php"
				},
				fname: {
					required: true,
					minlength: 2
				},
				lname: {
					required: true,
					minlength: 2
				},
				email: {
					required: true,
					email: true,
					remote: "/PhpRegistration/checkemail.php"
				}
			},
			messages: {
				mnumber: {
					required: "Please enter your mobile number",
					digits: "Please enter valid number",
					remote: "This no already registered"
				},
				fname: "Please enter your firstname",
				lname: "Please enter your lastname",
				email: {
					required: "Please provide a valid email address",
					remote: "This email already registered"
				}
			}
		});

		
	});
	
	$(function(){
	  $("#datebirth").datepicker({ dateFormat: 'yy-mm-dd' });
	});
	
	</script>
	<style>
	#commentForm {
		width: 500px;
		margin : 0 auto;
	}
	#commentForm label {
		width: 250px;
	}
	#commentForm label.error, #commentForm input.submit {
		margin-left: 253px;
	}
	
	</style>
</head>
<body>

<div id="main">
	<form class="cmxform" id="commentForm" method="post" action="">
		<fieldset>
			<legend>Registration User</legend>
			<p>
				<label for="mnumber">Mobile Number (required)</label>
				<input id="mnumber" name="mnumber" type="text" />
			</p>
		
			<p>
				<label for="fname">First Name (required)</label>
				<input id="fname" name="fname" type="text" />
			</p>
			<p>
				<label for="lname">Last Name (required)</label>
				<input id="lname" type="text" name="lname">
			</p>
			<p>
				<label for="datebirth">Date of birth (optional)</label>
				<input id="datebirth" name="datebirth" />
			</p>
			<p>
				<label for="gender">Gender(optional)</label>
				<input type="radio" id="gender" name="gender" value="male"> Male
				<input type="radio" id="gender" name="gender" value="female"> Female
			</p>
		
			<p>
				<label for="email">Email (required)</label>
				<input id="email" type="email" name="email">
			</p>
			<p>
				<input class="submit" type="submit" name="submit" value="Register">
			</p>
			
		</fieldset>
	</form>
	<p>
				<input style="margin-left:50%; width:200px;padding:5px;visibility:hidden;" 
					id="login" type="button" value="LOGIN" />
	</p>
	<?php
if(isset($_POST['submit'])) 
{ 

	$configs = include('config.php');

	$servername = $configs->host;
	$username = $configs->username;
	$password = $configs->password;
	$dbname = $configs->database;
	
	// data passing 
	$mobileno = $_POST['mnumber'];
	$firstname = $_POST['fname'];
	$lastname = $_POST['lname'];
	$datebirth = $_POST['datebirth'];
	$gender = $_POST['gender'];
	$email = $_POST['email'];
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "INSERT INTO t_registration (mobile_no, first_name,last_name,dateofbirth, gender,email)
	VALUES ('$mobileno', '$firstname', '$lastname','$datebirth','$gender','$email')";

	if ($conn->query($sql) === TRUE) {
	  echo "New record created successfully";
	  echo "<script> $('#commentForm :input').prop('disabled', true); document.getElementById('login').style.visibility = 'visible'; </script>";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}

$conn->close();
}
?>
</div>
</body>
</html>
