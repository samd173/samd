<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_type = $_SESSION['user_type'] ?? '';
$user_email = $_SESSION['email'] ?? '';
?>

<header>
<nav class="navbar navbar-expand-lg 
    <?php 
        if($user_type == 'farmer') echo 'navbar-dark bg-success';
        else if($user_type == 'buyer') echo 'navbar-dark bg-success';
        else echo 'navbar-dark bg-dark';
    ?>
">
  <div class="container-fluid">
    <!-- Brand -->
    <a class="navbar-brand" href="
        <?php 
            if($user_type == 'farmer') echo 'farmer_home.php';
            else if($user_type == 'buyer') echo 'buyer_home.php';
            else echo 'home.php';
        ?>
    ">
        🌱 VillageToMarket
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" 
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Common Pages -->
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="service.php">Services</a></li>
      

        <!-- Only show these if user is logged in -->
        <?php if(isset($_SESSION['user_id'])): ?>
         
          <li class="nav-item"><a class="nav-link" href="crop.php">Crops</a></li>
             

          <?php if($user_type == 'farmer'): ?>
            <li class="nav-item"><a class="nav-link" href="farmer.php">Add_crop</a></li>
             <li class="nav-item"><a class="nav-link" href="farmer_home.php">farmer</a></li>
          <?php elseif($user_type == 'buyer'): ?>
            <li class="nav-item"><a class="nav-link" href="buyer_home.php">Dashboard</a></li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>

      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <span class="nav-link text-white">Welcome, <?= htmlspecialchars($user_email); ?></span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
        <?php endif; ?>
      </ul>

    </div>
  </div>
</nav>
</header>
