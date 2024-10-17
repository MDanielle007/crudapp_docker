<?php
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();
if ($conn) {
    echo "Database connection successful!";
} else {
    echo "Database connection failed!";
}