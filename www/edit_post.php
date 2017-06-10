<?php 
session_start();
	
# include db connection
	include 'includes/db.php';

	# page Title
	$page_title = "Edit Post";

	# include function
	include 'includes/functions.php';
	Tools::LoginCheck();

	# include header
	include 'includes/view.php';

	if(isset($_GET['post_id'])){

		$pID = $_GET['post_id'];
	}
		$item = Tools::getPostByID($conn, $_GET['post_id']);

		$name = Tools::AdminName($conn, $item['admin_id']);

		$errors = [];
	if(array_key_exists('edit', $_POST)){

		if(empty($_POST['title'])){
			$errors['title'] = "Please Enter New Title You Want";
		}

		if(empty($_POST['body'])){
			$errors['body'] = "Please Enter new Content";
		}

		if(empty($_POST['name'])){
			$errors['name'] = "Please Select Bloggers Name";
		}

		if(empty($errors)){

			$clean = array_map('trim', $_POST);
			$clean['pi'] = $pID;

			Tools::updatePost($conn, $clean);

			Tools::redirect("view_post.php");
		}

	}
?>

	<div class="wrapper">
<h1 id="register-label">Edit Post</h1>
<hr>
		<div id="stream">


				<form id="register" action ="" method ="POST">

				<div>
					<label>Blog Title</label>	
				<input type="text" name="title" placeholder="Blog Title" value="<?php echo $item['title']; ?>">
				</div>

				<div>
					<label>Blog Content</label>	
				<textarea name="body" placeholder="Place Contents Here" rows="5" cols="15">
					<?php echo $item['body']; ?>
				</textarea>
				</div>
					
				<div>
				<label>Select Category</label>
				<select name="name">
					<option value="<?php echo $name['admin_id'] ?>"> <?php echo $name['firstname']; ?> </option>
					<?php 
						$sel = Tools::editBloggerName($conn, $name['firstname']);
						echo $sel;
					?>
				</select>
				</div>

				<input type="submit" name="edit" value="Edit">
				</form>

				
				</div>
				</div>
