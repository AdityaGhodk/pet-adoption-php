<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'pet_adoption');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
define('SITE_NAME', 'PetAdopt India');
define('BASE_URL', '/pet-adoption/');
?>
