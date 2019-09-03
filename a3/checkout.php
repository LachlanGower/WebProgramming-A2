<?php
session_start();
include_once('tools.php');
topModule("GG - Checkout");
if(!isset($_SESSION['cart'])){
	header("Location: products.php");
}
?>
<div class = "checkout">
	<div class = "name">Checkout</div>
	<form action = "processing.php" target="_blank" method="post">
		<input type="text" class = "checkoutInput"  name="name" pattern="^[-a-zA-Z,' \.]+" placeholder = "Name"/><br>

		<input type="email" class = "checkoutInput"  name="email" placeholder="Email" /><br>
		<textarea class = "checkoutInput"  name="address" pattern = "^[-\w,' \.\n\/]+" placeholder = "Postal Address"></textarea><br>
		<input type="text" class = "checkoutInput"  name="phone" pattern = "^((\+614)|(\(04\))|(04))[ ]?((\d[ ]?){8,})$" placeholder = "Mobile Number"/><br>
		<input type="text" class = "checkoutInput"  name="card" oninput="visaShow()" pattern="^(\d[ ]?){12,19}$" placeholder = "Card Number" />
		<img src="https://strengthsasia.com/wp-content/uploads/2018/01/visa-logo.png" id = "visa"/><br>
		Card Expiry Date <br>(must be over 28 days from date of purchase)<br/>
		<input type="date" class = "checkoutInput"  name="expiry" min="<?php echo getValiDate();?>"/><br>
		<div class = "submitdiv">
			<button class = "submit" type="submit">
				Confirm Purchase
			</button>
		</div>
	</form>
</div>
<?php
endModule();
?>