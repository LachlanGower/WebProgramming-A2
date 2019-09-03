
function quantity(i)
{
	var e = document.getElementsByClassName("type")[0];
	var price = parseFloat(e.options[e.selectedIndex].dataset.price);
	var quantity = document.getElementsByClassName("quantity")[0];
	var i = parseInt(i);
	quantity.value = parseFloat(quantity.value) + i;
	if(quantity.value < 0){quantity.value = 0;}
	if(isNaN(quantity.value)){quantity.value = 1;}
	document.getElementsByClassName("product_price")[0].innerHTML = "$"+(quantity.value * price).toFixed(2);
}
function changePrice()
{
	var e = document.getElementsByClassName("type")[0];
	var price = parseFloat(e.options[e.selectedIndex].dataset.price);
	var quantity = document.getElementsByClassName("quantity")[0];
	document.getElementsByClassName("product_price")[0].innerHTML = "$"+(quantity.value * price).toFixed(2);
}
function validation()
{
	var quantity = document.getElementsByClassName("quantity")[0].value;
	if(quantity < 1){
		return false;
	}else{
		return true;
	}
}
function visaShow()
{
	var card = document.getElementsByClassName("checkoutInput")[4].value;
	var patt = /^4(\d[ ]?){12,15}$/;
	var visa = document.getElementById("visa").style;
	if (patt.test(card)){
		visa.visibility = "visible";
	}else{
		visa.visibility = "hidden";
	}
}