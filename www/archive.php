<?php
	
	$blogTitle = "Trial and Error";

	$blogDesc = "Testing This Blog";

	include 'includes/front_header.php';

	include 'includes/functions.php';

	include 'includes/db.php';

	if(isset($_GET['date'])){

		$datey = $_GET['date'];
	}

	 

?>
	<div class="container">

        <div class="row">

        <div class="col-sm-8 blog-main">
		<div class="blog-post">
            
            <?php 
            		$data = Tools::getPostByDate($conn, $datey);
            		while($row = $data->fetch(PDO::FETCH_ASSOC)) {
            		$row1 = Tools::AdminName($conn, $row['admin_id']);	
            ?>

        <div class="blog-post">
            <h2 class="blog-post-title"><?php echo $row['title'] ?></h2>
            <p class="blog-post-meta"><?php echo $row['date_post'] ?> by <a href="#"><?php echo $row1['firstname']; ?></a></p>

            <?php echo htmlspecialchars_decode($row['body']); ?>
       

       		<?php } ?>
       		</div>
       		</div>
       		</div>
       		
       		<nav class="blog-pagination">
            <a class="btn btn-outline-primary" href="#">Older</a>
            <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
          	</nav>

       	</div><!-- /.row -->

    </div><!-- /.container -->

       	<?php 

    		include 'front_footer.php';
    	?>	