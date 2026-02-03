<?php
session_start();

// Check if user is logged in and is a buyer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'buyer') {
    $_SESSION['error'] = "Please login as Buyer to access this page.";
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include('header.php'); ?>

<div class="container mt-5">
    <h2>Welcome, <?= htmlspecialchars($user_email); ?>!</h2>
    <p>This is your Buyer Dashboard.</p>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Browse Crops</h5>
                <p>View available crops from farmers.</p>
                <a href="crop.php" class="btn btn-success">Go to Crops</a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3">
                <h5>My Orders</h5>
                <p>Check your purchased crops and order history.</p>
               <a href="buyer_requests.php" class="btn btn-success">View Orders</a>

            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
