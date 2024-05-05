<?php
$servername = "localhost";
$username = "root";
$password = "kennyspro";

// Create connection
$conn = new mysqli($servername, $username, $password,"laboratoire");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>