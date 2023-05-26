<?php
$url = "https://anshulparoha.pythonanywhere.com/api/students/";

$data = file_get_contents($url);//this will send request to API get repsonse
$students = json_decode($data);//covert the json response into php array og objects
foreach ($students as $student) {
    echo "Name: " . $student->name . "<br>";
    echo "Email: " . $student->email . "<br>";
    echo "Contact: " . $student->contact . "<br>";
	echo "Address: " . $student->address . "<br><br>";
}
?>
