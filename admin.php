<?php 
    session_start();

	include_once("connect.php");
		
	$alert = "";
	
	if(isset($_POST["login"])){
		$pass = mysqli_real_escape_string($con, $_POST["pass"]);
		
		$user_qry = mysqli_query($con,"select pass from users where id = '".$_SESSION["id"]."'") or die(mysqli_error($con));
		$user = mysqli_fetch_array($user_qry);
		
		if(empty($pass)){
			
			$alert = "Please Enter Password";
			
		}elseif($user["pass"] == $pass) {
			
			$voting_qry = mysqli_query($con,"select id from voting_list where display = 1") or die(mysqli_error($con));
			$voting = mysqli_fetch_array($voting_qry);
			
			header("Location: home.php?id=".$voting["id"]);
			
		}else {
			
			$alert = "Sorry wrong password";
			
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
	<script src="assets/jquery/JQuery.js"></script>
</head>
<body>
<div class="container h-100">
	<div class="row d-flex justify-content-center">
		<div class="col-sm-7 m-4">
			<div class="shadow-lg rounded-3 bg-white">
			
				<img src="assets/img/cover_photo.jpg" class="card-img-top" alt="">
				
				<form method="post" style="padding: .5% 2% 2% 2%;">
				
				<br>
				<h2 align="center">Voting System<h2>
				<h5 align="center">Administrator</h5>
				<br>
				<p class="h6 text-danger text-center"><?php echo $alert;?></p>
				
				<div class="input-group col-lg-6 mb-4 w-75 m-auto">
					<div class="input-group-prepend">
						<span class="input-group-text bg-white border-md border-end-0 pt-3 px-3">
							<i class="fas fa-lock h6 fs-4"></i>
						</span>
					</div>
					
					<input class="form-control border-md border-start-0 login" type="password" name="pass" placeholder="Password">
					
				</div>
						
				<div align="center"><input type="submit" class="btn btn-lg btn-primary" name="login" value="Enter"></div>
				
				</form>
				<p class="ps-5 ms-2">Not an admin? <a href="logout.php">Back to login</a></p>
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