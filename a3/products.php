<?php
session_start();
include_once('tools.php');
if (isset($_POST['cancel'])) {
	unset($_SESSION['cart']);
}
topModule("GG-Products");
?>
<article class = "product_container">
	<?php
	if (isset($_GET['id']) && this_actually_exists($_GET['id'], 0)) 
	{
		showProduct($_GET['id']);
	}
	?>
	<article class = "products">
		<section>
			<span class = "title">Elemental</span>
			<div class="prodcar">
				<?php
				createItems("El");
				?>
			</div>
		</section>
		<section>
			<span class = "title">Mind Control</span>
			<div class="prodcar">
				<?php
				createItems("Mc");
				?>
			</div>
		</section>
		<section>
			<span class = "title">Enhancements</span>
			<div class="prodcar">
				<?php
				createItems("En");
				?>
			</div>
		</section>
	</article>
</article>
<?php
endModule();
?>