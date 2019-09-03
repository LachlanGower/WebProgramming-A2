<?php
session_start();
include_once('tools.php');
if (isset($_POST['name'], $_POST['email'], $_POST['address'], $_POST['phone'], $_POST['card'], $_POST['expiry'])) {
	if (isset($_SESSION['orders'])) {
		unset($_SESSION['orders']);
	}
	$name = htmlentities($_POST['name']);
	$email = htmlentities($_POST['email']);
	$address = htmlentities($_POST['address']);
	$phone = htmlentities($_POST['phone']);
	$card = htmlentities($_POST['card']);
	$date = htmlentities($_POST['expiry']);
	$pname = preg_match("/^[-a-zA-Z,' \.]+/", $name);
	$pemail = filter_var($email, FILTER_VALIDATE_EMAIL);
	$paddress = preg_match("/^[-\w,' \.\n\/]+/", $address);
	$pphone = preg_match("/^((\+614)|(\(04\))|(04))[ ]?((\d[ ]?){8,})$/", $phone);
	$pcard = preg_match("/^(\d[ ]?){12,19}$/", $card);
	$pdate = getValiDate();
	($date < $pdate) ? $pdate = false : $pdate = true;
	if($pname && $pemail && $paddress && $pphone && $pcard && $pdate && isset($_SESSION['cart']))
	{
		$fp = fopen("orders.txt","a");
		flock($fp, LOCK_EX);
		$subtotal = 0;

		foreach($_SESSION['cart'] as $product){
			$price = getSpecificProduct($product['id'],$product['oid'])['Price'];
			$subtotal = $price * $product['qty'];
			$order = array($date, $name, $email, $phone, $address, $product['id'],$product['oid'],$product['qty'], $price, $subtotal);
			$_SESSION['orders'][] = $order;
			fputcsv($fp, $order, "\t");
		}
		flock($fp, LOCK_UN);
		fclose($fp);
		unset($_SESSION['cart']);
		header("Location: receipt.php");
	}
	elseif(!isset($_SESSION['cart'])){
		header("Location: cart.php");
	}	
	else
	{
		header("Location: checkout.php");
	}
}
?>