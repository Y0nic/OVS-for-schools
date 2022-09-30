<?php
	
	session_start();
	include_once("connect.php");
	
	if($_SESSION["access"] == "user"){
		
		header("Location: index.php");
		
	}elseif($_SESSION["access"] == "admin"){
		
		
		
	}else{
		
		header("Location: login.php");
		
	}
	
	$id = $_GET["id"];
	
	$voting_list_qry = mysqli_query($con,"SELECT * FROM `voting_list` WHERE id = '$id'") or die(mysqli_error($con));
	$voting_list = mysqli_fetch_array($voting_list_qry);
	
	$category_qry = mysqli_query($con,"SELECT * FROM `category` WHERE voting_id = '$id' order by id") or die(mysqli_error($con));
	
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
	<script type="text/javascript" src="voting_management_script.js?ts=<?=time()?>"></script>
</head>
<body style="overflow: visible;">	
<!--Navigation-->
<header>

	<!-- Sidebar -->
	<nav id="sidebarMenu" class="collapse d-lg-block sidebar shadow">

		<div class="position-sticky">
			<div class="list-group list-group-flush mx-3 mt-4">
				<h3>Administrator</h3>
				<a class="list-group-item list-group-item-action py-2 ripple" href="home.php">
					<i class="fas fa-home fa-fw me-3"></i>
					<span>Home</span>
				</a>
				<a class="list-group-item list-group-item-action py-2 ripple" href="users.php">
					<i class="fas fa-user fa-fw me-3"></i>
					<span>Users</span>
				</a>
				<a class="list-group-item list-group-item-action py-2 ripple active" href="voting_list.php">
					<i class="fas fa-list fa-fw me-3"></i>
					<span>Voting List</span>
				</a>
				<a id="side_logout" class="list-group-item list-group-item-action py-2 ripple" href="logout.php">
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
			<ul class="navbar-nav ms-auto d-flex flex-row">
				<li class="nav-item">
				<span class="align-top"><?php echo $_SESSION["userlog"];?></span>
				<a class="text-dark text-decoration-none me-5 signout" href="logout.php">
					<i class="fas fa-sign-out-alt"></i>
				</a>
				<i class="fas fa-bars me-3" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-expanded="false" aria-controls="collapseExample"></i>
				</li>
			</ul>
			<!-- Navbar Content -->
			
		</div>
		
	</nav>
	<!-- Navbar -->

</header>
<!--Navigation-->

<?php include_once("alerts_and_modals.php");?>

<!--Page Content-->
<main>
	
	
	<div class="container pt-4">
		<div class="row">
			<div class="col-md-1" style="height: 100px;"></div>
			<div class="col-md-10">
				<div class="shadow p-3 mb-5 bg-body rounded" id="edit_voting">
					
					<!--voting list-->
					<p class="text-center h1 lh-1"><?php echo $voting_list["voting_title"];?></p>
					<p class="text-center lh-1"><?php echo $voting_list["voting_description"];?></p>
					<!--Voting list-->
					
					<hr>
		
					<!--Add Category and Candidate-->
					<div align="right">
						<span class="btn btn-sm btn-primary me-1" id="add_category" data-bs-toggle="modal" data-bs-target="#add_category_modal" role="button">Add Category</span>
						<span class="btn btn-sm btn-primary me-1" id="add_candidate" data-bs-toggle="modal" data-bs-target="#add_candidate_modal" role="button">Add Candidate</span>
					</div>
					<!--Add Category and Candidate-->
					
					<!--View Category and Candidate-->
					<div id="reloader">
					<?php 
					
					while($category = mysqli_fetch_array($category_qry)){
						
					?>
					
					<span class="h3"><?php echo $category["category"];?></span>
						
						<a onclick="edit(this)" class="btn-sm align-top text-decoration-none p-0 edit" data-id="<?php echo $category["id"];?>" data-label="category" data-category="<?php echo $category["category"];?>" data-bs-toggle="modal" data-bs-target="#edit_category_modal" role="button"> Edit </a>
						
						<a onclick="remove(this)" class="btn-sm align-top text-decoration-none text-danger p-0 remove" data-id="<?php echo $category["id"];?>" data-label="category" data-category="<?php echo $category["category"];?>" data-bs-toggle="modal" data-bs-target="#alert_modal" role="button"> Remove </a>
					
					<table class="table table-hover">
					<thead>
						<th>Last Name</th>
						<th>First Name</th>
						<th class="w-25"></th>
					</thead>
					<tbody>
						
						<?php 
						
							
						$candidate_qry = mysqli_query($con,"SELECT * FROM `candidate` WHERE voting_id = '$id' && category_id = ".$category["id"]." order by id") or die(mysqli_error($con));
						
						while($candidate = mysqli_fetch_array($candidate_qry)){
							
						?>
						
						<tr>
							<td class=""><?php echo $candidate["first_name"];?></td>
							<td class=""><?php echo $candidate["last_name"];?></td>
							
							<!--Edit and Remove Candidate-->
							<td class="text-center">
								<button type="button" onclick="edit(this)" class="btn btn-sm btn-primary edit" data-id="<?php echo $candidate["id"];?>" data-first_name="<?php echo $candidate["first_name"];?>" data-surname="<?php echo $candidate["last_name"];?>" data-category="<?php echo $candidate["category_id"];?>" data-bs-toggle="modal" data-bs-target="#edit_candidate_modal"> Edit </button>
									
								<button type="button" onclick="remove(this)" class="btn btn-sm btn-danger remove" data-id="<?php echo $candidate["id"];?>" data-first_name="<?php echo $candidate["first_name"];?>" data-surname="<?php echo $candidate["last_name"];?>" data-bs-toggle="modal" data-bs-target="#alert_modal"> Remove </button>
							</td>
							<!--Edit and Remove Candidate-->
							
						</tr>
						<?php };?>
					</tbody>
					</table>
					<?php };?>
					</div>
					<!--View Category and Candidate-->
					
				</div>
			</div>
			<div class="col-md-1" style="height: 100px;"></div>
		</div>
	</div>
</main>
<!--Main layout-->

<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
</body>
</html>