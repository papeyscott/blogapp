<?php
	
	session_start();
	
# include db connection
	include 'includes/db.php';

	# page Title
	$page_title = "Add Post";

	# include function
	include 'includes/functions.php';
	Tools::LoginCheck();

	# include header
	include 'includes/view.php';

	
	

	$id = $_SESSION['id'];
	
	$errors = [];

	if(array_key_exists('add', $_POST)){

		if(empty($_POST['title'])){
			$errors['title'] = "Please Enter Blog's Title";
		}

		if(empty($_POST['content'])){
			$errors['content'] = "Please Enter Blog's Content";
		}

		if(empty($errors)){

			$clean = array_map('trim', $_POST);
			$clean['content'] = htmlspecialchars($clean['content']);

			Tools::insertIntoPost($conn, $clean, $id);
			
			
		}
	}

?>	

	<div class="wrapper">
<h1 id="register-label">Add Post</h1>
<hr>
		<div id="stream">


				<form id="register" action ="add_post.php" method ="POST">

				<div>
					<label>Blog Title</label>	
				<input type="text" name="title" placeholder="Blog Title">
				</div>
					
				<div>
				<label>Blog Content</label>
					<textarea name="content" placeholder="Place Contents Here" rows="5" cols="15"></textarea>
				</div>

				<input type="submit" name="add" value="Add">
				</form>

				
				</div>
				</div>