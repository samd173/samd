<?php
session_start();

// ✅ Logged-in check: anyone with user_id is considered logged-in (farmer or buyer)
$user_id = $_SESSION['user_id'] ?? null;   
$user_type = $_SESSION['user_type'] ?? '';
$isLoggedIn = !empty($user_id) && $user_type !== 'guest';
 // true if someone is logged in

include('db.php');

/* crops name fetch (for dropdown) */
$cropStmt = $conn->query("SELECT DISTINCT crop_name FROM crop ORDER BY crop_name");
$cropNames = $cropStmt->fetchAll(PDO::FETCH_ASSOC);

/* villages fetch */
$villageStmt = $conn->query("SELECT DISTINCT village FROM crop ORDER BY village");
$villages = $villageStmt->fetchAll(PDO::FETCH_ASSOC);

/* crops search + filter */
$where = [];
$params = [];

if (!empty($_GET['crop'])) {
    $where[] = "crop_name LIKE :crop";
    $params[':crop'] = '%' . $_GET['crop'] . '%';
}

if (!empty($_GET['village'])) {
    $where[] = "village = :village";
    $params[':village'] = $_GET['village'];
}

$sql = "SELECT * FROM crop";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY id DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$crops = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="home.css">
<title>Agriculture</title>
<?php include('header.php'); ?>
</head>
<body>

<div class="container my-4">
  <h2 class="text-center mb-4">Available Crops</h2>

<?php if(isset($_GET['msg'])): ?>
<div class="alert alert-success text-center"><?= htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>

<form method="GET">
  <div class="row g-3 d-flex">
    <div class="col-md-4">
      <select name="crop" class="form-select" onchange="this.form.submit()">
        <option value="">Select Crop</option>
        <?php foreach($cropNames as $c): ?>
          <option value="<?= htmlspecialchars($c['crop_name']); ?>"
            <?= (($_GET['crop'] ?? '') == $c['crop_name']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['crop_name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <select name="village" class="form-select" onchange="this.form.submit()">
        <option value="">Select Village</option>
        <?php foreach($villages as $v): ?>
          <option value="<?= htmlspecialchars($v['village']); ?>"
            <?= (($_GET['village'] ?? '') == $v['village']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($v['village']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <button type="submit" class="btn btn-success w-100">Search</button>
    </div>
  </div>
</form>

<div class="container my-4">
  <div class="row">
    <?php if(count($crops) > 0): ?>
      <?php foreach($crops as $crop): ?>
        <?php
        $isOwner = ((int)$crop['user_id'] === (int)$user_id);  // crop owner check
        $canBuy  = $isLoggedIn && !$isOwner;                   // logged-in & not owner
        ?>
        <div class="col-md-4 mb-4">
          <div class="text-center shadow p-3 rounded">
            <img src="<?= htmlspecialchars($crop['image']); ?>" 
                 class="border rounded-4 crop-img" 
                 alt="<?= htmlspecialchars($crop['crop_name']); ?>">

            <h5 class="mt-3"><?= htmlspecialchars($crop['crop_name']); ?></h5>
            <p class="mb-1 small">
              Quantity: <?= $crop['quantity']; ?> Quintal <br>
              Price: ₹<?= $crop['price']; ?> / Quintal <br>
              Village: <?= htmlspecialchars($crop['village']); ?>
            </p>

           <?php if(!$isLoggedIn): ?>
    <button type="button"
        class="btn btn-primary btn-sm mx-2 mt-3"
        onclick="window.location.href='login.php'">
        Contact Farmer
    </button>
<?php else: ?>
    <form action="contact_farmer.php" method="post" class="d-inline">
        <input type="hidden" name="farmer_id" value="<?= $crop['user_id']; ?>">
        <input type="hidden" name="crop_id" value="<?= $crop['id']; ?>">
        <button type="submit" class="btn btn-primary btn-sm mx-2 mt-3">
            Contact Farmer
        </button>
    </form>
<?php endif; ?>




            <!-- Buy Modal -->
            <?php if($canBuy): ?>
              <div class="modal fade" id="buyModal<?= $crop['id']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="buy_request.php" method="post">
                      <div class="modal-header">
                        <h5 class="modal-title">Buy <?= htmlspecialchars($crop['crop_name']); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="farmer_id" value="<?= $crop['user_id']; ?>">
                        <input type="hidden" name="crop_id" value="<?= $crop['id']; ?>">
                        <div class="mb-3">
                          <label for="quantity<?= $crop['id']; ?>" class="form-label">Quantity (Quintal)</label>
                          <input type="number" class="form-control" id="quantity<?= $crop['id']; ?>" 
                                 name="quantity" required min="1" placeholder="Enter quantity">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-success w-100">Confirm Buy</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <!-- Buy Button -->
            <?php if(!$isLoggedIn): ?>
    <!-- Guest -->
    <button type="button"
        class="btn btn-success btn-sm mb-2 mt-4 mx-2"
        onclick="window.location.href='login.php'">
        Buy Request
    </button>

<?php elseif($isOwner): ?>
    <!-- Owner -->
    <button class="btn btn-secondary btn-sm mb-2 mt-4 mx-2" disabled>
        Your Crop
    </button>

<?php else: ?>
    <!-- Logged-in & not owner -->
    <button type="button"
        class="btn btn-success btn-sm mb-2 mt-4 mx-2"
        data-bs-toggle="modal"
        data-bs-target="#buyModal<?= $crop['id']; ?>">
        Buy Request
    </button>
<?php endif; ?>


            <?php if(!$isLoggedIn): ?>
              <small class="text-danger d-block mt-2">Login to contact farmer or buy</small>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-danger">No crops available</p>
    <?php endif; ?>
  </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
