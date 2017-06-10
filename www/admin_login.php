<?php
		session_start();
	# include db connection
	include 'includes/db.php';

	# page Title
	$page_title = "Login";

	# include header
	include 'includes/header.php';

	# include function
	include 'includes/functions.php';

	# error caching
	$errors = [];

	if(array_key_exists('login', $_POST)){

		if(empty($_POST['email'])){
			$errors['email'] = "Please Enter Your Email";
		}

		if(empty($_POST['password'])){
			$errors['password'] = "Please Enter Your Password";
		}

		if(empty($errors)){
			$clean = array_map('trim', $_POST);

			$chk = Tools::adminLogin($conn, $clean);

			$_SESSION['id'] = $chk['admin_id'];
			$_SESSION['fname'] = $chk['firstname'];

			Tools::redirect("add_post.php");
		}
	}
?>

<div class="wrapper">
		<h1 id="register-label">Admin Login</h1>
				<hr>
		<form id="register"  action ="admin_login.php" method ="POST">
			<div>
				<?php
					if(isset($_GET['msge']))
					echo '<span class="err">'. $_GET['msge']. '</span>';
					
						$display = Tools::DisplayErrors($errors, 'email');
						echo $display;

				?>
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<?php
					if(isset($_GET['msge']))
					echo '<span class="err">'. $_GET['msge']. '</span>';
					
					$display = Tools::DisplayErrors($errors, 'password');
					echo $display;
				?>
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>

			<input type="submit" name="login" value="login">
		</form>

		<h4 class="jumpto">Don't have an account? <a href="admin_register.php">register</a></h4>
		</div>

