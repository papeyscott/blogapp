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

	if(isset($_GET['post_id'])){
		Tools::deletePost($conn, $_GET['post_id']);
	}
	Tools::redirect("view_post.php");

?>
