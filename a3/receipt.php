<?php
session_start();
include_once('tools.php');

?>
<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset="utf-8">
		<title>Receipt</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Keep wireframe.css for debugging, add your css to style.css -->
		<link id='wireframecss' type="text/css" rel="stylesheet" href="../wireframe.css" disabled>
		<link id='stylecss' type="text/css" rel="stylesheet" href="css/style.css">
		<style>
			@page {
				margin:0;
			}
		</style>
	</head>
	<body>
		<div class = 'receipt'>
			<div class = 'company'>
				<div class = 'logo'>
					<header>
						The Gatherer's<!--'--> Garden
					</header>
					<span>Genetic &nbsp;Modifications</span>
				</div>
				<div class = 'Cname'>Fontaine Industries</div>
				<div class = 'CAddress'>
					Fontaine Futuristics<br>
					1 Futuristic Drive<br>
					Rapture MNE 3000
				</div>
			</div>
			<div class = 'ttitle'>
				Tax Invoice
			</div>
			<div class= 'invoice'>
				<div class = 'date'>
					<div class = 'rtitle'>DATE</div>
					<?php
						$date = date("d-m-Y");
						echo $date;
					?>
				</div>
				<div class = 'details'> 
					<div class = 'rtitle'>DETAILS</div>
					<?php
						showDetails();
					?>
				</div>
				<div class = 'subtotal'>
					<div class = 'rtitle'>TOTAL (inc. GST)</div>
					<?php
						showSubtotals();
					?>
				</div>
			</div>
			<div class = 'receiptfooter'>
				<div class = 'msg'><?php showPostal();?></div>
				<div class = 'total'>Total: <?php showTotal();?> </div>
			</div>
		</div>
	</body>
</html>