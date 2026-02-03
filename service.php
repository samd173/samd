


<!DOCTYPE html>
 
   <head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   
    <link rel="stylesheet" href="home.css">
    <title>Agriculture</title>

</head>
<body>

     <?php include('header.php'); ?>

<section class="container bg-light text-center mt-5">
  

<?php
$services = [
    [
        "title" => "Crop Listing",
        "img" => "\myweb\croplist.jpg",
     
        "details" => "Farmers can add crops with name, quantity, price, and photos Mention availability date Organic / non-organic option."
    ],
    [
        "title" => "Live Market Prices",
        "img" => "\myweb\live.jpg",
    
        "details" => "Live Market Prices Real-time mandi/market rates Price comparison Best time to sell suggestions."
    ],

    [
        "title" => "Transport & Logistics Suppor",
        "img" => "\myweb\sttp.jpg",
    
        "details" => "Vehicle booking (truck, tempo) Nearest warehouse information Transport cost estimation."
    ],
  
    [
        "title" => "Weather & Crop Advisory",
        "img" => "\myweb\weather.jpg",
     
        "details" => "Weather forecasts Farming tips Pest and disease alerts."
    ],
    [
        "title" => "Direct Buyer Connection",
        "img" => "\myweb\direct.jpg",
       
        "details" => "Farmers can connect directly with buyers Chat or call feature Verified buyer profiles."
    ],
    [
        "title" => "Secure Payments",
        "img" => "\myweb\secure.jpg",
     
        "details" => "Online payments (UPI / Bank transfer) Payment history and invoices Fast and safe settlement."
    ],
    
];
?>
<div class="container py-5">
     
    <h2 class="text-center mb-4 ">Our Services</h2>

    <div class="row">

        <?php foreach ($services as $key => $service) { ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 w-50 shadow mx-auto d-block">

                    <!-- Service Image -->
                    <img src="<?= $service['img']; ?>"
                         class="card-img-top w-100"
                         style="cursor:pointer"
                         data-bs-toggle="modal"
                         data-bs-target="#serviceModal<?= $key; ?>">

                    <div class="card-body text-center">
                        <h5 class="card-title"><?= $service['title']; ?></h5>
                       
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade " id="serviceModal<?= $key; ?>" tabindex="-1">
                <div class="modal-dialog modal-md modal-dialog-centered ">
                    <div class="modal-content ">

                        <div class="modal-header">
                            <h5 class="modal-title"><?= $service['title']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body text-center">
                            <img src="<?= $service['img']; ?>" class="img-fluid mb-3">
                            <p><?= $service['details']; ?></p>
                        </div>

                    </div>
                </div>
            </div>

        <?php } ?>

    </div>
</div>

</section>

<?php include('footer.php'); ?>
</body>
</html>