


<!DOCTYPE html>
 

   <head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Agriculture</title>
   <?php include('header.php'); ?>
</head>
<body>
<?php include('db.php'); ?>




<?php
  
// FORM SUBMIT CHECK
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $mobile   = $_POST['mobile'];
    $password = $_POST['password'];
    $cpass    = $_POST['cpassword'];
    $usertype = $_POST['usertype'];

    // Password match check
    if ($password !== $cpass) {
        echo "Password not matched ❌";
        exit;
    }

    // Password encrypt
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // INSERT QUERY
    $sql = "INSERT INTO users (fullname, email, mobile, password, usertype)
            VALUES (:fullname, :email, :mobile, :password, :usertype)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':fullname' => $fullname,
        ':email'    => $email,
        ':mobile'   => $mobile,
        ':password' => $hashedPassword,
        ':usertype' => $usertype
    ]);
// Set session variables
$_SESSION['user_id'] = $conn->lastInsertId();
$_SESSION['email']   = $email;
$_SESSION['user_type'] = strtolower($usertype); // convert to lowercase to match header.php

// Redirect based on user type
if(strtolower($usertype) == 'farmer'){
    header("Location: farmer_home.php");
    exit;
} elseif(strtolower($usertype) == 'buyer'){
    header("Location: buyer_home.php");
    exit;
} else {
    // default for other user types (e.g., Trader)
    header("Location: home.php");
    exit;
}

}
?>


<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 col-lg-5 col-sm-10">
    
            <div class="card-body p-4">

                <h3 class="text-center brand-title">Village to Market</h3>
                <p class="text-center text-muted mb-4">
                    Create your account
                </p>

                <form method="post">
                    <!-- Full Name -->
                    <div class="mb-3 text-center">
                        <label class="form-label">Full Name</label>
                       
                        <input type="text" name="fullname" class="form-control"  placeholder="Enter your name" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3 text-center">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                      
                    </div>

                    <!-- Mobile -->
                    <div class="mb-3 text-center">
                        <label class="form-label">Mobile Number</label>
                        <input type="tel" name="mobile" class="form-control" placeholder="Enter mobile number" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3 text-center">
                        <label class="form-label">Password</label>
                        <input type="password"  name="password" class="form-control" placeholder="Create password" required>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3 text-center">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="cpassword" class="form-control" placeholder="Confirm password" required>
                    </div>

                    <!-- User Type -->
                    <div class="mb-3">
                        <label class="form-label d-block text-center">Register As</label>
                        <select class="form-select" name="usertype">
                            <option>Farmer</option>
                            <option>Buyer</option>
                            <option>Guest</option>
                        </select>
                    </div>

                    <!-- Register Button -->
                   

                    <div class="mt-3 text-center ">
                       
                        
                           <button type="submit" class="btn btn-primary mt-3">Register</button>
                            
                        
                    </div>

                    <!-- Login Link -->
                    <div class="text-center mt-3">
                        <span>Already have an account?</span>
                        <a href="login.php" class="text-decoration-none fw-bold">
                            Login
                        </a>
                    </div>

                </form>

            </div>
      
    </div>
</div>





<?php include('footer.php'); ?>
</body>
</html>