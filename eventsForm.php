
<?php
$keys = parse_ini_file('config.ini');
$reCaptchaSiteKey =  $keys["Sitekey"] ;
$reCaptchaSecretkey =   $keys["Secretkey"];


?>



<!DOCTYPE html>


<!--
event_id
event_name
event_description
event_presenter
event_date
event_time
-->
<html lang="en">

	<head>
		<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>WDV341 Unit 6</title>
		<style>
			body{background-color:linen}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
		<script src="https://www.google.com/recaptcha/api.js?render=<?php echo  $reCaptchaSiteKey; ?>"></script>
		<script>
			grecaptcha.ready(function () {
				grecaptcha.execute(<?php echo "'" . $reCaptchaSiteKey . "'" ; ?>, { action: 'contact' }).then(function (token) {
					var recaptchaResponse = document.getElementById('recaptchaResponse');
					recaptchaResponse.value = token;
				});
			});
		</script>

	</head>

	<body>

	
<form id="eventinput_form" name="eventinput" method="post" action="insertEvents.php">
<p>
	<label for="event_name">Event Name</lable>
	<input id="event_name" name="event_name">
</p>
<p>
	<label for="event_description">Event Description</lable>
	<input id="event_description" name="event_description">
</p>
<p>
	<label for="event_presenter">Event Presenter</lable>
	<input id="event_presenter" name="event_presenter">
</p>
<p>
	<label for="event_date">Event Date</lable>
	<input type="date" id="event_date" name="event_date">
</p>
<p>
	<label for="event_time">Event Time</lable>
	<input type="time" id="event_time" name="event_time">
</p>

<input type="hidden" name="recaptcha_response" id="recaptchaResponse">

<input type="submit" name="submit" id="submit" value="Submit">
</form>



	</body>
	
	


</html>


