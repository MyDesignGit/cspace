<?php
include './config.php';
require 'razorpay-php/Razorpay.php';
session_start();
use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
