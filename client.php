<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Basic Web Service Using PHP and JSON</title>
	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->

		<style>
			body {
				font-family : "Tahoma";
				font-size   : 12px;
			}

			.form-group {
				margin : 15px 0;
			}

			label {
				display       : inline-block;
				min-width     : 120px;
				max-width     : 100%;
				margin-bottom : 5px;
				font-weight   : 700;
			}


			select {
				display     : inline-block;
				max-width   : 300px;
				font-family : "Tahoma";
				font-size   : 12px;
				padding     : 5px;
			}

		</style>
  	</head>
<body>

	<form method="post" action="<?=$_SERVER['PHP_SELF']?>">	

		<div class="form-group">
			<label>Web Service </label>
			<select name="ws" id="ws">
				<option value="SendJobInfo" <?php if(isset($_POST['ws'])) { if($_POST['ws'] == 'SendJobInfo') { echo 'selected'; }} ?>>Send Job Info</option>
				<option value="ReceiveDriverInfo" <?php if(isset($_POST['ws'])) { if($_POST['ws'] == 'ReceiveDriverInfo') { echo 'selected'; }} ?>>Receive Driver Info</option>
			</select>
		</div>

	  	<input type="submit" name="submit" value="Submit">
	</form>

	<hr />

	<?php

	if(isset($_REQUEST['submit'])) {	

	    function get_response($url,$string) {

	    	$ch = curl_init();  
			$timeout = 0;
			curl_setopt($ch, CURLOPT_URL, $url);  
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');  
			curl_setopt($ch, CURLOPT_POSTFIELDS, $string);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
			'Content-Type: application/json',  
			'Content-Length: ' . strlen($string),)  
			);  
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  
			$result = curl_exec($ch);  
			curl_close($ch);  

			return $result;

	    }

		$WS       = $_REQUEST['ws'];
		$SECURITY = md5("SECRET");

		switch($WS) {

			case 'SendJobInfo':

				echo "<h2>$WS</h2>";

				$string 	=  '{
									"booking_id":"SAMPLE_BOOKING_NO_AXX999",
									"booking_date":"2015-05-20",
									"request_type":"NEW",
									"passenger_name":"NEIL WRANGLER",
									"no_of_passenger":"2",
									"contact_no":"016785465",
									"flight_no":"D7 185",
									"SECURITY":"'.trim($SECURITY).'"
								}';

				$url          = 'http://127.0.0.1/ws.php?method=SendJobInfo';  
				$get_response = get_response($url,$string);
				
				echo "<pre>";
					echo "<b>Request</b> : <br /><br />";
					print_r(json_decode($string));
					echo "<br /><br /><br />";
					echo "<b>Response</b> : <br /><br />";
					print_r(json_decode($get_response));
				echo "</pre>";

			break;


			case 'ReceiveDriverInfo':

				echo "<h2>$WS</h2>";

				$string 	=  '{
									"booking_id":"SAMPLE_BOOKING_NO_AXX999",
									"request_type":"RETRIVE",
									"SECURITY":"'.trim($SECURITY).'"
								}';

				$url          = 'http://127.0.0.1/ws.php?method=ReceiveDriverInfo';  
				$get_response = get_response($url,$string);
				
				echo "<pre>";
					echo "<b>Request</b> : <br /><br />";
					print_r(json_decode($string));
					echo "<br /><br /><br />";
					echo "<b>Response</b> : <br /><br />";
					print_r(json_decode($get_response));
				echo "</pre>";

	
			break;

			default :

				echo '<div class="error">';
					echo "Error. Please contact Administrator.";
				echo '</div>';

			break;

		}
	}

	?>

</body>
</html>
