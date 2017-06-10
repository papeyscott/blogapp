<?php
		
	# include db connection
	include 'includes/db.php';

	# page Title
	$page_title = "Register";

	# include header
	include 'includes/header.php';

	# include function
	include 'includes/functions.php';

	# error caching
	$errors = [];

	# form validation
	if(array_key_exists('register', $_POST)){

		if(empty($_POST['fname'])){
			$errors['fname'] = "Please Enter Your Firstname";
		}

		if(empty($_POST['lname'])){
			$errors['lname'] = "Please Enter Your Lastname";
		}

		if(empty($_POST['email'])){
			$errors['email'] = "Please Enter Your Email";
		}

		if(Tools::doesEmailExist($conn, $_POST['email'])){
			$errors['email'] = "Email Already Exists";
		}

		if(empty($_POST['password'])){
			$errors['password'] = "Please Enter Your Password";
		}

		if(empty($_POST['pword'])){
			$errors['pword'] = "Please Confirm Your Password";
		}

		if($_POST['pword'] != $_POST['password']){
			$errors['pword'] = "Password Does not match";
		}

		if(empty($errors)){

			$clean = array_map('trim', $_POST);

			$clean['password'] = password_hash($clean['password'], PASSWORD_BCRYPT);

			Tools::doAdminRegister($conn, $clean);

			Tools::redirect("admin_login.php?msg=You have been successfully registered. Please Login");
		}
	}
			
?>

	
	<div class="wrapper">
		<h1 id="register-label">Admin Register</h1>
		<hr>
		<form id="register"  action ="admin_register.php" method ="POST">
			<div>
				<?php 
						$display = Tools::DisplayErrors($errors, 'fname');
						echo $display;
				?>
				<label>first name:</label>
				<input type="text" name="fname" placeholder="first name">
			</div>
			<div>
				<?php 
						$display = Tools::DisplayErrors($errors, 'lname');
						echo $display;
				?>
				<label>last name:</label>	
				<input type="text" name="lname" placeholder="last name">
			</div>

			<div>
				<?php 
						$display = Tools::DisplayErrors($errors, 'email');
						echo $display;
				?>
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<?php 
						$display = Tools::DisplayErrors($errors, 'password');
						echo $display;
				?>
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>
			<div>
				<?php 
						$display = Tools::DisplayErrors($errors, 'pword');
						echo $display;
				?>
				<label>confirm password:</label>	
				<input type="password" name="pword" placeholder="password">
			</div>

			<input type="submit" name="register" value="register">
		</form>

		<h4 class="jumpto">Have an account? <a href="admin_login.php">login</a></h4>
	</div>
