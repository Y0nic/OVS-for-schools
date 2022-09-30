<?php

	session_start();
	include_once("connect.php");
	
	$voting_qry = mysqli_query($con,"select * from voting_list WHERE display = '1'") or die(mysqli_error($con));
	$voting_id = mysqli_fetch_array($voting_qry);
	
	if($_SESSION["access"] == "user"){
		
		header("Location: index.php?id=".$voting_id["id"]);
		
	}elseif($_SESSION["access"] == "admin"){
		
		
		
	}else{
		
		header("Location: login.php");
		
	}
	
	if(!isset($_GET["id"]) or $_GET["id"] != $voting_id["id"]){
		
		header("Location: voting_list.php?id=".$voting_id["id"]);
		
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
	<script type="text/javascript" src="voting_list_script.js?ts=<?=time()?>"></script>
</head>
<body>
<!--Navigation-->
<header>

	<!-- Sidebar -->
	<nav id="sidebarMenu" class="collapse d-lg-block sidebar shadow">

		<div class="position-sticky">
			<div class="list-group list-group-flush mx-3 mt-4">
				<h3>Administrator</h3>
				<a class="list-group-item list-group-item-action py-2 ripple" href="home.php?id=<?php echo $id;?>">
					<i class="fas fa-home fa-fw me-3"></i>
					<span>Home</span>
				</a>
				<a class="list-group-item list-group-item-action py-2 ripple" href="users.php?id=<?php echo $id;?>">
					<i class="fas fa-user fa-fw me-3"></i>
					<span>Users</span>
				</a>
				<a class="list-group-item list-group-item-action py-2 ripple active" href="voting_list.php?id=<?php echo $id;?>">
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

	
	<!-- Add Voting-->
	<div class="container pt-4">
		<div class="row">
			<div class="col-md-1" style="height: 100px;"></div>
			<div class="col-md-10">
			
				<!-- Add Voting-->
				<div class="shadow p-3 mb-2 bg-body rounded">
					<h4>Add Voting list</h4>
					<hr>
						<table class="table">
							<td>
								<label class="h6">Title</label>
								<br>
								<input type="text" id="voting_title" class="form-control form-control-sm w-100">
								<p class="text-danger none">Please enter voting title</p>
							</td>
							<td>
								<label class="h6">Description</label>
								<br>
								<input type="text" id="voting_description" class="form-control form-control-sm w-100">
								<p class="text-danger none">Please enter voting description</p>
							</td>
							<td class="text-center">
								<br>
								<button id="add_voting" class="btn btn-primary">Add to Voting List</button>
							</td>
						</table>
				</div>
				<!-- Add Voting-->
				
				<!-- Voting List-->
				<?php
					
					$voting_list_qry = mysqli_query($con,"select * from voting_list order by display DESC") or die(mysqli_error($con));
					
				?>
				<div id="voting_list">
				<div class="shadow p-3 mb-5 bg-body rounded">
					<h4>Voting List</h4>
					<hr>
					<table class="table table-hover">
					<thead>
						<th>Title</th>
						<th>Description</th>
						<th class="text-center">Display</th>
						<th></th>
					</thead>
					<tbody>
					<?php
					
						while($voting_list = mysqli_fetch_array($voting_list_qry)){
					
					?>
						<tr>
							<td><?php echo $voting_list["voting_title"]?></td>
							<td><?php echo $voting_list["voting_description"]?></td>
							<td class="text-center">

								<span onclick="set_default(this)" class="badge text-light pointer default <?php if($voting_list["display"] == 1){echo "bg-success";}else{echo "bg-danger";}?>" data-id="<?php echo $voting_list["id"]?>" data-display=<?php echo $voting_list["display"];?>>Default</span>

							</td>
							<td class="text-center">
									<a href="voting_management.php?id=<?php echo $voting_list["id"]?>"><span class="btn btn-sm btn-primary">Edit</span></a>
									
								<button onclick="remove(this)" class="btn btn-sm btn-danger remove" data-id="<?php echo $voting_list["id"];?>" data-voting="<?php echo $voting_list["voting_title"];?>" data-bs-toggle="modal" data-bs-target="#alert_modal" role="button"> Remove </button>
							</td>
						</tr>
					<?php };?>
					</tbody>
					</table>
				</div>
				</div>
				<!-- Voting List-->
			</div>
			<div class="col-md-1" style="height: 100px;"></div>
		</div>
	</div>
	<br>
</main>
<!--Main layout-->
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
</body>
</html>