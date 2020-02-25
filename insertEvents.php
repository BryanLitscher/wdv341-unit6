<?php
	//This PHP file will connect to the wdv341 database
	//It will pull the form data from the $_POST variable
	//It will format an INSERT SQL statement
	//It will create a Prepared Statement 
	//It will bind the parameters to the Prepared Statement
	//It will execute the prepared statement to insert into the database
	//It will display a success/failure message to the user.


require 'dbConnect.php';	//access and run this external file

$keys = parse_ini_file('config.ini');
$reCaptchaSiteKey =  $keys["Sitekey"] ;
$reCaptchaSecretkey =   $keys["Secretkey"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
	// Build POST request:
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = $reCaptchaSecretkey;
    $recaptcha_response = $_POST['recaptcha_response'];
    // Make and decode POST request:
    $recaptchaJSON = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptchaJSON);
}



try {

$eventName=$_POST["event_name"];
$eventDescription=$_POST["event_description"];
$eventPresenter=$_POST["event_presenter"];
$eventDate=$_POST["event_date"];
$eventTime=$_POST["event_time"];


	//PDO Prepared statements 

	//1. create the SQL statement with name placeholders

	
	$sql = "INSERT INTO wdv341_event (
			event_name, 
			event_description,
			event_presenter,
			event_date,
			event_time
			)
		VALUES (
			:eventName, 
			:eventDescription, 
			:eventPresenter,
			:eventDate,
			:eventTime
			)";
			

	//2. Create the prepared statement object
	$stmt = $conn->prepare($sql);	//creates the 'prepared statement' object

	//Bind parameters to the prepared statement object, one for each parameter
	$stmt->bindParam(':eventName', $eventName);
	$stmt->bindParam(':eventDescription', $eventDescription);
	$stmt->bindParam(':eventPresenter', $eventPresenter);
	$stmt->bindParam(':eventDate', $eventDate);
	$stmt->bindParam(':eventTime', $eventTime);

	//Execute the prepared statement
	$stmt->execute();
?>

	<!doctype html>
	<html>
	<head>
	<meta charset="utf-8">
	<title>Untitled Document</title>
	</head>

	<body>
		<h2>Thank you for your order!</h2>
		
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
	echo "<h3>Results of submisstion</h3>" . "\n" ;
	echo "<h4>Submitted Data</h4> ". "\n" ;
	foreach($_POST as $x => $x_value) {
		if($x != "recaptcha_response"){
			echo $x . " = " . $x_value  ;
			echo "<br>" . "\n";
		}
	}
	echo "<h4>Recaptcha</h4> ". "\n" ;
	foreach($recaptcha as $x => $x_value) {
		echo $x . " = " . $x_value  ;
		echo "<br>" . "\n";
	}
}
?>
	</body>
	</html>
<?php

	}
catch(PDOException $e){
	echo "PDO Exception!";
}
$conn = null;	//close your connection object

?>

