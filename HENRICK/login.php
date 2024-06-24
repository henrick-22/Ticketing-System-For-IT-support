<?php
if(isset($_POST['btnlogin'])){
	//require the config file
	require_once "config.php";
	//sql stmt for checking if the inputted UN and PW is on the table
	$sql = "SELECT * FROM tblaccount WHERE username = ? AND password = ? AND status = 'ACTIVE'";
	//check if the sql will run on the db connection by preparing the statement
	if($stmt = mysqli_prepare($link, $sql)){
		//blind the data from the form to the statement
		mysqli_stmt_bind_param($stmt, "ss", $_POST['txtusername'], $_POST['txtpassword']);
		//check if the statement will execute
		if (mysqli_stmt_execute($stmt)){
			//get the result of execution
			$result	= mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result) > 0){
				//fetch the result into array
				$account = mysqli_fetch_array($result, MYSQLI_ASSOC);
				if($account['usertype'] == 'ADMINISTRATOR'){
    				$_SESSION['usertype'] = true;
    				session_start();	
					//create session
					$_SESSION['username'] = $_POST['txtusername'];
					$_SESSION['usertype'] = $account['usertype'];
            		header("location:account.php");
    			}
				if($account['usertype'] == 'TECHNICAL'){
    				$_SESSION['usertype'] = true;
    				session_start();	
					//create session
					$_SESSION['username'] = $_POST['txtusername'];
					$_SESSION['usertype'] = $account['usertype'];
            		header("location: account.php");
    			}
			}
			else{
				echo "<font color = 'red'><p align = center>(Incorrect login credentials or account is inactive)</p></font>";
			}
		} 
	}
	else{
		echo "Error on select statement";
	}
}
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Animated Login Form | CodingNepal</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="center">
      <h1>Login</h1>
      <form method="post">
        <div class="txt_field">
          <input type="text" name="txtusername" required>
          <span></span>
          <label>Username</label>
        </div>
        <div class="txt_field">
          <input type="password" name="txtpassword" required>
          <span></span>
          <label>Password</label>
        </div>
        <div class="pass">Forgot Password?</div>
        <input type="submit" value="Login" name = "btnlogin">
        <div class="signup_link">
          Not a member? <a href="#">Signup</a>
        </div>
      </form>
    </div>

  </body>
</html>
