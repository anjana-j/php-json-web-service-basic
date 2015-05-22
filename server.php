<?php

function SendJobInfo($content) {

	$json_decode 		  = json_decode($content);

	class reply_json_string {
		public $booking_id;
		public $request_type;
		public $last_update_time;
		public $status;
		public $SECURITY;
	}

	$new_json_string = new reply_json_string();
	$new_json_string->booking_id        = $json_decode->booking_id;
	$new_json_string->request_type      = 'NEW';
	$new_json_string->last_update_time  = '2015-05-20 10:10:00';
	$new_json_string->status            = 'SUCCESS';
	$new_json_string->SECURITY          = $json_decode->SECURITY;

	echo json_encode($new_json_string);

}


function ReceiveDriverInfo($content) {

	$json_decode 		  = json_decode($content);

	class reply_json_string {
		public $booking_id;
		public $request_type;
		public $car_reg_no;
		public $driver_name;
		public $driver_contact_no;
		public $last_update_time;
		public $status;
		public $coordinate;
	}

	$new_json_string = new reply_json_string();
	$new_json_string->booking_id        = $json_decode->booking_id;
	$new_json_string->request_type      = '1';
	$new_json_string->car_reg_no        = 'WYX6547';
	$new_json_string->driver_name       = 'JOHN_SMITH';
	$new_json_string->driver_contact_no = '01234567890';
	$new_json_string->last_update_time  = '2015-05-20 10:10:00';
	$new_json_string->status            = 'NEW';
	$new_json_string->coordinate        = '3.125475,79.345251';
	$new_json_string->SECURITY          = $json_decode->SECURITY;

	echo json_encode($new_json_string);

}


if(isset($_REQUEST['method'])) {

	$method  = $_REQUEST['method'];
	$content = file_get_contents("php://input"); 

	if($method == 'SendJobInfo') {
		SendJobInfo($content);
	} else if($method == 'ReceiveDriverInfo') {
		ReceiveDriverInfo($content);
	}

} else {

	echo "Error";

}



?>