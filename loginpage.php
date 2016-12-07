<?php
	
	require("../../config.php");
	require("functions.php");
	
	//MUUTUJAD LOGIN
	$loginEmailError = $loginPasswordError = $loginEmail = "";
	$signupEmailError = $signupEmail = $signupPasswordError = "";
	//MUUTUJAD REGISTER
	$signupEmail = $signupPassword = $signupEmailError = $signupPasswordError = "";
	$usernameError = $username = "";

	//LOOGIMINE SISSE EMAIL
	if (isset ($_POST["loginEmail"])) {
		if (empty ($_POST["loginEmail"])) {
		$loginEmailError = "* V�li on kohustuslik!";
	} else {
		//EMAIL ON KORRAS
		$loginEmail = $_POST ["loginEmail"];
		}
	}
	
	//LOOGIMINE SISSE PAROOL
	if (isset ($_POST["loginPassword"])) {
		if (empty ($_POST["loginPassword"])) {
		$loginPasswordError = "* V�li on kohustuslik!";
		} else {	
	if (strlen ($_POST["loginPassword"]) <6)
		$loginPasswordError = "* Parool peab olema v�hemalt 6 t�hem�rkki pikk!";
		}
	}
	
	// K�IK ON KORRAS
	if(isset($_POST["loginEmail"]) && 
		isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) && 
		!empty($_POST["loginPassword"])
		)
	
	//KASUTAJA REGISTREERIMINE
	//EMAILREGISTREERIMINE
	if (isset ($_POST["signupEmail"])) {
		if (empty ($_POST["signupEmail"])) {
		$signupEmailError = "* V�li on kohustuslik!";
		} else {
		//KUI EMAIL ON KORRAS
		$signupEmail = $_POST["signupEmail"];
		}
	}
	
	//PAROOLI REGISTREERIMINE	
	if (isset ($_POST["signupPassword"])) {
		if (empty ($_POST["signupPassword"])) {
		$signupPasswordError = "* V�li on kohustuslik!";
		} else {	
	}if (strlen ($_POST["signupPassword"]) <6)
		$signupPasswordError = "* Parool peab olema v�hemalt 6 t�hem�rkki pikk!";
	}
	
	//KASUTAJANIMI
	if (isset ($_POST["username"])) {
		if (empty ($_POST["username"])) {
		$usernameError = "* V�li on kohustuslik!";
		} else {
	if (strlen ($_POST["username"]) >18){
		$usernameError = "* Nickname ei tohi olla pikkem kui 18!";
	}
	
	// K�IK ON KORRAS
	if( isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"]) &&
		isset($_POST["username"]) &&
		empty($signupPasswordError)&&
		empty($signupEmailError)&&
		empty($usernameError)
	)
	
	$error = "";

	{
	$error =login($_POST["loginEmail"], $_POST["loginPassword"]);
	$signupPassword = hash("sha512", $_POST["signupPassword"]);
	signup($signupEmail, $signupPassword,$_POST["signupSugu"]);
	}
?>

<!DOCTYPE html>

<html>
		
	<head>
	<title>Sisselogimise leht</title>
	</head>

<div class="container">
<div class="row">

	<body>
	<h1>Logi sisse</h1>
	<form method="POST" >
				
		<label></label><br>
		<?php echo $error; ?><br><br>
		<input name="loginEmail" type = "email" placeholder="E-post" value="<?=$loginEmail;?>">
		<br><font color="red"><?php echo $loginEmailError; ?></font></br>
					
		<input name="loginPassword" type = "password" placeholder="Parool"> 
		<font color="red"><br><?php echo $loginPasswordError;   ?></font></br>
		
		<input type="submit" value="Logi sisse">

	</form>	

	
	<h1>Loo kasutaja</h1>
	
		<label></label><br>	
		<input name="signupEmail" type = "email" placeholder="E-post" value="<?=$signupEmail;?>">
		<br><font color="red"><?php echo $signupEmailError; ?></font></br>
					
		<input name="signupPassword" type = "password" placeholder="Parool"> 
		<br><font color="red"><?php echo $signupPasswordError; ?></font></br>
		
		<p><label for="username">Nickname:</label><br>
		<input name="username" type="text" placeholder="Kasutaja nimi" value=<?=$username;?>> 
		<br><font color="red"><?php echo $usernameError; ?></font>
		
		<p><label for="signupSugu">Sugu:</label><br>
		<select name = "signupSugu"  id="signupSugu" required><br><br>
		<option value="">N�ita</option>
		<option value="Mees">Mees</option>
		<option value="Naine">Naine</option>
		</select><br><br>		
		
		<input type="submit" value="Loo kasutaja">

	</body>
</html>