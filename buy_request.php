<?php
session_start();
include('db.php');


// ✅ Login check (buyer OR farmer allowed)
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] == 'guest') {
    header("Location: login.php");
    exit;
}

$buyer_id = (int)$_SESSION['user_id'];

if (isset($_POST['farmer_id'], $_POST['crop_id'], $_POST['quantity'])) {

    $farmer_id = (int)$_POST['farmer_id'];
    $crop_id   = (int)$_POST['crop_id'];
    $quantity  = (int)$_POST['quantity'];
    $message   = $_POST['message'] ?? '';
    

    // ❌ Safety check: buyer cannot buy own crop
    if ($buyer_id === $farmer_id) {
        header("Location: crop.php?msg=You+cannot+buy+your+own+crop");
        exit;
    }

    // ✅ Insert buy request
    $sql = "INSERT INTO requests 
            (buyer_id, farmer_id, crop_id, quantity, message, status)
            VALUES (:buyer_id, :farmer_id, :crop_id, :quantity, :message, 'pending')";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':buyer_id'  => $buyer_id,
        ':farmer_id' => $farmer_id,
        ':crop_id'   => $crop_id,
        ':quantity'  => $quantity,
        ':message'   => $message
    ]);

    header("Location: crop.php?msg=Buy+Request+Sent");
    exit;
}
?>
