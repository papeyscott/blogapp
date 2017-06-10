<?php

	class Tools {

		public static function doesEmailExist($dbconn, $email){

			$result = false;

			$stmt = $dbconn->prepare("SELECT * FROM admin WHERE email=:em");
			$stmt->bindParam(':em', $email);
			$stmt->execute();

			$count = $stmt->rowCount();

			if($count > 0) {$result = true; }

			return $result;
		}

		public static function doAdminRegister($dbconn, $input){

			$stmt = $dbconn->prepare("INSERT INTO admin(firstname, lastname, email, hash)
									VALUES(:f, :l, :e, :h)");

			$data = [
						':f'=> $input['fname'],
						':l'=> $input['lname'],
						':e'=> $input['email'],
						':h'=> $input['password']
					];
			$stmt->execute($data);
		}

		public static function DisplayErrors($key, $value){

			$result = "";

			if(isset($key[$value])){
				$result = '<span class="err">'. $key[$value]. '</span>';
			}

			return $result;
		}

		public static function redirect($loca){
			header("Location: ".$loca);
		}

		public static function adminLogin($dbconn, $input){

			$result = [];

			$stmt = $dbconn->prepare("SELECT admin_id, firstname, hash FROM admin WHERE email=:em");
			$stmt->bindParam(':em', $input['email']);
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_BOTH);
			$count = $stmt->rowCount();

			if($count != 1 || password_verify($input['password'], $row['hash'])){

				Tools::redirect("admin_login.php?msge=invalid username or password");
				exit();

			} else
			{
				$result = true;
				$result = $row;
			}

			return $result;
		}

		public static function culNav($page){

		$curPage = basename($_SERVER['SCRIPT_FILENAME']);

		if($curPage == $page) {
			echo 'class="selected"';
			}
		}

	public static function insertIntoPost($dbconn, $input, $adminID){

		$date = date("Y-m-00");

		$stmt = $dbconn->prepare("INSERT INTO post(admin_id, title, body, date_post, arch_date)
								VALUES(:a, :t, :b, now(), :d)");
		$data = [
					':a'=> $adminID,
					':t'=> $input['title'],
					':b'=> $input['content'],
					':d'=> $date
				];
		$stmt->execute($data);
	}

	public static function LoginCheck() {
		if(!isset($_SESSION['id'])) {

			header("Location:admin_login.php");
		}
	}

	public static function AdminName($dbconn, $id){
		$stmt = $dbconn->prepare("SELECT firstname FROM admin WHERE admin_id=:ai");
		$stmt->bindParam(':ai', $id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_BOTH);

		return $row;
	}

	public static function viewPost($dbconn){

		$result = "";

		$stmt = $dbconn->prepare("SELECT * FROM post");
		$stmt->execute();

		while($row = $stmt->fetch(PDO::FETCH_BOTH)){

			$row1 = Tools::AdminName($dbconn, $row['admin_id']);

			$result .= '<tr><td>'.$row[2].'</td><td>'.$row1[0].'</td><td>'.$row[3].'</td><td>'.$row[4].
						'</td><td><a href="edit_post.php?post_id='.$row[0].'">edit</a></td>
						<td><a href="delete_post.php?post_id='.$row[0].'">delete</a></td>
						<td><a href="archiveback.php?post_id='.$row[0].'">archive</a></td></tr>';

		}

		return $result;
	}

	public static function getPostByID($dbconn, $postID){
		$stmt = $dbconn->prepare("SELECT * FROM post WHERE post_id=:id");
			$stmt->bindParam(':id', $postID);

			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
			return $row;
	}

	public static function editBloggerName($dbconn, $adName) {
			$statement = $dbconn->prepare("SELECT * FROM admin");
						$statement->execute();

						$result = "";
						while($row = $statement->fetch(PDO::FETCH_ASSOC)) { 

							$admin_id = $row['admin_id'];
							$fname = $row['firstname'];

							#to skip the category_name chosen

							if($fname == $adName) { continue; }

						$result .= "<option value='$admin_id'>$fname</option>";
					}
					return $result;
		}

		public static function updatePost($dbconn, $input){

			$stmt = $dbconn->prepare("UPDATE post SET admin_id=:ai, title=:ti, body=:by WHERE post_id=:pi");

			$data = [
						':ai'=>$input['name'],
						':ti'=>$input['title'],
						':by'=>$input['body'],
						':pi'=>$input['pi']
					];

			$stmt->execute($data);
		}

		public static function deletePost($dbconn, $input){

			$stmt = $dbconn->prepare("DELETE FROM post WHERE post_id=:pi");
			$stmt->bindParam(':pi', $input);
			$stmt->execute();
		}

		public static function getPost($dbconn){
			$stmt = $dbconn->prepare("SELECT * FROM post");
			$stmt->execute();
	 		$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return $row;
		}

		private static function checkArchive($dbconn, $pd){

			$stmt = $dbconn->prepare("SELECT * FROM archive WHERE post_id=:pd");
			$stmt->bindParam(':pd', $pd);
			$stmt->execute();

			return $stmt;
		}

		public static function insertIntoArchive($dbconn, $pd, $dt){

			$chk = Tools::checkArchive($dbconn, $pd);
			$count = $chk->rowCount();

			if($count == 0) {

			$stmt = $dbconn->prepare("INSERT INTO archive(post_id, arch_date) VALUES(:pi, :da)");

			$data = [
						':pi'=>$pd,
						':da'=>$dt
					];
			$stmt->execute($data);
			}
		}


		public static function ViewPostFrontend($dbconn){

			$result = "";
			$stmt = $dbconn->prepare("SELECT admin_id, title, body, DATE_FORMAT(date_post, '%M %e, %Y') AS d FROM post");
			$stmt->execute();
			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$row1 = Tools::AdminName($dbconn, $row['admin_id']);

			$result	.= '<h2 class="blog-post-title">'.$row['title'].'</h2>
            <p class="blog-post-meta">'.$row['d']. " by " .'<a href="#">'.$row1['firstname'].'</a></p>';

            $result .= htmlspecialchars_decode($row['body']);
			}

			return $result;
		}


		public static function fetchArchive($dbconn){

			$result = "";

			$stmt = $dbconn->prepare("SELECT DISTINCT DATE_FORMAT(arch_date, '%M %Y') AS da, arch_date FROM archive");
			$stmt->execute();

			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		
				$result .= '<li><a href="archive.php?date='.$row['arch_date'].'">'.$row['da'].'</a></li>';
              
			}	

			return $result;	
		}

		public static function getPostByDate($dbconn, $date){
			$stmt = $dbconn->prepare("SELECT * FROM post WHERE arch_date=:id");
			$stmt->bindParam(':id', $date);

			$stmt->execute();

			return $stmt;
	}		
}