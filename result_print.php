<?php
	
	session_start();
	include_once("connect.php");
	
	$id = $_GET["id"];
	
	$voting_qry = mysqli_query($con,"select * from `voting_list` WHERE `id` = '".$id."'") or die(mysqli_error($con));
	$category_qry = mysqli_query($con,"select * from `category` WHERE `voting_id` = '".$id."'") or die(mysqli_error($con));
	
	$voting_list = mysqli_fetch_array($voting_qry);
	
?>

<!doctype html>
<html>
<head>
	<link rel="icon" href="assets/img/logo.png" type="image/x-icon">
	<title>Voting System</title>

<style>
@font-face {
	font-family: myFirstFont;
	src: url(assets/fonts/Tahoma.ttf);
}
body{
	font-family: myFirstFont;
	color: black;
}
.no_margin{
	margin: 0 0 0 0;
}
@media print {
  footer{
    position: fixed;
    bottom: 0;
  }
}
@page  
{ 
    size: A4 portrait;
    margin: 25mm 25mm 25mm 25mm;  
}
</style>
</head>
<body>

	<!-- School Header-->
	<header align="center" style="margin-bottom: 15px;">
		<img src="assets/img/logo.png" width="96px" height="96px" alt="...">
		<p class="no_margin" style="font-size: 12px;">School Document Header</p>
		<p class="no_margin" style="font-size: 12px;">School Document Header</p>
		<p class="no_margin" style="font-size: 12px;">School Document Header</p>
		<p class="no_margin" style="font-size: 12px;">School Document Header</p>
		<p class="no_margin" style="font-size: 12px;"><b>School Document Header</b></p>
		<p class="no_margin" style="font-size: 12px;">School Document Header</p>
	</header>
	
	<span align="center">
		<p class="no_margin" style="font-size: 11px; align:center;"><b>Certificate of Result</b></p>
		<p class="no_margin" style="font-size: 11px; align:center;"><b><?php echo $voting_list["voting_title"];?></b></p>
	</span>
	<p style="font-size: 11px;">&emsp;&emsp;&emsp; I certify that the result of the election of <?php echo $voting_list["voting_title"];?> in (School) held on <?php echo $voting_list["date"];?> at (Location) were as follows:</p>
	
	<table style="width: 90%;" align="center">
		
		<?php $i = 0; while($category = mysqli_fetch_array($category_qry)){?>
		<thead>
			
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr>
				<th style="width: 50%; text-align: left; font-size: 11px;"><?php echo $category["category"];?> Candidates</th>
				<th style="width: 20%; font-size: 11px;">
				
				<?php
				
					if($i == 0){
						
						echo "Votes";
						
					}else{
						
						echo "";
						
					}
				
				?>
				
				</th>
				<th style="width: 80%; font-size: 11px;"></th>
			</tr>
		</thead>
		<tbody>
		
			<?php 
				
				$elected_candidate_qry = mysqli_query($con,"select max(votes) from `candidate` WHERE `voting_id` = '".$id."' && `category_id` = '".$category["id"]."'") or die(mysqli_error($con));
				$elected_candidate = mysqli_fetch_array($elected_candidate_qry);
				
				$candidate_qry = mysqli_query($con,"select * from `candidate` WHERE `voting_id` = '".$id."' && `category_id` = '".$category["id"]."' order by `last_name` desc") or die(mysqli_error($con));
				while($candidate = mysqli_fetch_array($candidate_qry)){
			?>
			<tr>
			
				<td style="font-size: 11px;">&emsp;&emsp;&emsp;<?php echo $candidate["last_name"].", ".$candidate["first_name"];?></td>
				<td style="font-size: 11px; text-align: center;"><?php echo $candidate["votes"];?></td>
				<td style="font-size: 11px;">
				
				<?php 
				
					if($candidate["votes"] == $elected_candidate[0]){
						
						echo "Elected";
						
					}else{
						
						echo "";
						
					}
				
				?>
				
				</td>
			
			</tr>
			<?php };?>
				
		</tbody>
		<?php $i = 1;};?>
		
	</table>

	<br>
	<br>

	<p class="no_margin" style="font-size: 11px;">____________________</p>
	<p class="no_margin" style="font-size: 11px;">Head of Schoo Name</p>
	<p class="no_margin" style="font-size: 11px;">Position</p>
	
	//Document Footer
	<footer>
		<hr>
		<img src="assets/img/logo.png" width="72px" height="72px" alt="..." style="position:absolute;">
		<p class="no_margin" style="font-size: 12px; margin-left: 80px; margin-top: 15px;"><b>School:</b> </p>
		<p class="no_margin" style="font-size: 12px; margin-left: 80px;"><b>Address:</b> </p>
		<p class="no_margin" style="font-size: 12px; margin-left: 80px;"><b>Telephone No.:</b></p>
		<p class="no_margin" style="font-size: 12px; margin-left: 80px; margin-bottom: 9px;"><b>Email:</b> </p>
	</footer>
	
</body>
</html>
