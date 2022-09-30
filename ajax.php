<?php

	session_start();
	
	$action = $_POST['action'];

	include_once('functions.php');
	
	if($action == "add_voting"){
		echo add_voting();
	}
	
	if($action == "set_default"){
		echo set_default();
	}
	
	if($action == "remove_voting"){
		echo remove_voting();
	}
	
	if($action == "add_category"){
		echo add_category();
	}
	
	if($action == "add_candidate"){
		echo add_candidate();
	}
	
	if($action == "remove_candidate"){
		echo remove_candidate();
	}
	
	if($action == "remove_category"){
		echo remove_category();
	}
		
	if($action == "edit_candidate"){
		echo edit_candidate();
	}
	
	if($action == "edit_category"){
		echo edit_category();
	}
		
	if($action == "add_user"){
		echo add_user();
	}	
	
	if($action == "remove_user"){
		echo remove_user();
	}
	
	if($action == "reset_vote"){
		echo reset_vote();
	}	
	
	if($action == "vote"){
		echo vote();
	}