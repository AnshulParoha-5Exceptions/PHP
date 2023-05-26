<?php
$url = "https://anshulparoha.pythonanywhere.com/api/students/create";
$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$address = $_POST['address'];


$data = array(
        'name' => $name,
        'email' => $email,
        'contact' => $contact,
        'address' => $address
);

$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data) ,
    ),
);
$context = stream_context_create($options);
$response = file_get_contents($url, true, $context);

?>
