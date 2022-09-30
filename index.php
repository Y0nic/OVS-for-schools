<?php
	
	session_start();
	include_once("connect.php");
	
	$voting_qry = mysqli_query($con,"select * from voting_list WHERE display = '1'") or die(mysqli_error($con));
	$voting_list = mysqli_fetch_array($voting_qry);
	
	if($_SESSION["access"] == "admin"){
		
		header("Location: admin.php");
		
	}elseif($_SESSION["access"] == "user"){
		
		
		
	}else{
		
		header("Location: login.php");
		
	}
	
	if(!isset($_GET["id"]) or $_GET["id"] != $voting_list["id"]){
		
		header("Location: index.php?id=".$voting_list["id"]);
		
	}

	$id = $_GET["id"];
	
	
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
	<script type="text/javascript" src="script.js?ts=<?=time()?>"></script>
	<script type="text/javascript" src="index_script.js?ts=<?=time()?>"></script>
</head>
<body>

	<!--Navigation-->
<header>

	<!-- Navbar -->
	<nav id="main-navbar" class="navbar navbar-expand-lg navbar-light fixed-top">
	
		<div class="container-fluid">
		
				<!-- Logo -->
			<a class="navbar-brand" href="#">
				<h5>School</h5>
			</a>
				<!-- Logo -->
				
				<!-- Navbar Content -->
			<ul class="navbar-nav ms-auto d-flex flex-row">
				<li class="nav-item me-5">
				<span class="align-top"><?php echo $_SESSION["userlog"];?></span>
				<a class="text-dark" href="logout.php">
					<i class="fas fa-sign-out-alt"></i>
				</a>
				</li>
			</ul>
			<!-- Navbar Content -->
			
		</div>
		
	</nav>
	<!-- Navbar -->

</header>
<!--Navigation-->

<!--Check Vote modal-->
<div class="modal fade" id="check_vote" aria-hidden="true" aria-labelledby="label" tabindex="-1">

	<div class="modal-dialog modal-dialog-scrollable">
	
		<form method="post" class="modal-content" action="ajax.php">
		
			<div class="modal-header">
			
				<h5 class="modal-title" id="label">Check Your Vote</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				
			</div>
			
			<div class="modal-body">
						
					<!-- Category Details -->
						<p class="text-center h1 lh-1"><?php echo $voting_list["voting_title"];?></p>
							<?php
						
							$modal_category_qry = mysqli_query($con,"select * from category WHERE voting_id = '$id'") or die(mysqli_error($con));
							while($category = mysqli_fetch_array($modal_category_qry)){
						
						?>
						<hr>
						<h2 name="<?php echo $category["id"]?>"><?php echo $category["category"]?></h2>
						<input class="form-check-input me-2" type="hidden" name="<?php echo $category["id"]?>" value="sdas">
						<label class="form-check-label">You didn't vote for this category</label>
							<?php };?>
						
			</div>
			
			<div class="modal-footer">
				<input type="hidden" name="id" value="<?php echo $id;?>">
				<button type="submit" name="action" class="btn btn-primary" value="vote">Submit Votes</button>
				
			</div>
			
		</form>
		
	</div>
	
</div>
<!--Check Vote modal-->

<br>
<br>

<!--Page Content-->
	<div class="container pt-4">
		<div class="row">
		
			<div class="col-1"></div>
			
			<div class="col-10">
				<div class="shadow">
				
					<!-- Cover Photo -->
					<div class="rounded">
						<img src="assets/img/cover_photo.jpg" class="card-img-top" alt="...">
					</div>
					<!-- Cover Photo -->
				
					<div id="voting_container" class="shadow-sm p-3 mb-5 bg-body rounded">
					
					<!-- Voting Details -->
				
						<h1 class="text-center"><?php echo $voting_list["voting_title"];?></h1>
						<p class="text-center"><?php echo $voting_list["voting_description"];?></p>
					<!-- Voting Details -->
						
					<!-- Category Details -->
						<?php

							if($_SESSION["vote"] > 0){
								
								echo "<hr>";
								echo "Thank You for Voting.";
								
							}else{
						
						
							$category_qry = mysqli_query($con,"select * from category WHERE voting_id = '$id'") or die(mysqli_error($con));
							while($category = mysqli_fetch_array($category_qry)){
						
						?>
						<hr>
						<h2 class="ms-3" data-category="<?php echo $category["id"];?>"><?php echo $category["category"];?></h2>
						<br>
						
						<div class="row row-cols-1 row-cols-md-3 g-3 g-md-3 justify-content-start">
							
							<!-- Candidate Details -->
							<?php
							
								$candidater_qry = mysqli_query($con,"select * from candidate WHERE category_id = '".$category["id"]."' order by `last_name` desc") or die(mysqli_error($con));
							
								while($candidate = mysqli_fetch_array($candidater_qry)){
							?>
							
							<div class="col d-flex justify-content-start content">
								<input type="radio" class="form-check-input me-2" name="<?php echo $category["id"]?>" id="<?php echo $candidate["id"];?>" data-id="<?php echo $candidate["id"];?>" value="<?php echo $candidate["first_name"]." ".$candidate["last_name"];?>">
								<label class="form-check-label" for="<?php echo $candidate["id"]?>"><?php echo $candidate["first_name"]." ".$candidate["last_name"];?></label>
							</div>
								<?php };?>
							<!-- Candidate Details -->
							
						</div>
							<?php };?>
						<br>
						<hr>
						<div class="text-center">
						<button id="check" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#check_vote">Check</button>
						</div>
							<?php };?>
				</div>
			</div>
			
			<div class="col-1"></div>
			
		</div>
	</div>
<!--Main layout-->

<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
</body>
</html>