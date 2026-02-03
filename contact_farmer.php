<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] == 'guest') {
    header("Location: login.php");
    exit;
}
include('db.php'); // Database connection

// Check if form is submitted
if(isset($_POST['farmer_id'], $_POST['crop_id'])) {

    $farmer_id = $_POST['farmer_id'];
    $crop_id   = $_POST['crop_id'];

    // Customer info (yaha session ya form se le sakte ho)
    $customer_name  = $_SESSION['customer_name'] ?? 'Guest';
    $customer_email = $_SESSION['customer_email'] ?? 'guest@example.com';
    
    $message = "Customer is interested in your crop."; // Default message, optional textarea add kar sakte ho

    // Insert into contact_requests table
    $sql = "INSERT INTO contact_requests (farmer_id, crop_id, customer_name, customer_email, message)
            VALUES (:farmer_id, :crop_id, :customer_name, :customer_email, :message)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':farmer_id' => $farmer_id,
        ':crop_id' => $crop_id,
        ':customer_name' => $customer_name,
        ':customer_email' => $customer_email,
        ':message' => $message
    ]);

    // Redirect back to crop page with message
    header("Location: crop.php?msg=Contact+Sent");
    exit();
}
?>
