<?php

session_start();
	
# include db connection
	include 'includes/db.php';

	# page Title
	$page_title = "View Post";

	# include function
	include 'includes/functions.php';
	Tools::LoginCheck();

	# include header
	include 'includes/view.php';

?>
<div class="wrapper">
				<h1 id="register-label">View Post</h1>
				<hr>
				<div id="stream">

			<table id="tab">
				<thead>
					<tr>
						<th>Title</th>
						<th>Blogger</th>
						<th>Content</th>
						<th>Date</th>
						<th>Edit</th>
						<th>Delete</th>
						<th>Archive</th>
					</tr>
				</thead>
				<tbody>
				
						<?php
								$view = Tools::viewPost($conn);
								echo $view;
						?>

          		</tbody>
			</table>
		</div>
