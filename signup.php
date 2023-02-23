<?php
	//include the db connection page
	require("dbconnect.php");

	//page to sanitize data
	include("my_funct.php");


	//Checking if the save button has been clicked
	if(isset($_POST['save'])){
		//var_dump($_POST['firstname']);
		//Creating variables to hold the form data
		$firstname = $surname =  $email = $password = '';
		$phonenumber = 0;
		
		//Picking up the data from form
		$firstname = $_POST['firstname'];
		$surname = $_POST['surname'];
		//$user_id = $_POST['id'];
		$email = $_POST['email'];
		$phonenumber = $_POST['phonenumber'];
		
		$password = $_POST['password'];
		
		$error = array('firstname' => '', 'surname' => '', 'phonenumber' => '', 'email' => '', 'password' => '', 'general' => '');
		
		$success = '';
		
		//echo "<p style='color:white;'>$firstname $surname $phonenumber $email $password <p/>";
		
		//Validating Data
		
		//Check if first name has been filled
		if(empty($firstname)){
			$error['firstname'] = "<p style='color:red;'>Please enter your first name.<p/>";
		}else{
			//Prevent Cross Site Scripting Attack
			$firstname = sanitize($firstname);
			
			//Check whether special characters have been used on the name
			if (!preg_match('/^[a-z ]+$/i', $firstname)){
				$error['firstname'] = "<p style='color:red;'>Please use letter a-z only on your first name.<p/>";
			}
		}
		
		//Check if surname has been filled
		if(empty($surname)){
			$error['surname'] = "<p style='color:red;'>Please enter your surname.<p/>";
		}else{
			//Prevent Cross Site Scripting Attack
			$surname = sanitize($surname);
			//Check whether special characters have been used on the name
			if (!preg_match('/^[a-z ]+$/i', $surname)){
				$error['surname'] = "<p style='color:red;'>Please use letter a-z only on your surname.<p/>";
			}
		}
		
		//Check if Phonenumber has been filled
		if(empty($phonenumber)){
			$error['phonenumber'] = "<p style='color:red;'>Please enter your Phone number.<p/>";
		}else{
			//Prevent Cross Site Scripting Attack
			$phonenumber = sanitize($phonenumber);
			
			//check whether phone number is a number
			if(is_int($phonenumber)){
				$error['phonenumber'] = "<p style='color:red;'>Phone Number must be digits between 0-9 only.<p/>";
			}
			
			if(strlen($phonenumber)!= 10){
				$error['phonenumber'] = "<p style='color:red;'>Phone Number must have 10 digits.<p/>";
			}
		}
		
		//Check if Email Address has been filled
		if(empty($email)){
			$error['email'] = "<p style='color:red;'>Please enter your Email Address.<p/>";
		}else{
			//Prevent Cross Site Scripting Attack
			$email = sanitize($email);
			//Check whether email address is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			  $error['email'] = "<p style='color:red;'>Invalid email address ($email), please check and try again.<p/>";
			}
		}
		
		//Check if Password has been filled
		if(empty($password)){
			$error['password'] =  "<p style='color:red;'>Please enter your Password.<p/>";
		}else{
			//Prevent Cross Site Scripting Attack
			$password = sanitize($password);
			
			
		}
		$email_check_sql = "SELECT * FROM users WHERE email = '$email'  ";
		$email_res = mysqli_query($dbconnect, $email_check_sql);
		$rows = mysqli_num_rows($email_res);
		if($rows > 0)
		{
			$error['already_exists'] = "<p style='color:red;'>Email already used by other user.<p/>";
		}
		if(array_filter($error)){
			$error['general'] = "<p style='color:red;'>Please sort out the above errors before you can proceed.<p/>";
		}else{
			
			//This is the sql statement to insert data to the user table
			$sql = "INSERT INTO users (firstname, surname, email, phonenumber,password) 
								VALUES ('$firstname', '$surname', '$email', $phonenumber,  '$password')";
			
			//We execute the sql statement using the query() function 
			//And check whether the data is saved successfully using the if statement
			
			if ($dbconnect->query($sql) === TRUE) {
				$success = "<p style='color:green;'>Successful Signup! Now you can <a href='login.php'>Login</a>!<p/>";
				header("Location: login.php");
			} else {
				$error['general'] = "<p style='color:red;'> Error: " . $dbconnect->error . "</p>";
			}

			
		}
		
	}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Glassmorphism login Form Tutorial in html css</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>Glassmorphism login Form Tutorial in html css</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <style media="screen">
      *,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body{
    background-color: #080710;
}
.background{
    width: 430px;
    height: 520px;
    position: absolute;
    transform: translate(-50%,-50%);
    left: 50%;
    top: 50%;
}
.background .shape{
    height: 200px;
    width: 200px;
    position: absolute;
    border-radius: 50%;
}
.shape:first-child{
    background: linear-gradient(
        #1845ad,
        #23a2f6
    );
    left: -80px;
    top: -80px;
}
.shape:last-child{
    background: linear-gradient(
        to right,
        #ff512f,
        #f09819
    );
    right: -30px;
    bottom: -80px;
}
form{
    height: auto;
    width: 400px;
	margin-top: 350px;
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 50px 35px;
}
form *{
    font-family: 'Poppins',sans-serif;
    color: #ffffff;
    letter-spacing: 0.5px;
    outline: none;
    border: none;
}
form h3{
    font-size: 32px;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
}

label{
    display: block;
    margin-top: 30px;
    font-size: 16px;
    font-weight: 500;
}
input{
    display: block;
    height: 50px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #e5e5e5;
}
input[type="submit"]{
    margin-top: 50px;
    width: 100%;
    background-color: #ffffff;
    color: #080710;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}
.social{
  margin-top: 30px;
  display: flex;
}
.social div{
  background: red;
  width: 150px;
  border-radius: 3px;
  padding: 5px 10px 10px 5px;
  background-color: rgba(255,255,255,0.27);
  color: #eaf0fb;
  text-align: center;
}
.social div:hover{
  background-color: rgba(255,255,255,0.47);
}
.social .fb{
  margin-left: 25px;
}
.social i{
  margin-right: 4px;
}

.no:checked ~ input[type="submit"]{
	display:none;
}
    </style>

	

</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="signup.php" method="post" id="register">
        
		<h3>Signup Here</h3>

        <label for="fname">First Name</label>
        <input type="text" id="firstname" name="firstname"  maxlength="15" value="<?php if(isset($firstname)){ echo $firstname;}?>" required>
		<div id="fnameerror" style="color:red;"></div>
		<?php if(isset($error['firstname'])){ echo $error['firstname']; }?>
        
		
		
        <label for="surname">Surname</label>
        <input type="text" id="surname" name="surname" value="<?php if(isset($surname)){ echo $surname;}?>" required>
		<?php if(isset($error['surname'])){ echo $error['surname']; }?>
		
		<label for="phonenumber">Phone Number</label>
        <input type="number" id="phonenumber" name="phonenumber" maxlength="10" pattern="[0-9{10}]" placeholder="07xxxxxxxx" value="<?php if(isset($phonenumber)){ echo $phonenumber;}?>" required>
		<?php if(isset($error['phonenumber'])){ echo $error['phonenumber']; }?>
		
		<label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="<?php if(isset($email)){ echo $email;}?>" required autocomplete="off">
		<?php if(isset($error['email'])){ echo $error['email']; }?>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" value="<?php if(isset($password)){ echo $password;}?>" required>
		<?php if(isset($error['password'])){ echo $error['password']; }?>

		<?php if(isset($error['general'])){ echo $error['general']; }?>
		<?php if(isset($success)){ echo $success; }?>
		<label for="policy">Agree to our privacy policy.</label>
		<label>Yes</label> <input type="radio" class="yes" id="yes" name="policy"> 
		<label>No</label> <input type="radio" class="no" id="no" name="policy"> 
		
        <input type="submit" id="save" name="save" value="Signup" >
		
        <div class="social">
          <div class="go"><i class="fab fa-google"></i>  Google</div>
          <div class="fb"><i class="fab fa-facebook"></i>  Facebook</div>
        </div>
    </form>
	
<script type="text/javascript">
	const form = document.getElementById('register');
	const fname = document.getElementById('fname');
	const phonenumber = document.getElementById('phonenumber');
	var error = document.getElementById('fnameerror');
	
	form.addEventListener('submit', (e) => {
		
		if(fname.value === '' || fname.value == null){
			error.innerText = "Enter your first name.";	
			e.preventDefault(); //prevents submission
		}
		
		if(phonenumber.value.length < 10 || phonenumber > 10)
		{
			alert("Phone number is supposed to have 10 digits only.");
			e.preventDefault();//prevents submission
		}
		
	})
</script>


</body>

</html>
<!-- partial -->
  
</body>
</html>
