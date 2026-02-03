

<?php
session_start();
include('db.php');

// Farmer login check
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$farmer_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Farmer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('db.php'); ?>
<div class="container py-4">
    <h2 class="mb-4">Farmer Dashboard</h2>

    <!-- Contact Customers -->
    <h4>Contact Customers</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($contactQuery)) { ?>
                <tr>
                    <td><?= $row['customer_name']; ?></td>
                    <td><?= $row['customer_email']; ?></td>
                    <td><?= $row['message']; ?></td>
                    <td><?= $row['created_at']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Buy Request History -->
    <h4 class="mt-5">Buy Request History</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($buyQuery)) { ?>
                <tr>
                    <td><?= $row['product_name']; ?></td>
                    <td><?= $row['quantity']; ?></td>
                    <td><?= $row['price']; ?></td>
                    <td>
                        <span class="badge bg-info"><?= $row['status']; ?></span>
                    </td>
                    <td><?= $row['created_at']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>
