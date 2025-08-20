<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
include '../includes/db.php';
include '../includes/header.php';

echo "<h2>Admin Dashboard</h2>";
echo "<p><a href='add_pet.php' class='btn btn-success mb-2'>Add New Pet</a></p>";

// Count total pets
$result = $conn->query("SELECT COUNT(*) as count FROM pets");
$petCount = $result->fetch_assoc()['count'];

echo "<p>Total Pets: $petCount</p>";

include '../includes/footer.php';
