<?php


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8'); //data which we'r getting inside request
header('Access-Control-Allow-Methods: POST'); //method type

//reusing classes
include_once('../config/database.php');
include_once('../classes/Employee.php');

$db = new Database();   // Creating an object for the database
$connection = $db->connect();

$employee = new Employee($connection);

if($_SERVER['REQUEST_METHOD'] === 'POST') {

	$data = json_decode(file_get_contents("php://input"));

	if(!empty($data->name) && !empty($data->email) && !empty($data->contact) && !empty($data->address) && !empty($data->password)) {

		$employee->name = ucwords($data->name);
		$employee->email = $data->email;
		$employee->contact = $data->contact;
		$employee->address = ucwords($data->address);
		$employee->password = password_hash($data->password, PASSWORD_DEFAULT); 
		// password_hash() function is used to hash the password before storing it in the Employee object.

		//The PASSWORD_DEFAULT constant tells PHP to use the default bcrypt hashing algorithm, which is a secure and widely recommended option.

		

		if ($employee->create_data()) {
			http_response_code(201);
			echo json_encode(array('status'=> 'success', 'message'=> 'Employee Added Successfully.'));
		}else {
			http_response_code(500);
			echo json_encode(array('status'=> 'error', 'message'=> 'Failed To Add Employee.'));
		}

	}else {
		http_response_code(400);
		echo json_encode(array('status'=> 'error', 'message'=> 'Invalid or Missing Data.'));
	}

}else {
	http_response_code(405);
    echo json_encode(array('status'=> 'error', 'message'=> 'GET method is not allowed.'));
}

?>
