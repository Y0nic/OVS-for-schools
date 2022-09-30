<?php

   
	include_once("connect.php");
	session_start();

	$alert = "";
	
	if(isset($_POST["login"])){
		
		$user = mysqli_real_escape_string($con, $_POST["user"]);
		$login_qry = mysqli_query($con,"select * from users where LRN = '$user'") or die(mysqli_error($con));
		$login = mysqli_fetch_array($login_qry);
		
		if(empty($login)){
			
			$alert = "Sorry, Undefined LRN";
			
		} else{
			
			if(empty($user)){
				
				$alert = "Please Enter LRN";
				
			}elseif($login["LRN"] == $user && $login["access"] == "user"){
				
				$_SESSION["userlog"] = $login["first_name"]." ".$login["last_name"];
				$_SESSION["access"] = $login["access"];
				$_SESSION["id"] = $login["id"];
				
				$voting_qry = mysqli_query($con,"select id from voting_list where display = 1") or die(mysqli_error($con));
				$voting = mysqli_fetch_array($voting_qry);
				
				$result = mysqli_query($con, "SHOW COLUMNS FROM `users` LIKE 'vote_".$voting[0]."'") or die(mysqli_error($con));
				
				if((mysqli_num_rows($result))?TRUE:FALSE){
					
					$_SESSION["vote"] = $login['vote_'.$voting[0]];
				
				}
				
				header("Location: index.php?id=".$voting[0]);

			}else if($login["LRN"] == $user && $login["access"] == "admin"){
				
				$_SESSION["userlog"] = $login["first_name"]." ".$login["last_name"];
				$_SESSION["access"] = $login["access"];
				$_SESSION["id"] = $login["id"];
				
				$voting_qry = mysqli_query($con,"select id from voting_list where display = 1") or die(mysqli_error($con));
				$voting = mysqli_fetch_array($voting_qry);
				
				$result = mysqli_query($con, "SHOW COLUMNS FROM `users` LIKE 'vote_".$voting[0]."'") or die(mysqli_error($con));
				
				if((mysqli_num_rows($result))?TRUE:FALSE){
					
					$_SESSION["vote"] = $login['vote_'.$voting[0]];
				
				}
				
				header("Location: admin.php");
				
			}else{
				
				$alert = "Sorry, Undefined LRN";
			
			}
		}
	}
	
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title>Voting System</title>
	<link rel="icon" href="assets/img/logo.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/fontawesome/css/all.css">
	<link rel="stylesheet" type="text/css" href="style.css?ts=<?=time()?>">
	<script type="text/javascript" src="assets/jquery/JQuery.js"></script>
</head>
<body>
<div class="container h-100">
	<div class="row d-flex justify-content-center">
		<div class="col-sm-7 m-5">
			<div class="shadow-lg rounded-3 bg-white">
			
				<img src="assets/img/cover_photo.jpg" class="card-img-top" alt="">
				
				<form method="post" style="padding: .5% 2% 2% 2%;">
				
					<br>
					<h2 align="center">Voting System<h2>
					<br>
					<p class="h6 text-danger text-center"><?php echo $alert;?></p>
					
					<div class="input-group col-lg-6 mb-4 w-75 m-auto">
						<div class="input-group-prepend">
							<span class="input-group-text bg-white border-md border-end-0 pt-3 px-3">
								<i class="fas fa-user h6 fs-4"></i>
							</span>
						</div>
						
						<input class="form-control border-md border-start-0 login" type="text" name="user" placeholder="LRN">
						
					</div>
					<div align="center">
					<input type="submit" class="btn btn-lg btn-primary" name="login" value="Enter">
					</div>
				
				</form>
				<br>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
	  $("input").focusin(function(){
		$(this).parent().find(".input-group-text").css({"border-color": "#80bdff", "color": "#6699FF"});
	  });
	  	  $("input").focusout(function(){
		$(this).parent().find(".input-group-text").css({"border-color": "#CFD8DC", "color": "#6c757d"});
	  });
	});
</script>
</body>
</html>