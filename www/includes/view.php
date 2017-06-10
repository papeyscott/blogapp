<!DOCTYPE html>
<html>
<head>
	<title><?php echo $page_title ?></title>
	<link rel="stylesheet" type="text/css" href="../styles/styles.css">
</head>

<body>
	<section>
		<div class="mast">
			<h1><a href="home.php">T<span>SSB</span> Home</a></h1>
			<nav>
				<ul class="clearfix">
					<li><a href="add_post.php" <?php Tools::culNav("add_post.php"); ?>>Add Post</a></li>
					<li><a href="view_post.php" <?php Tools::culNav("view_post.php");?>>View Post</a></li>
										<li><a href="logout.php" <?php Tools::culNav("logout.php");?>>Logout</a></li>
				</ul>
			</nav>
		</div>
	</section>