<?php
session_start();
include_once('tools.php');

if (isset($_POST['id'], $_POST['qty'], $_POST['option'])) {
	$id = htmlentities($_POST['id']);
	$qty = htmlentities($_POST['qty']);
	$oid = htmlentities($_POST['option']);
	if(validate($id, $qty, $oid)){
		$add = $id . $oid;
		$_SESSION['cart'][$add]['id'] = $id;
		$_SESSION['cart'][$add]['oid'] = $oid;
		$_SESSION['cart'][$add]['qty'] = $qty;
	}
}
topModule("GG - Cart");
?>
<div class = "cart">
	<div class = "name"> Cart </div>
<?php
		showCart();
?>

	<form method="post" action="products.php" class="clearbutton">
		<input type="hidden" name="cancel" value="true">
		<button type="submit" class="submit" id = "clear">
			Clear Cart
		</button>
	</form>
	<form method="post" action="checkout.php" class="checkoutbutton">
		<button type="submit" class="submit" id = "check">
			Checkout
		</button>
	</form>
</div>
<?php
endModule();
?>