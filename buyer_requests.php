<?php
session_start();
include('db.php');

// Buyer login check
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'buyer') {
    header("Location: login.php");
    exit;
}

$buyer_id = $_SESSION['user_id'];

$sql = "SELECT r.*, c.crop_name 
        FROM requests r 
        JOIN crop c ON r.crop_id = c.id 
        WHERE r.buyer_id = :buyer_id
        ORDER BY r.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute([':buyer_id' => $buyer_id]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Buy Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <h3>My Buy Requests</h3>

    <?php if (!empty($requests)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Crop</th>
                    <th>Quantity</th>
                    <th>Message</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['crop_name']); ?></td>
                    <td><?= htmlspecialchars($row['quantity']); ?></td>
                    <td><?= htmlspecialchars($row['message']); ?></td>
                    <td>
    <?php if ($row['status'] == 'pending'): ?>
        <span class="badge bg-warning">Pending</span>

    <?php elseif ($row['status'] == 'accepted'): ?>
        <span class="badge bg-success">Accepted</span><br>
        <small class="text-success">Farmer will contact you soon</small>

    <?php else: ?>
        <span class="badge bg-danger">Rejected</span>
    <?php endif; ?>
</td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No buy requests yet.</p>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
</body>
</html>
