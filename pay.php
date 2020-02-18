<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title></title>
  </head>
  <body>
  <div class="container">
<div class="row">
<div class="col-sm-12">
<h2>Example: Razorpay Payment Gateway Integration in PHP</h2>
<br><br>
<div class="col-sm-4 col-lg-4 col-md-4">
<div class="thumbnail">
<img src="prod.gif" alt="">
<div class="caption">
<h4 class="pull-right">₹49.99</h4>
<h4><a href="#">My Test Product"</a></h4>
<p>See more examples like this at <a target="_blank" href="https://www.phpzag.com/">phpzag</a>.</p>
</div>
<form id="checkout-selection" action="pay.php" method="POST">
<input type="hidden" name="item_name" value="My Test Product">
<input type="hidden" name="item_description" value="My Test Product Description">
<input type="hidden" name="item_number" value="3456">
<input type="hidden" name="amount" value="49.99">
<input type="hidden" name="address" value="ABCD Address">
<input type="hidden" name="currency" value="INR">
<input type="hidden" name="cust_name" value="phpzag">
<input type="hidden" name="email" value="test@phpzag.com">
<input type="hidden" name="contact" value="9999999999">
<input type="submit" class="btn btn-primary" value="Buy Now">
</form>
</div>
</div>
</div>
</div>
</div>
<?php
require('config.php');
require('razorpay-php/Razorpay.php');
session_start();
use Razorpay\Api\Api;
$api = new Api($keyId, $keySecret);
$orderData = [
'receipt' => 3456,
'amount' => $_POST['amount'] * 100,
'currency' => $_POST['currency'],
'payment_capture' => 1
];
$razorpayOrder = $api->order->create($orderData);
$razorpayOrderId = $razorpayOrder['id'];
$_SESSION['razorpay_order_id'] = $razorpayOrderId;
$displayAmount = $amount = $orderData['amount'];
?>
<?php
$data = [
"key" => $keyId,
"amount" => $amount,
"name" => $_POST['item_name'],
"description" => $_POST['item_description'],
"image" => "",
"prefill" => [
"name" => $_POST['cust_name'],
"email" => $_POST['email'],
"contact" => $_POST['contact'],
],
"notes" => [
"address" => $_POST['address'],
"merchant_order_id" => "12312321",
],
"theme" => [
"color" => "#F37254"
],
"order_id" => $razorpayOrderId,
];
?>
<button id="rzp-button1" class="btn btn-primary">Pay with Razorpay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="verify.php" method="POST">
<input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
<input type="hidden" name="razorpay_signature" id="razorpay_signature" >
</form>
<script>
var options = <?php echo $json?>;
options.handler = function (response){
document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
document.getElementById('razorpay_signature').value = response.razorpay_signature;
document.razorpayform.submit();
};
options.theme.image_padding = false;
options.modal = {
ondismiss: function() {
console.log("This code runs when the popup is closed");
},
escape: true,
backdropclose: false
};
var rzp = new Razorpay(options);
document.getElementById('rzp-button1').onclick = function(e){
rzp.open();
e.preventDefault();
}
</script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
 
</body>
</html>