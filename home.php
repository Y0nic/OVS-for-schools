<?php
	
	session_start();
	include_once("connect.php");
	
	$voting_qry = mysqli_query($con,"select * from voting_list WHERE display = '1'") or die(mysqli_error($con));
	$voting_list = mysqli_fetch_array($voting_qry);
	
	if($_SESSION["access"] == "user"){
		
		header("Location: index.php?id=".$voting_list["id"]);
		
	}elseif($_SESSION["access"] == "admin"){
		
		
		
	}else{
		
		header("Location: login.php");
		
	}
	
	if(!isset($_GET["id"]) or $_GET["id"] != $voting_list["id"]){
		
		header("Location: home.php?id=".$voting_list["id"]);
		
	}else{

		$id = $_GET["id"];
	
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
	<script type="text/javascript" src="script.js?ts=<?=time()?>"></script>
</head>
<body>
<!--Navigation-->
<header>

	<!-- Sidebar -->
	<nav id="sidebarMenu" class="collapse d-lg-block sidebar shadow">

		<div class="position-sticky">
			<div class="list-group list-group-flush mx-3 mt-4">
				<h3>Administrator</h3>
				<a class="list-group-item list-group-item-action py-2 ripple active" href="home.php?id=<?php echo $id;?>">
					<i class="fas fa-home fa-fw me-3"></i>
					<span>Home</span>
				</a>
				<a class="list-group-item list-group-item-action py-2 ripple" href="users.php?id=<?php echo $id;?>">
					<i class="fas fa-user fa-fw me-3"></i>
					<span>Users</span>
				</a>
				<a class="list-group-item list-group-item-action py-2 ripple" href="voting_list.php?id=<?php echo $id;?>">
					<i class="fas fa-list fa-fw me-3"></i>
					<span>Voting List</span>
				</a>
				<a class="list-group-item list-group-item-action py-2 ripple" id="side_logout" href="logout.php">
					<i class="fas fa-sign-out-alt"></i>
					<span>Logout</span>
				</a>
			</div>
		</div>

	</nav>
	<!-- Sidebar -->

	<!-- Navbar -->
	<nav id="main-navbar" class="navbar navbar-expand-lg navbar-light fixed-top">
	
		<div class="container-fluid">
		
				<!-- Logo -->
			<p class="navbar-brand">
				<h5 id="logo">School</h5>
			</p>
				<!-- Logo -->
				
				<!-- Navbar Content -->
			<ul class="navbar-nav ms-auto">
				<li class="nav-item">
					<span class="align-top"><?php echo $_SESSION["userlog"];?></span>
					<a class="text-dark text-decoration-none me-5 signout" href="logout.php">
						<i class="fas fa-sign-out-alt"></i>
					</a>
					<i class="fas fa-bars me-3" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"></i>
				</li>
			</ul>
			<!-- Navbar Content -->
			
		</div>
		
	</nav>
	<!-- Navbar -->

</header>
<!--Navigation-->

<!--Page Content-->
<main>
	<div class="container pt-4">
		<div class="row">
		
			<div class="col-md-1"></div>
			
			<div class="col-md-10">
				<div class="shadow">
				
					<!-- Cover Photo -->
					<div class="rounded">
						<img src="assets/img/cover_photo.jpg" class="card-img-top" alt="...">
					</div>
					<!-- Cover Photo -->
				
					<div class="shadow-sm p-3 mb-3 bg-body rounded">
					
					<!-- Voting Details -->
						<p class="text-center h1 lh-1"><?php echo $voting_list["voting_title"];?></p>
						<p class="text-center lh-1"><?php echo $voting_list["voting_description"];?></p>
					<!-- Voting Details -->
						
					<!-- Category Details -->
						<?php 
						
						$category_qry = mysqli_query($con,"select * from category WHERE voting_id = $id order by id") or die(mysqli_error($con));
						
						$total_votes = 0;
						
						while($category = mysqli_fetch_array($category_qry)){
						
						$candidate_qry = mysqli_query($con,"select * from candidate WHERE voting_id = $id && category_id = ".$category["id"]." order by id") or die(mysqli_error($con));
						
						while($candidate = mysqli_fetch_array($candidate_qry)){
							
							$total_votes += $candidate["votes"];;
							
						}
						?>
						<hr>
						<h2 class="text-center"><?php echo $category["category"]?></h2>
						<br>
						
						<div class="row row-cols-1 row-cols-md-3 g-3 g-md-3 justify-content-center">
							
							<!-- Candidate Details -->
							<?php
							
								$candidate_qry = mysqli_query($con,"select * from candidate WHERE voting_id = $id && category_id = ".$category["id"]." order by id") or die(mysqli_error($con));
								
								while($candidate = mysqli_fetch_array($candidate_qry)){
								
								$votes = $candidate["votes"];
								if($votes == 0){
									
									$vote_percentage = 0;
									
								}else{
									
									$vote_percentage = $votes/	$total_votes;
									
								}
							?>
							<div class="col">
								<div class="card">
									<div class="card-body" align="center">
										<h4 class="card-title"><?php echo $candidate["first_name"]." ".$candidate["last_name"];?></h4>
										<h5><span class="badge"><?php echo $votes." (".round($vote_percentage*100, 2)."%)";?></span></h5>
									</div>
								</div>
							</div>
								<?php };?>
							<!-- Candidate Details -->
							
				
						</div>
						<?php };?>
						<br>
						<!-- Category Details -->
							
					</div>
				</div>
				
				<p class="mb-4 text-white">NOTE: To print the result of the voting, click <a href="#" onclick="print_result(this)" data-id="<?php echo $id;?>">Print</a>.</p>
				
			</div>
			
			<div class="col-md-1"></div>
			
		</div>
	</div>
</main>
<!--Main layout-->
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
</body>
</html>