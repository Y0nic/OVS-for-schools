
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title>Voting System</title>
	<link rel="icon" href="assets/img/logo.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/fontawesome/css/all.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="assets/jquery/JQuery.js"></script>
	<script type="text/javascript" src="script.js?ts=<?=time()?>"></script>
	<script type="text/javascript" src="voting_management_script.js?ts=<?=time()?>"></script>
</head>
<body>	

<input type="file" class="form-control profile">

<p>ss</p>

<button class="btn btn-primary">click</button>

<script>

$(document).ready(function(){
	
	$("button").click(function(){
	
		var file = $("input").val();
		$("p").text(file);
	
	});
	
});

</script>
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
</body>
</html>