<?php
session_start();
include('db.php'); 
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] === 'guest') {
    header("Location: login.php");
    exit();
}


// Check if user is logged in and is a farmer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'farmer') {
    $_SESSION['error'] = "Please login as Farmer to access this page.";
    header("Location: login.php");
    exit;
}
$farmer_id = $_SESSION['user_id'];   // ✅ YAHI ADD KARO
$user_email = $_SESSION['email'];
$sql = "SELECT r.*, c.crop_name 
        FROM requests r
        JOIN crop c ON r.crop_id = c.id
        WHERE r.farmer_id = :farmer_id
        ORDER BY r.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute([':farmer_id' => $farmer_id]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include('header.php'); ?>

<div class="container mt-5">
    <h2>Welcome, <?= htmlspecialchars($user_email); ?>!</h2>
    <p>This is your Farmer Dashboard.</p>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h5>My Crops</h5>
                <p>View and manage your crops here.</p>
                <a href="crop.php" class="btn btn-success">Go to My Crops</a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3">
                <h5>Add New Crop</h5>
                <p>Upload new crops to sell to buyers.</p>
                <a href="farmer.php" class="btn btn-success">Add Crop</a>
            </div>
        </div>
    </div>

    <!-- 🔥 BUY REQUESTS SECTION START -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card p-3">
                <h5>Buy Requests</h5>

                <?php if (!empty($requests)): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Crop</th>
                                <th>Quantity</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['crop_name']); ?></td>
                                <td><?= htmlspecialchars($row['quantity']); ?></td>
                                <td><?= htmlspecialchars($row['message']); ?></td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        <?= ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'pending'): ?>
                                        <a href="update_request.php?id=<?= $row['id']; ?>&status=accepted" 
                                           class="btn btn-sm btn-success">Accept</a>

                                        <a href="update_request.php?id=<?= $row['id']; ?>&status=rejected" 
                                           class="btn btn-sm btn-danger">Reject</a>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-muted">No buy requests yet.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <!-- 🔥 BUY REQUESTS SECTION END -->
 </div>

<?php include('footer.php'); ?>
</body>
</html>
