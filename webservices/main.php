<!--  The entire list of Checkout fields is available at
 https://docs.razorpay.com/docs/checkout-form#checkout-fields -->
 <?php
require 'pay.php';
$orderData = [
    'receipt' => 1235,
    'amount' => 100 * 100, // 2000 rupees in paise
    'currency' => 'INR',
    'payment_capture' => 1, // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR') {
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);
    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$data = [
    "key" => $keyId,
    "amount" => $amount,
    "name" => $userdata["name"],
    "description" => "Tron Legacy",
    "image" => "https://s29.postimg.org/r6dj1g85z/daft_punk.jpg",
    "prefill" => [
        "name" => $userdata["name"],
        "email" => $userdata["email"],
        "contact" => $userdata["contact"],
    ],
    "notes" => [
        "address" => "Hello World",
        "merchant_order_id" => "12312321",
    ],
    "theme" => [
        "color" => "#F37254",
    ],
    "order_id" => $razorpayOrderId,
];

if ($displayCurrency !== 'INR') {
    $data['display_currency'] = $displayCurrency;
    $data['display_amount'] = $displayAmount;
}
$json = json_encode($data);
?>

<button style=" height: 48px;
    width: 220px;
    background-color: navy;
    color: aliceblue;
    font-size: 24px;
    font-family: sans-serif;" id="rzp-button1">Pay with Razorpay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="verify.php" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>
<script>
// Checkout details as a json
var options = <?php echo $json ?>;

/**
 * The entire list of Checkout fields is available at
 * https://docs.razorpay.com/docs/checkout-form#checkout-fields
 */
options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
    document.razorpayform.submit();
};

// Boolean whether to show image inside a white frame. (default: true)
options.theme.image_padding = false;

options.modal = {
    ondismiss: function() {
        console.log("This code runs when the popup is closed");
        <?php header("verify.php");?>
    },
    // Boolean indicating whether pressing escape key
    // should close the checkout form. (default: true)
    escape: true,
    // Boolean indicating whether clicking translucent blank
    // space outside checkout form should close the form. (default: false)
    backdropclose: false
};

var rzp = new Razorpay(options);

document.getElementById('rzp-button1').onclick = function(e){
    rzp.open();
    e.preventDefault();
}
</script>

<form action="verify.php" method="POST">
  <script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?php echo $data['key'] ?>"
    data-amount="<?php echo $data['amount'] ?>"
    data-currency="INR"
    data-name="<?php echo $data['name'] ?>"
    data-image="<?php echo $data['image'] ?>"
    data-description="<?php echo $data['description'] ?>"
    data-prefill.name="<?php echo $data['prefill']['name'] ?>"
    data-prefill.email="<?php echo $data['prefill']['email'] ?>"
    data-prefill.contact="<?php echo $data['prefill']['contact'] ?>"
    data-notes.shopping_order_id="3456"
    data-order_id="<?php echo $data['order_id'] ?>"
    <?php if ($displayCurrency !== 'INR') {?> data-display_amount="<?php echo $data['display_amount'] ?>" <?php }?>
    <?php if ($displayCurrency !== 'INR') {?> data-display_currency="<?php echo $data['display_currency'] ?>" <?php }?>
  >
  </script>
  <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
  <input type="hidden" name="shopping_order_id" value="3456">
</form>