<?php
session_start();
include("../Includes/db.php");
$num = $_SESSION['phonenumber'];
$check = "SELECT * FROM `buyerregistration` WHERE buyer_phone=$num";
$obj=mysqli_query($con,$check);
$row = mysqli_fetch_assoc($obj);

$check2 = "SELECT * FROM `cart` WHERE phonenumber=$num";
$obj2=mysqli_query($con,$check2);
$row2 = mysqli_fetch_assoc($obj2);

$name = $row["buyer_name"];
$email = $row["buyer_mail"];
$total = $row2["subtotal"];
$plan = $row2["product_id"];
$mobile = $row["buyer_phone"];
$address = $row["buyer_addr"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm to Pay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="pay.css">
</head>

<body>
    <div class="container">
        <div class="parent_main">
            <h2 class="h3 text-center">Click the Pay button for payment!</h2>
            <div>
                <button class="btn btn-success" id="rzp-button1">Pay with Razorpay</button>
            </div>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "rzp_test_9cbPoOvMi8DGkb", // Enter the Key ID generated from the Dashboard
            "amount": "<?php echo $total * 100; ?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
            "currency": "INR",
            "name": "Farmer's Hut",
            "description": "Transaction for <?php echo $plan; ?>",
            "image": "https://example.com/your_logo",
            //"order_id": " //echo(rand(10,100));", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
            "callback_url": "Success.php",
            "prefill": {
                "name": "<?php echo $name; ?>",
                "email": "<?php echo $email; ?>",
                "contact": "<?php echo $mobile; ?>"
            },
            "notes": {
                "address": "<?php echo $address; ?>"
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        
        var rzp1 = new Razorpay(options);
        document.getElementById('rzp-button1').onclick = function(e) {
            rzp1.open();
            e.preventDefault();
        }
    </script>
    <?php
        $clear = "delete from cart where phonenumber = $num";
        $run = mysqli_query($con, $clear);
        // if ($run) {
        //     echo "<script>window.open('Success.php','_self')</script>";
        // }
    ?>
    <script>
        window.onload = function() {
            document.getElementById('rzp-button1').click();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
