<?php
	
	//add voting
	function add_voting(){
		
		include("connect.php");
		
		$title = $_POST["title"];
		$description = $_POST["description"];
		
		mysqli_query($con,"INSERT INTO `voting_list`(`voting_title`, `voting_description`, `display`) VALUES ('$title', '$description', '0')");
		
		$voting_qry = mysqli_query($con,"SELECT MAX(Id) FROM voting_list") or die(mysqli_error($con));
		$id = mysqli_fetch_array($voting_qry);
			
		mysqli_query($con,"ALTER TABLE users ADD COLUMN vote_".$id[0]." int(11);") or die(mysqli_error($con));
		
	}
	// add voting
	
	//set default display
	function set_default(){
		
		include("connect.php");
		
		$id = $_POST["id"];
		$display = $_POST["display"];
		
		if($display == 1){
			
			mysqli_query($con,"UPDATE `voting_list` SET display = '0'") or die(mysqli_error($con));
			
		}else{
			
			$month = date("m");
			$year = date("Y");
			$date = date("d");

			if($month == 1){
				
				$month = "January";
				
			}else if($month == 2){
				
				$month = "February";
				
			}else if($month == 3){
				
				$month = "March";
				
			}else if($month == 4){
				
				$month = "April";
				
			}else if($month == 5){
				
				$month = "May";
				
			}else if($month == 6){
				
				$month = "June";
				
			}else if($month == 7){
				
				$month = "July";
				
			}else if($month == 8){
				
				$month = "August";
				
			}else if($month == 9){
				
				$month = "September";
				
			}else if($month == 10){
				
				$month = "October";
				
			}else if($month == 11){
				
				$month = "November";
				
			}else if($month == 12){
				
				$month = "December";
				
			}else{
				
				$month = "";
				
			}
			
			mysqli_query($con,"UPDATE `voting_list` SET display = '0'") or die(mysqli_error($con));
			mysqli_query($con,"UPDATE `voting_list` SET `display` = '1' WHERE id = $id") or die(mysqli_error($con));
			mysqli_query($con,"UPDATE `voting_list` SET `date` = '".$month." ".$date.", ".$year."' WHERE id = $id") or die(mysqli_error($con));
			
		}
	}
	//set default display
	
	// remove voting
	function remove_voting(){
	
		include("connect.php");
		
		$id = $_POST["id"];//voting id
		
		//selecting the column in user table with the current voting id
		$result = mysqli_query($con, "SHOW COLUMNS FROM `users` LIKE 'vote_".$id."'") or die(mysqli_error($con));
		
		//checking if the column in user table with the current voting id exist
		if((mysqli_num_rows($result))?TRUE:FALSE){
			mysqli_query($con,"ALTER TABLE users DROP COLUMN vote_".$id.";") or die(mysqli_error($con));
		}
		
		//getting the voting category from user table with the current voting id
		$category_qry = mysqli_query($con, "select * from category WHERE voting_id = $id") or die(mysqli_error($con));
			
			//deleting the column of category in the user
			while($category = mysqli_fetch_array($category_qry)){
							
				$cat_voting_id = $id;
				
				$result = mysqli_query($con, "SHOW COLUMNS FROM `users` LIKE '".str_replace(' ', '_', $category['category'])."_".$cat_voting_id."'") or die(mysqli_error($con));
				
				if((mysqli_num_rows($result))?TRUE:FALSE){
					mysqli_query($con,"ALTER TABLE users DROP COLUMN ".str_replace(' ', '_', $category['category'])."_".$cat_voting_id.";") or 	die(mysqli_error($con));
				}
				
			};
		
		//for the deletion of image file we need to get the location form the database
		$candidate_qry = mysqli_query($con, "select * from candidate WHERE voting_id = $id") or die(mysqli_error($con));
		while($candidate = mysqli_fetch_array($candidate_qry)){
			
				//checking if the image file exist
				if(file_exists('img/candidate_profile/'.$candidate['img_profile'])){
					unlink('img/candidate_profile/'.$candidate['img_profile']);
				}
			};
		
		//deleting the voting
		mysqli_query($con,"DELETE FROM voting_list WHERE id = '$id'") or die(mysqli_error($con));
		//deleting the candidates
		mysqli_query($con,"DELETE FROM candidate WHERE voting_id = '$id'") or die(mysqli_error($con));
		// deleting the category
		mysqli_query($con,"DELETE FROM category WHERE voting_id = '$id'") or die(mysqli_error($con));

	}
	//remove voting
	
	//add category
	function add_category(){
		
		include("connect.php");
		
		$category = $_POST["category"];//category title
		$voting_id = $_POST["voting_id"];//voting id
		
		if(mysqli_query($con,"ALTER TABLE users ADD COLUMN ".$category."_".$voting_id." int(11);") or die(mysqli_error($con))){
			
			$category = str_replace("_", " ", $_POST["category"]);
			
			mysqli_query($con,"INSERT INTO `category`(`category`, `voting_id`) VALUES ('$category', '$voting_id')") or die(mysqli_error($con));
			
		}
		
	}
	//add category
	
	//add candidate
	function add_candidate(){
		
		include("connect.php");
		
		$name = str_replace("_", " ", $_POST["name"]);//category title
		$surname = str_replace("_", " ", $_POST["surname"]);//category title
		$category = $_POST["category"];//category title
		$voting_id = $_POST["voting_id"];//voting id
			
		mysqli_query($con,"INSERT INTO `candidate`(`first_name`, `last_name`, `category_id`, `voting_id`) VALUES ('$name', '$surname', '$category', '$voting_id')") or die(mysqli_error($con));
		
	}
	//add candidate
	
	//remove candidate
	function remove_candidate(){
		
		include("connect.php");
		
		$id = $_POST["id"];//candidate id
		
		mysqli_query($con,"DELETE FROM candidate WHERE id = '$id'") or die(mysqli_error($con));
		
	}
	//remove candidate
	
	//remove category
	function remove_category(){
		
		include("connect.php");
		
		$id = $_POST["id"];//category id
		$voting_id = $_POST["voting_id"];//category id
		$name = $_POST["category"];//category title
		
		//selecting the column in user table with the requested deletion of category
		$result = mysqli_query($con, "SHOW COLUMNS FROM `users` LIKE '".$name."_".$voting_id."'") or die(mysqli_error($con));
		
		//checking if the column in user table with the requested deletion of category exist
		if((mysqli_num_rows($result))?TRUE:FALSE){
			mysqli_query($con,"ALTER TABLE users DROP COLUMN ".$name."_".$voting_id.";") or die(mysqli_error($con));
		}
		
		mysqli_query($con,"DELETE FROM category WHERE id = '$id'") or die(mysqli_error($con));
		
		mysqli_query($con,"DELETE FROM candidate WHERE category_id = '$id'") or die(mysqli_error($con));
		
	}
	//remove category
	
	//edit candidate
	function edit_candidate(){
		
		include("connect.php");
		
		$id = $_POST["id"];
		$name = str_replace("_", " ", $_POST["name"]);
		$surname = str_replace("_", " ", $_POST["surname"]);
		$category = $_POST["category"];
		
		mysqli_query($con,"UPDATE candidate SET  first_name = '$name', last_name = '$surname', category_id = '$category' WHERE id = '$id'") or die(mysqli_error($con));
		
	}
	//edit candidate
	
	//edit category
	function edit_category(){
		
		include("connect.php");
		
		$id = $_POST["id"];
		$category = str_replace("_", " ", $_POST["category"]);
		
		mysqli_query($con,"UPDATE category SET  category = '$category' WHERE id = '$id'") or die(mysqli_error($con));
		
	}
	//edit category
	
	//add user
	function add_user(){
		
		include("connect.php");
		
		$name = str_replace("_", " ", $_POST["first_name"]);
		$surname = str_replace("_", " ", $_POST["last_name"]);
		$access = str_replace("_", " ", $_POST["access"]);
		$pass = str_replace("_", " ", $_POST["pass"]);
		$LRN = str_replace("_", " ", $_POST["LRN"]);
		
		mysqli_query($con,"INSERT INTO `users`(`first_name`, `last_name`, `access`, `pass`, `LRN`) VALUES ('$name', '$surname', '$access', '$pass', '$LRN')");
		
	}
	//add user
	
	//remove user
	function remove_user(){
		
		include("connect.php");
		
		$id = $_POST["id"];
		
		mysqli_query($con,"DELETE FROM users WHERE id = '$id' or access = '$id'") or die(mysqli_error($con));
			
	}
	//remove user
	
	//reset vote
	function reset_vote(){
		
		include("connect.php");
		
		$id = $_POST["id"];
		$voting_id = $_POST["voting_id"];
		
		mysqli_query($con,"UPDATE `users` SET `vote_".$voting_id."` = '0' WHERE id = '$id' or access = '$id'") or die(mysqli_error($con));
		
	}
	//reset vote
	
	//user voting
	function vote(){
		
		include("connect.php");
		
		$voting_id = $_POST["id"];
		
		$category_qry = mysqli_query($con,"select * from category WHERE voting_id = ".$voting_id) or die(mysqli_error($con));
		
		while($category = mysqli_fetch_array($category_qry)){
			
			$user_column = str_replace(' ', '_', $category['category']).'_'.$voting_id;
			
			$vote = $_POST[$category["id"]];
			
			$user_id = $_SESSION["id"];
			
		mysqli_query($con, "UPDATE users SET $user_column = $vote WHERE id ='$user_id'") or die(mysqli_error($con));
			
		mysqli_query($con, "UPDATE candidate SET votes = votes+1 WHERE id ='$vote'") or die(mysqli_error($con));
			
		}
		
		mysqli_query($con, "UPDATE users SET vote_".$voting_id." = vote_".$voting_id."+1 WHERE id ='$user_id'") or die(mysqli_error($con));
		
		$_SESSION["vote"] = 1;
		
		header("Location: index.php?id=".$voting_id);
		
	}
	//user voting