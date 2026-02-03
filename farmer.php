   
   
   <?php
session_start();

// agar user login nahi hai to login page par bhej do
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
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
   <?php include('header.php'); ?>
</head>
<body>

<?php
include('db.php');

if(isset($_POST['submit'])) {
    $crop_name = $_POST['crop_name'];
    $quantity  = $_POST['quantity'];
    $price     = $_POST['price'];
    $village   = $_POST['village'];
    $user_id = $_SESSION['user_id'];


// Image upload
    $image_name = $_FILES['crop_image']['name'];
    $image_tmp  = $_FILES['crop_image']['tmp_name'];
    $image_folder = "uploads/" . $image_name;

    // Move uploaded image to server folder
    move_uploaded_file($image_tmp, $image_folder);

    // Insert crop into DB with image filename
    $sql = "INSERT INTO crop (crop_name, quantity, price, village,  image, user_id) 
            VALUES (:crop_name, :quantity, :price, :village, :image,  :user_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':crop_name' => $crop_name,
        ':quantity'  => $quantity,
        ':price'     => $price,
        ':village'   => $village,
        ':image'     => $image_name , 
         ':user_id'   => $user_id
    
    ]);

    // Redirect to crops page after adding
    header("Location: crop.php");
    exit();
}
?>
    
<div class="container m-5 w-50  mx-auto d-block">

    <form class="text-center mx-5" method="post" enctype="multipart/form-data">
      <h2 class="m-3">Add New Crop</h2>
        <div class="mb-3">
            <label>Crop Name</label>
            <input type="text" name="crop_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Quantity (Quintal)</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Price per Quintal</label>
            <input type="number" step="1" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Village</label>
            <input type="text" name="village" class="form-control">
        </div>
        <div class="mb-3">
            <label>image</label>
            <input type="file" name="crop_image" class="form-control" accept="image/*"required>
        </div>
        <button type="submit" name="submit" class="btn btn-success w-100 mx-1">Add Crop</button>
    </form>
</div>


<?php include('footer.php'); ?>
</body>
</html>