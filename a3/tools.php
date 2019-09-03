<?php
function getProducts()
{
	$fp = fopen("products.txt","r");
	flock($fp, LOCK_SH);
	$headings = fgetcsv($fp,0,"\t");
	while ($line = fgetcsv($fp, 0, "\t")) 
	{
		for($x=1; $x<count($line); $x++)
		{
			$products[$line[0]][$headings[$x]] = $line[$x];
		}
	}
	flock($fp, LOCK_UN);
	fclose($fp);
	return $products;
}
function getProduct($id)
{
	$fp = fopen("products.txt","r");
	flock($fp, LOCK_SH);
	$headings = fgetcsv($fp,0,"\t");
	$item = 0;
	while ($line = fgetcsv($fp, 0, "\t")) 
	{
		if($line[0] == $id)
		{
			for($x=0; $x<count($line); $x++)
			{
				$product[$item][$headings[$x]] = $line[$x];
			}
			$item += 1;
		}
	}
	flock($fp, LOCK_UN);
	fclose($fp);
	return $product;
}
function getSpecificProduct($id, $oid)
{
	$fp = fopen("products.txt","r");
	flock($fp, LOCK_SH);
	$headings = fgetcsv($fp,0,"\t");
	while ($line = fgetcsv($fp, 0, "\t")) 
	{
		if($line[0] == $id && $line[1] == $oid)
		{
			for($x=0; $x<count($line); $x++)
			{
				$product[$headings[$x]] = $line[$x];
			}
		}
	}
	flock($fp, LOCK_UN);
	fclose($fp);
	return $product;
}

function this_actually_exists($id, $heading)
{
	$fp = fopen("products.txt","r");
	flock($fp, LOCK_SH);
	$notids = fgetcsv($fp,0,"\t");
	while ($line = fgetcsv($fp, 0, "\t")) 
	{
		if($line[$heading] == $id)
		{
			flock($fp, LOCK_UN);
			fclose($fp);
			return true;
		}
	}
	flock($fp, LOCK_UN);
	fclose($fp);
	return false;
}
function validate($id, $qty, $oid)
{
	if($qty > 0)
	{
		if(this_actually_exists($id, 0) && this_actually_exists($oid, 1))
			return true;
	}
	return false;
}
function getValiDate()
{
	$date = date("Y-m-d", mktime(0,0,0, date("m"), date("d")+28 , date("Y")));
	return $date;
}

/* MODULES
 *
 *
 *
 */
function showCart()
{
	if(isset($_SESSION['cart']))
	{
		foreach($_SESSION['cart'] as $values)
		{
			$product = getSpecificProduct($values['id'], $values['oid']);
			$title = $product['Title'];
			$price = $product['Price'];
			$qty = $values['qty'];
			if($qty > 1)
			{
				$option = $product['Option'] . "s";
			}else{
				$option = $product['Option'];
			}
			$price = number_format((float)($price * $qty), 2, '.', '');
			$meta=<<<"YOLO"
				<section class = "cart_item">
					<div class = "cart_qty">
						$qty
					</div>
					<div class = "cart_desc">
						$title $option
					</div>
					<div class = "cart_price">
						\$$price
					</div>
				</section>
YOLO;
		echo $meta;
		}
	}
	else{
		echo "<section class = 'cart_item'>
					<div class = 'cart_desc'>
						Cart is Empty
					</div>
				</section>";
	}
}
function showProduct($id)
{
	$product = getProduct($id);
	$title = $product[0]['Title'];
	$id = $product[0]['ID'];
	$description = $product[0]['Description'];
	$price = $product[0]['Price'];
	$meta=<<<"YOLO"
	<article class = "product">
		<section class = "name">
			$title
		</section>
		<section class = "form">
			<form action = "cart.php" method="post" onsubmit = "return validation()">
				<input type="hidden" name="id" value="$id"/>
				
				<div class = "flexcol">
					<div class = "image">
						pretend i am image
					</div>
					<div class = "description">
						$description
					</div>
				</div>
				<div class = "flexcol">
					<div class = "quantitycontainer">
						Type:&nbsp;
						<select class = "type" name="option" size="1" onchange = "changePrice()">
YOLO;
	$quantity=<<<"FUN"
						</select>
						<br/>
						<br>
						Quantity: 
						<div id = "quantity_box">
							<div class = "add" onclick="quantity(-1)">-</div>

							<input type="text" class = "quantity"  name="qty" pattern="^[0-9]+" value="1" />

							<div class = "add" onclick="quantity(1)">+</div>
						</div>
						<div class = "product_price">
							\$$price
						</div>
						<div class = "submitdiv">
							<input class = "submit" type="submit" value="Add To Cart"/>
						</div>
					</div>

				</div>
			</form>
		</section>
	</article>
FUN;
	echo $meta;
	foreach($product as $option)
	{
		$oid = $option['OID'];
		$price = $option['Price'];
		$option = $option["Option"];
		
		echo "<option value='$oid' data-price='$price'>$option</option>";
	}
	echo $quantity;
}

function createItems($type)
{
	$products = getProducts();
	foreach($products as $id => $product)
	{
		if($product['Type'] == $type)
		{
			$title = $product['Title'];
			$meta=<<<"Thumb"
				<a href= "products.php?id=$id" class = "thumbnail">
					<div class = "thumg">image</div>
					<span>$title</span>
				</a>
Thumb;
			echo $meta;
		}
	}
}
function showDetails()
{
	foreach($_SESSION['orders'] as $order){
		$product = getSpecificProduct($order[5],$order[6]);
		$productTitle = $product['Title'];
		$productOption = $product['Option'];
		$qty = $order[7];
		$price = $order[8];
		echo "$qty $productOption of $productTitle at $$price each<br><br>";
	}
}
function showSubtotals()
{
	foreach($_SESSION['orders'] as $order){
		$subtotal = $order[8] * $order[7];
		$subtotal = number_format($subtotal, 2, '.', '');
		echo "\$$subtotal<br><br>";
	}
}
function showTotal()
{
	$total = 0;
	foreach($_SESSION['orders'] as $order){
		$total += $order[9];
	}
	$total = number_format($total, 2, '.', '');
	echo "$$total";
}
function showPostal()
{
	$name = $_SESSION['orders'][0][1];
	$email = $_SESSION['orders'][0][2];
	$mobile = $_SESSION['orders'][0][3];
	$address = $_SESSION['orders'][0][4];
	echo "Sending to $name at $address<br><br> Contact details:<br> $mobile : $email";
}


function topModule($title) {
	$css = styleCurrentNavLink('background-color: white; color: indianred;');
	$meta=<<<"YOLO"
		<!DOCTYPE html>
		<html lang='en'>
		<head>
		<meta charset="utf-8">
		<title>$title</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Keep wireframe.css for debugging, add your css to style.css -->
			<link id='wireframecss' type="text/css" rel="stylesheet" href="../wireframe.css" disabled>
			<link id='stylecss' type="text/css" rel="stylesheet" href="css/style.css">
			<script src='../wireframe.js'></script>
			$css
			</head>

			<body>
			<nav>
			<div>
			<a href = "products.php">
			Browse our Products
			</a>
			</div>
			<div>
			<a href="index.php">
			<header>
			The Gatherer's Garden<!--'-->
					</header>
					<span>Genetic &nbsp;Modifications</span>
				</a>
			</div>
			<div>
				<a href = "cart.php">
					Go to Cart
				</a>
			</div>
		</nav>

		<main id = "center">
YOLO;
    echo $meta;
}

function endModule() {
$yes=<<<"TEST"
	</main>

		<footer id = "south">
			<div>&copy;<script>
				document.write(new Date().getFullYear());
				</script> Lachlan Gower (s3723825)</div>
			<div>Disclaimer: This website is not a real website and is being developed as part of a School of Science Web Programming course at RMIT University in Melbourne, Australia.</div>
			<script src = 'js/main.js'></script>
			<div>Maintain links to your <a href='products.txt'>products spreadsheet</a> and <a href='orders.txt'>orders spreadsheet</a> here. <button id='toggleWireframeCSS' onclick='toggleWireframe()'>Toggle Wireframe CSS</button></div>
		</footer>
	</body>
</html>
TEST;
    echo $yes;
	preShow($_POST);
	preShow($_SESSION);
	printMyCode();
	

}
function preShow( $arr, $returnAsString=false ) {
  $ret  = '<pre>' . print_r($arr, true) . '</pre>';
  if ($returnAsString)
    return $ret;
  else 
    echo $ret; 
}
function printMyCode() {
  $lines = file($_SERVER['SCRIPT_FILENAME']);
  echo "<pre class='mycode'>\n";
  foreach ($lines as $lineNo => $lineOfCode)
     printf("%3u: %1s \n", $lineNo, rtrim(htmlentities($lineOfCode)));
  echo "</pre>";
}
function php2js( $arr, $arrName ) {
  $lineEnd="";
  echo "<script>\n";
  echo "  var $arrName = {\n";
  foreach ($arr as $key => $value) {
    echo "$lineEnd    $key : $value";
    $lineEnd = ",\n";
  }
  echo "  \n};\n";
  echo "</script>\n\n";
}
function styleCurrentNavLink( $css ) {
  $here = $_SERVER['SCRIPT_NAME']; 
  $bits = explode('/',$here); 
  $filename = $bits[count($bits)-1]; 
  return "<style>nav a[href$='$filename'] { $css }</style>";
}

?>