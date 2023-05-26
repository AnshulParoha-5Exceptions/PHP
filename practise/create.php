<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers,Authorization,S-Request-With');

// Read the raw data from the request body and decode the JSON data into PHP objects
$data = json_decode(file_get_contents("php://input"));

include 'db_connection.php';

//Check if any of the required fields are empty
if (empty($data->name) || empty($data->email) || empty($data->contact) || empty($data->address)) {
    $response = ['status' => 'failed', 'msg' => 'All fields are required'];
} else {
    // Build the SQL query string with placeholders
    $query = "INSERT INTO users (name, email, contact, address) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    // Bind the parameters to the placeholders
    mysqli_stmt_bind_param($stmt, 'ssss', $data->name, $data->email, $data->contact, $data->address);

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $response = ['status' => 'success', 'msg' => 'User added successfully'];
    } else {
        $response = ['status' => 'failed', 'msg' => 'Failed to add user'];
    }
}

// Return the response as a JSON object
echo json_encode($response);

?>