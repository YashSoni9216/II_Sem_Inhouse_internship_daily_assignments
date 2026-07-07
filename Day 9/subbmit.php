<?php

$servername = "localhost";
$username   = "root";      
$password   = "";          
$dbname     = "registration"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("<h3 style='color:red;'>Connection failed: " . $conn->connect_error . "</h3>");
}


$name     = $_POST['name'];
$dob      = $_POST['dob'];
$email    = $_POST['email'];
$phone    = $_POST['phone'];
$password = $_POST['password'];
$confirm  = $_POST['confirm'];
$gender   = $_POST['gender'];
$department = $_POST['department'];
$address  = $_POST['address'];


if ($password !== $confirm) {
    echo "<h3 style='color:red;'>Passwords do not match!</h3>";
    exit;
}


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


$stmt = $conn->prepare("INSERT INTO users (name, dob, email, phone, password, gender, department, address)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $name, $dob, $email, $phone, $hashedPassword, $gender, $department, $address);


if ($stmt->execute()) {
    echo "<h2 style='color:green;'>Registration Successful!</h2>";
    echo "<p>Welcome, <strong>$name</strong>. Your data has been saved.</p>";
} else {
    echo "<h3 style='color:red;'>Error: " . $stmt->error . "</h3>";
}


$stmt->close();
$conn->close();
?>