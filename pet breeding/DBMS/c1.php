<?php
// Start the session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Include the database connection
require_once('db.php');

// Query to get the number of registered users
$result = mysqli_query($conn, "SELECT COUNT(*) FROM users");
$num_users = mysqli_fetch_array($result)[0];

// Query to get the number of registered pets
$result = mysqli_query($conn, "SELECT COUNT(*) FROM pets");
$num_pets = mysqli_fetch_array($result)[0];

// Query to get the number of breeding requests
$result = mysqli_query($conn, "SELECT COUNT(*) FROM breeding_requests");
$num_breeding_requests = mysqli_fetch_array($result)[0];

// Query to get the number of clinic reports
$result = mysqli_query($conn, "SELECT COUNT(*) FROM clinic_reports");
$num_clinic_reports = mysqli_fetch_array($result)[0];

// HTML for the admin index page
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pet Breeding Management System - Admin</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['admin']; ?>!</h1>
    <p>Number of registered users: <?php echo $num_users; ?></p>
    <p>Number of registered pets: <?php echo $num_pets; ?></p>
    <p>Number of breeding requests: <?php echo $num_breeding_requests; ?></p>
    <p>Number of clinic reports: <?php echo $num_clinic_reports; ?></p>
    <a href="manage_users.php">Manage Users</a>
    <a href="manage_pets.php">Manage Pets</a>
    <a href="manage_breeding_requests.php">Manage Breeding Requests</a>
    <a href="manage_clinic_reports.php">Manage Clinic Reports</a>
    <a href="logout.php">Logout</a>
</body>
</html>
