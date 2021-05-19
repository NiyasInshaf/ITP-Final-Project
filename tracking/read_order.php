<?php require_once('../Connections/dbconnect.php'); ?>		
<?php
$orderID = $_GET['id'];
	
$query_get_order_details = "SELECT * FROM carts WHERE seno = '$orderID'";
$get_order_details = mysql_query($query_get_order_details, $dbconnect) or die(mysql_error());
$row_get_order_details = mysql_fetch_assoc($get_order_details);
$totalRows_get_order_details = mysql_num_rows($get_order_details);

$customerID = $row_get_order_details['customer_id'];

$query_get_customer_info = "SELECT * FROM customers WHERE seno = '$customerID'";
$get_customer_info = mysql_query($query_get_customer_info, $dbconnect) or die(mysql_error());
$row_get_customer_info = mysql_fetch_assoc($get_customer_info);
$totalRows_get_customer_info = mysql_num_rows($get_customer_info);

$customer_name = $row_get_customer_info['name'].' '.$row_get_customer_info['l_name'];
	
$query_get_order_contents = "SELECT * FROM carts_items WHERE cart_id = '$orderID'";
$get_order_contents = mysql_query($query_get_order_contents, $dbconnect) or die(mysql_error());
$row_get_order_contents = mysql_fetch_assoc($get_order_contents);
$totalRows_get_order_contents = mysql_num_rows($get_order_contents);
	
$query_tracking_info = "SELECT * FROM tracking WHERE order_id = '$orderID' ORDER BY `updated_date` ASC";
$tracking_info = mysql_query($query_tracking_info, $dbconnect) or die(mysql_error());
$row_tracking_info = mysql_fetch_assoc($tracking_info);
$totalRows_tracking_info = mysql_num_rows($tracking_info);	
?>	
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Untitled Document</title>
<link href="../css/bootstrap-4.3.1.css" rel="stylesheet" type="text/css">
</head>

<body style="margin:20px;">
	
<table width="100%" border="0" class="table-bordered">
  <tbody>
    <tr>
      <td colspan="2" bgcolor="#DDD"><strong>Order ID: <?php echo $orderID; ?></strong></td>
      </tr>
    <tr>
      <td width="150"><strong>Customer Name:</strong></td>
      <td><?php echo $customer_name; ?></td>
      </tr>
    <tr>
      <td width="150"><strong>Phone:</strong></td>
      <td><?php echo $row_get_customer_info['phone']; ?></td>
      </tr>
    <tr>
      <td width="150"><strong>e-mail:</strong></td>
      <td><?php echo $row_get_customer_info['email']; ?></td>
      </tr>
  </tbody>
</table>

	
<h6 class="alert-heading mt-4">Order Details</h6>		
		
<table width="100%" border="0" class="table-bordered">
  <tbody>
    <tr>
      <td width="30" align="center" bgcolor="#CCC"><strong>#</strong></td>
      <td align="center" bgcolor="#CCC"><strong>Product</strong></td>
      <td align="center" bgcolor="#CCC"><strong>Quantity</strong></td>
      <td align="center" bgcolor="#CCC"><strong>Rate</strong></td>
      <td align="center" bgcolor="#CCC"><strong>Amount</strong></td>
    </tr>
	  <?php $n=1; $cartTotal = 0; ?>
	  <?php do{ ?>
<?php
$productID = $row_get_order_contents['stock_id'];		
	
$query_get_stock_data = "SELECT * FROM stock WHERE seno = '$productID'";
$get_stock_data = mysql_query($query_get_stock_data, $dbconnect) or die(mysql_error());
$row_get_stock_data = mysql_fetch_assoc($get_stock_data);
$totalRows_get_stock_data = mysql_num_rows($get_stock_data);		   
	
$amount = $row_get_order_contents['quantity'] * $row_get_stock_data['price_selling'];
?>
    <tr>
      <td width="30" align="center"><?php echo $n; ?></td>
      <td align="center"><?php echo $row_get_stock_data['name']; ?></td>
      <td align="center"><?php echo $row_get_order_contents['quantity']; ?></td>
      <td align="center"><?php echo $row_get_stock_data['price_selling']; ?></td>
      <td align="right"><strong><?php echo number_format((float)$amount,2,'.',''); ?></strong></td>
    </tr>
	  <?php $n++; $cartTotal += $amount;  ?>
	  <?php } while ($row_get_order_contents = mysql_fetch_assoc($get_order_contents)); ?>
    <tr>
      <td colspan="4" align="right"><strong>Total</strong></td>
      <td align="right"><strong><?php echo number_format((float)$cartTotal,2,'.',''); ?></strong></td>
    </tr>
  </tbody>
</table>
	
	
<div style="margin-top:10px;"><button class="btn btn-block btn-primary" onclick="window.print()">Print Order Note</button></div>
	
</body>
</html>