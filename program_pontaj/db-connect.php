<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'program_pontaj';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
