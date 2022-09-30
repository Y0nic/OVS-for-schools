<?php

	session_start();
	include_once("connect.php");
	
		$alert = "";
		
		if(isset($_POST['add_users'])){
			
				$csv_name = $_FILES['csv']['name'];
				$csv_tmp_name = $_FILES['csv']['tmp_name'];
				$csv_extension = explode('.', $csv_name);
				$csv_ext_to_lower = strtolower(end($csv_extension));
				$allowed = array('csv');
			
			if(empty($csv_name)){
				
				$alert = "Please Select a file";
				
			}elseif(in_array($csv_ext_to_lower, $allowed)){
				
				$handle = fopen($csv_tmp_name, "r");
				while($data = fgetcsv($handle)){
					
					$first_name = $data[0];
					$last_name = $data[1];
					$LRN = $data[2];
					$access = 'user';
					
					mysqli_query($con,"INSERT INTO `users`(`first_name`, `last_name`, `LRN`, `pass`, `access`) VALUES ('$first_name', '$last_name', '$LRN', 'none', '$access')") or die(mysqli_error($con));
					
					include_once('success.php');
					
				}
			}else{
				
				$alert = "Please select a csv file only";		
				
			}
		}
	
	$voting_qry = mysqli_query($con,"select * from voting_list WHERE display = '1'") or die(mysqli_error($con));
	$voting_id = mysqli_fetch_array($voting_qry);
	
	if($_SESSION["access"] == "user"){
		
		header("Location: index.php?id=".$voting_id["id"]);
		
	}elseif($_SESSION["access"] == "admin"){
		
		
		
	}else{
		
		header("Location: login.php");
		
	}
	
	if(!isset($_GET["id"]) or $_GET["id"] != $voting_id["id"]){
		
		header("Location: users.php?id=".$voting_id["id"]);
		
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
	<link rel="stylesheet" type="text/css" href="assets/DataTables/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" type="text/css" href="style.css?ts=<?=time()?>">
	<script type="text/javascript" src="assets/jquery/JQuery.js"></script>
	<script type="text/javascript" src="script.js?ts=<?=time()?>"></script>
	<script type="text/javascript" src="users_script.js?ts=<?=time()?>"></script>
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
				<a class="list-group-item list-group-item-action py-2 ripple active" href="users.php?id=<?php echo $id;?>">
					<i class="fas fa-user fa-fw me-3"></i>
					<span>Users</span>
				</a>
				<a class="list-group-item list-group-item-action py-2 ripple" href="voting_list.php?id=<?php echo $id;?>">
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
					<i class="fas fa-bars me-3" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"></i>
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
			
				<!-- Add User-->
				<div class="shadow p-3 mb-2 bg-body rounded" id="add_user_container">
					<h4>Add User</h4>
					<hr>
						<table class="table">
							<td>
								<label class="h6">Fist Name</label>
								<input type="text" name="first_name" class="form-control form-control-sm w-100 first_name" value="" required>
								<span class="h6 text-danger none">Please enter name</span>
							</td>
							
							<td>
								<label class="h6">Last Name</label>
								<input type="text" name="last_name" class="form-control form-control-sm w-100 last_name" value="" required>
								<span class="h6 text-danger none">Please enter surname</span>
							</td>
							
							<td>
								<label class="h6">LRN Number</label>
								<input type="number" name="LRN" class="form-control form-control-sm w-100 LRN" value="">
								<span class="h6 text-danger none">Please enter LRN</span>
							</td>
							
							<td>
								<label class="h6">Access</label>
								<select class="form-select form-select-sm" id="access" name="access">
								  <option id="user" value="user">User</option>
								  <option id="admin" value="admin">Admin</option>
								</select>
							</td>
							
							<td class="text-center">
								<br>
								<button id="add_user" name="add_user" class="btn btn-primary">Add User</button>
							</td>
						</table>
				</div>
				<!-- Add User-->
				
				<!-- Add users using csv -->
				<div class="shadow p-3 mb-2 bg-body rounded">
					<h4>Add Users Using CSV File</h4>
					<hr>
					<form method="post" enctype="multipart/form-data">
						<input type="file" name="csv" class="form-control form-control-sm">
						<p class="text-danger h6"><?php echo $alert;?></p>
						<p>NOTE: Let Column A, B, C as "First Name", "Last Name", and "LRN" in csv file.</p>
						<span class="d-flex justify-content-end pe-3">
						<input type="submit" class="btn btn-primary" name="add_users" value="Add Users">
						</span>
					</form>
				</div>
				<!-- Add users using csv -->
			
				<div id="reloader">
				<!--Admin-->
				<div class="shadow p-3 mb-2 bg-body rounded" id="admin">
					
					<h4>Administrator <span class="badge bg-info"></span></h4>
					<hr>
					<table class="table table-hover">
						<thead>
							<th>First Name</th>
							<th>Last Name</th>
							<th>LRN</th>
							<th class="px-0 py-2"></th>
						</thead>
						<tbody>
							<?php
							
								$admin_qry = mysqli_query($con,"SELECT * FROM `users` WHERE access = 'admin' order by id") or die(mysqli_error($con));
								
								while($admin = mysqli_fetch_array($admin_qry)){
								
							?>
							<tr>
								<td class="align-middle"><?php echo $admin["first_name"];?></td>
								<td class="align-middle"><?php echo $admin["last_name"];?></td>
								<td class="align-middle">
								
									<?php if(strlen($admin["LRN"]) == 12){?>
									<span><?php echo $admin["LRN"];?></span>
									<?php }else{?>
									<span class="text-danger"><?php echo $admin["LRN"];?></span>
									<?php }?>
								</td>
								<td class="px-0 py-2 text-center">
								
										<button type="button" class="btn btn-sm btn-primary edit" data-id="1" data-first_name="Blas" data-surname="Lilang" data-LRN="123" data-access="admin" data-pass="admin" data-bs-toggle="modal" data-bs-target="#edit_user_modal"> Edit </button>
										<button type="button" onclick="alert(this)" class="btn btn-sm btn-danger" data-label="remove" data-id="<?php echo $admin["id"];?>" data-fullname="<?php echo $admin["first_name"]." ".$admin["last_name"];?>" data-bs-toggle="modal" data-bs-target="#alert_modal"> Remove </button>
								
								</td>
							</tr>
								<?php };?>
						</tbody>
					</table>
				</div>
				<!--Admin-->
				
				<!--User-->
				<div class="shadow p-3 mb-2 bg-body rounded" id="users">
					<h4>Users <span class="badge bg-info"></span></h4>
					
					<hr>
					<table id="user_table" class="table table-hover" style="width:100%">
						<thead>
							<th>Last Name</th>
							<th>First Name</th>
							<th>LRN</th>
							<th>Votes</th>
							<th class="w-25 px-0 py-2 text-center">
									<button type="button" onclick="alert(this)" class="btn btn-sm btn-warning" data-id="user" data-fullname="All Users"data-bs-toggle="modal" data-bs-target="#alert_modal"> Reset Vote </button>
									<button type="button" onclick="alert(this)" class="btn btn-sm btn-danger" data-id="user" data-label="remove"data-fullname="All Users" data-bs-toggle="modal" data-bs-target="#alert_modal"> Remove </button>
							</th>
						</thead>
						<tbody>
							<?php
							
								$user_qry = mysqli_query($con,"SELECT * FROM `users` WHERE access = 'user' order by id") or die(mysqli_error($con));
								
								while($users = mysqli_fetch_array($user_qry)){
								
							?>
							<tr>
								<td class="align-middle"><?php echo $users["first_name"];?></td>
								<td class="align-middle"><?php echo $users["last_name"];?></td>
								<td class="align-middle">
								
									<?php if(strlen($users["LRN"]) == 12){?>
									<span><?php echo $users["LRN"];?></span>
									<?php }else{?>
									<span class="text-danger"><?php echo $users["LRN"];?></span>
									<?php }?>
								</td>
								<td class="align-middle">
								    
								    <?php 
								    
								    $result = mysqli_query($con, "SHOW COLUMNS FROM `users` LIKE 'vote_".$id."'") or die(mysqli_error($con));
								    
								    if((mysqli_num_rows($result))?TRUE:FALSE){
								    
    								    if($users["vote_".$id] == 1){
    								        
								    ?>
									<span>Voted</span>
									<?php
									
									    }else{
									        
									?>
									<span class="text-danger">Not Yet</span>
									<?php }?>
								    <?php 
								    
								        }else{
								    
								    ?>
								    <span>No Voting Selected</span>
								    <?php }?>

								</td>
								<td class="w-25 px-0 py-2">
										<a data-id="1" data-first_name="Blas" data-surname="Lilang" data-LRN="123" data-access="admin" data-pass="admin" data-bs-toggle="modal" data-bs-target="#edit_user_modal" class="btn btn-sm btn-primary edit" role="button"> Edit </a>
										
										<button type="button" onclick="alert(this)" class="btn btn-sm btn-warning" data-label="reset_vote" data-id="<?php echo $users["id"];?>" data-fullname="<?php echo $users["first_name"]." ".$users["last_name"];?>" data-bs-toggle="modal" data-bs-target="#alert_modal"> Reset Vote </button>
										
										<button type="button" onclick="alert(this)" class="btn btn-sm btn-danger" data-label="remove" data-id="<?php echo $users["id"];?>" data-fullname="<?php echo $users["first_name"]." ".$users["last_name"];?>" data-bs-toggle="modal" data-bs-target="#alert_modal"> Remove </button>
								</td>
							</tr>
								<?php };?>
						</tbody>
					</table>
				</div>
				<!--User-->	
				</div>
				
			</div>
			<div class="col-md-1" style="height: 100px;"></div>
		</div>
	</div>
	<br>
</main>
<!--Main layout-->
<script src="assets/DataTables/jquery.dataTables.min.js"></script>
<script src="assets/DataTables/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
</body>
</html>