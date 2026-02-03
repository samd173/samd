
<?php
session_start();
?>


<!DOCTYPE html>
   
   <head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Agriculture</title>
  

</head>
<body class="bg-light">

  <?php include('header.php'); ?>

<?php include('db.php'); ?>

<?php


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

   
       if ($user && password_verify($password, $user['password'])) {
    // Set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
   $_SESSION['user_type'] = strtolower($user['usertype']);// IMPORTANT: store user type

   if (strtolower($user['usertype']) == 'farmer') {
    header("Location: farmer_home.php");
    exit;
} elseif (strtolower($user['usertype']) == 'buyer') {
    header("Location: buyer_home.php");
    exit;
} else {
    $_SESSION['error'] = "User type not recognized!";
    header("Location: login.php");
    exit;
}
       }
     else {
       $_SESSION['error'] = "Invalid email or password!";
header("Location: login.php");
exit;

       
    }

}
?>

    <div class="container text-center light-green mt-5 p-5 ">
    <h2>Login to Village to Market</h2>

    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success mt-3 ">
        <?= $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger mt-3">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>


         <form action="" method="post">
                    <!-- Email -->
                    <div class="mb-3 w-50 mx-auto">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email" >
                    </div>

                    <!-- Password -->
                  <div class="mb-3 w-50 mx-auto">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter password" >
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 w-50 form-check mx-auto">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">
                            Remember me
                        </label>
                    </div>

                    <!-- Login Button -->
                    
                     <button type="submit" name="login" class=" mt-3 btn btn-success w-50 mx-2">login</button>
                   

                    <!-- Links -->
                    <div class="text-center mt-3">
                        <a href="#" class="text-decoration-none">Forgot Password?</a>
                    </div>
                    <div class="text-center mt-2">
                        <span>New user?</span>
                        <a href="register.php" class="text-decoration-none fw-bold">Register</a>
                    </div>
                </form>

                

  
</div>
    



<?php include('footer.php'); ?>
</body>
</html>