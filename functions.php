<?php

	require("../../config.php");
	session_start();
	
	$database = "if16_ksenbelo_4";

	//REGISTREERIMINE
	function registration($email, $password, $nickname, $gender) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO grupp_user (email, password, username,gender) VALUE (?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ssss",$email, $password, $nickname, $gender);
		
		if ( $stmt->execute() ) {
			echo "ơnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}	
	}
	
	//LOOGIMINE SISSE
	function login($email,$password) {
		
		$error = "";
		$mysqli = new mysqli($GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		SELECT id, email, password
		FROM grupp_user
		WHERE email = ?
		");
		
		echo $mysqli->error;
		
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		if($stmt->fetch()) {
			$hash = hash("sha512", $password);
		
		if ($hash == $passwordFromDb) {
			echo "Kasutaja $id logis sisse";
			$_SESSION["userId"] = $id;
			$_SESSION["userEmail"] = $emailFromDb;
			header("Location: homepage.php");
		} else {
			$error = "parool vale";
			}	
		} else {
			$error = "Sellise emailiga ".$email." kasutajat ei ole olemas";
		}
		
		return $error;
	}

	//KOMMENTAARID
	function comment($category, $headline, $comment) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO grupp_category (category, pealkiri, comment, email) VALUE (?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ssss",$category, $headline , $comment, $_SESSION["userEmail"]);
		if ( $stmt->execute() ) {
			echo "ơnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}	
	}
	
	//TABEL
	
	function allinfo(){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		SELECT category, pealkiri, comment, created, email
		FROM grupp_category 
		");
		
		$stmt->bind_result($category, $headline , $comment, $created, $email);
		$stmt->execute();
		
		$results = array();
		while ($stmt->fetch()) {
			
			$human = new StdClass();
			$human->category = $category;
			$human->headline = $headline;
			$human->comment = $comment;
			$human->created = $created;
			$human->email = $email;
			
			array_push($results, $human);	
		}
		return $results;
	}
?>