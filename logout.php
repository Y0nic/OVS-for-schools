<?php

	session_start();
	unset($_SESSION["first_name"]);
	unset($_SESSION["last_name"]);
	unset($_SESSION["access"]);
	
	header("Location: login.php");