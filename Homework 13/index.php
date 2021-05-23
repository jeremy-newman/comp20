<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jade Delight II</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<style type = "text/css">
	html {
		font-family: monospace;
		text-align: center;
		margin: auto;
	}
	#selections {
		margin-left: auto;
		margin-right: auto;
		text-align: center;
	}
</style>
</head>

<body>

	<?php
		//establish connection info
		$server = "sql308.epizy.com";
		$userid = "epiz_27927000";
		$pw = "GALYqITTzuYn68";
		$db = "epiz_27927000_JadeDelight";
		
		//Create connection
		$conn = new mysqli($server, $userid, $pw, $db);
		
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
		
		$name = array();
		$price = array();
		
		if ($result = $conn -> query("SELECT * FROM menu")) {
			while ($row = $result -> fetch_assoc()) {
				array_push($name, $row["name"]);
				array_push($price, $row["price"]);
			}
			$result -> free_result();
		}
		$conn->close();
	?>
	
	
<script language="javascript">

function MenuItem(name, cost)
{
	this.name = name;
	this.cost = cost;
}

var item_name = <?php echo json_encode($name) ?>;

menuItems = new Array(
	new MenuItem(item_name[0], <?php echo ($price[0])?>),
	new MenuItem(item_name[1], <?php echo ($price[1])?>),
	new MenuItem(item_name[2], <?php echo ($price[2])?>),
	new MenuItem(item_name[3], <?php echo ($price[3])?>),
	new MenuItem(item_name[4], <?php echo ($price[4])?>)
);

function makeSelect(name, minRange, maxRange)
{
	var t= "";
	t = "<select name='" + name + "' size='1'>";
	for (j=minRange; j<=maxRange; j++)
	   t += "<option>" + j + "</option>";
	t+= "</select>"; 
	return t;
}
</script>

<script language="javascript">
	//this function calculates the costs of an item and updates it in the total
	//cost field, the subtotal, the Mass tax, and the total field. It is called
	//when an item is selected using the drop down menu.
	function calculateCost() {
		var subtotal_value = 0;
		//loops through each element and updates the total cost field
		for (var i = 0; i < 5; i++) {
			var item = document.getElementsByName("quan" + i);
			var price = menuItems[i].cost;
			var quantity = item[0].selectedIndex;
			var cost = price * quantity;
			document.forms[0].cost[i].value = cost.toFixed(2);
			//adds the item cost to the subtotal
			subtotal_value += cost;
		}
		//rounds to nearest hundredth
		subtotal_value = subtotal_value.toFixed(2);
		//sets the subtotal, tax, and total fields
		document.getElementById("subtotal").value = subtotal_value;
		document.getElementById("tax").value = (subtotal_value * 0.0625).toFixed(2);
		document.getElementById("total").value = (subtotal_value * 1.0625).toFixed(2);
	}
	//this function sets the visibility functionality for street and city fields
	//depending on whether or not the user has chosen delivery or pickup.
	function setVisibility() {
		//if the user selected delivery
		if (document.getElementById("delivery").checked) {
			document.getElementById("street").style.visibility = "visible";
			document.getElementById("city").style.visibility = "visible";
		}
		//if the user selected pickup
		else {
			document.getElementById("street").style.visibility = "hidden";
			document.getElementById("city").style.visibility = "hidden";
		}
	}
	//This function validates that the fields that the user input are correct.
	//It calls multiple other functions in order to do this.
	function validate() {
		var validated = false;
		with (document.data) {
			//checks if the starred fields are filled in
			if ((document.forms[0].lname.value == "") || (document.forms[0].phone.value == "")) {
				alert("You must enter a value for all of the required fields indicated by a star.");
			}
			//checks to see if phone number is valid
			else if (!validatePhone()) {
				alert("You must enter a valid phone number.");
			}
			//checks to see if the user selected at least one item
			else if (!validateQuantity()) {
				alert("You must order at least one item");
			}
			//if the user selected delivery, checks to see if street and city
			//fields are filled in
			else if ((document.getElementById("delivery").checked) && 
			((document.forms[0].street.value == "") || (document.forms[0].city.value == ""))) {
				alert("You must specify a street and a city for a delivery order.");
			}
			//if the inputs are valid, get the order and return true
			else {
				getOrder();
				validated = true;
			}
		}
		return validated;
	}
	//This function checks to see if the phone number entered is valid
	function validatePhone() {
		var validated = false;
		var valid_number = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
		//gotten from stack overflow (https://stackoverflow.com/questions/4338267/validate-phone-number-with-javascript)
		if (document.forms[0].phone.value.match(valid_number)) {
			validated = true;
		}
		return validated;	
	}
	//This function checks to see if the user has selected at least 1 item
	function validateQuantity() {
		var validated = false;
		for (var i = 0; i < 5; i++) {
			if (document.getElementsByName("quan" + i)[0].selectedIndex > 0) {
				validated = true;
			}
		}
		return validated;
	}
	//this function handles getting the order details if all is validated
	function getOrder() {
		var message = "";
		//adds the item and quantity for each quantity
		for (var i = 0; i < 5; i++) {
			var quantity = document.getElementsByName("quan" + i)[0].selectedIndex;
			if (quantity > 0) {
				message += quantity + " orders of " + menuItems[i].name + ": $" + menuItems[i].cost + " each <br>";
			}
		}
		//adds the total cost
		message += "Subtotal: $" + subtotal.value + "<br>";
		message += "Tax: $" + tax.value + "<br>";
		message += "Total Cost: $" + total.value + "<br>";
		//adds the time whether it is pickup or delivery times added 
		if (document.getElementById("delivery").checked) {
			message += "Delivery Time: " + new Date(new Date().getTime() + 30 * 60 * 1000).toLocaleTimeString();
		}
		else {
			message += "Pickup Time: " + new Date(new Date().getTime() + 15 * 60 * 1000).toLocaleTimeString();
		}
		document.forms[0].message.value = message;
	}
	//jQuery function
	$(document).ready(function() {
		$(".selected_quantity select").change(function(){
		calculateCost();
		})
	})
</script>

<h1 id = header>Jade Delight</h1>
<form method='get' action= "http://jeremy-newman.rf.gd/order.php" id = form onsubmit = "return validate()" name = "data">

<p>First Name: <input type="text"  name='fname' /></p>
<p>Last Name*:  <input type="text"  name='lname' /></p>
<p id = "street" style = "visibility: hidden;">Street: <input type="text"  name='street' /></p>
<p id = "city" style = "visibility: hidden;">City: <input type="text"  name='city' /></p>
<p id = "phone">Phone*: <input type="text"  name='phone' /></p>
<p id = "email">Email: <input type="text"  name='email' /></p>
<p id = "message"><input type = "text" name = "message" style = "visibility: hidden;"/></p>
<p> 
	<input type="radio" name="p_or_d" value = "pickup" checked="checked" onclick="setVisibility()"/>Pickup  
	<input type="radio" name='p_or_d' value = "delivery" id = "delivery" onclick ="setVisibility()"/>Delivery
</p>
<table border="0" cellpadding="3" id = "selections">
  <tr>
    <th>Select Item</th>
    <th>Item Name</th>
    <th>Cost Each</th>
    <th>Total Cost</th>
  </tr>
<script language="javascript">

  var s = "";
  for (i=0; i< menuItems.length; i++)
  {
	  s += "<tr><td> <span class = 'selected_quantity'>"; //added this span for the jQuery
	  s += makeSelect("quan" + i, 0, 10);
	  s += "</span></td><td>" + menuItems[i].name + "</td>";
	  s += "<td> $ " + menuItems[i].cost.toFixed(2) + "</td>";
	  s += "<td>$<input type='text' name='cost'/></td></tr>";
  }
  document.writeln(s);
</script>
</table>
<p>Subtotal: 
   $<input type="text"  name='subtotal' id="subtotal" />
</p>
<p>Mass tax 6.25%:
  $ <input type="text"  name='tax' id="tax" />
</p>
<p>Total: $ <input type="text"  name='total' id="total" />
</p>

<input type = "submit" value = "Submit Order" />

</form>
</body>
</html>