<?php

	$blogTitle = "Trial and Error";

	$blogDesc = "Testing This Blog";

	include 'includes/front_header.php';

	include 'includes/functions.php';

	include 'includes/db.php';
?>

	<div class="container">

      <div class="row">

        <div class="col-sm-8 blog-main">
		<div class="blog-post">
            
            	<?php
            			$view = Tools::ViewPostFrontend($conn);
            			echo $view;
            	?>
       </div>
       </div>
       			 <?php
       					include 'sidebar.php';
      			 ?>

       </div><!-- /.row -->

        <nav class="blog-pagination">
            <a class="btn btn-outline-primary" href="#">Older</a>
            <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
          </nav>

    </div><!-- /.container -->

    <?php 
    		include 'front_footer.php';
    ?>

       