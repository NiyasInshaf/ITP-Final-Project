<?php require_once('../Connections/dbconnect2.php'); ?>
<?php
$query_view_orders = "SELECT * FROM carts ORDER BY seno ASC";
$view_orders = mysql_query($query_view_orders, $dbconnect) or die(mysql_error());
$row_view_orders = mysql_fetch_assoc($view_orders);
$totalRows_view_orders = mysql_num_rows($view_orders);
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
	
<h4 class="alert-heading mt-4">Orders List</h4>			
		
		
<table width="100%" border="0" class="table-bordered table-striped">
  <tbody>
    <tr>
      <th width="30" scope="col">#</th>
      <th scope="col">Order ID</th>
      <th scope="col">Customer</th>
      <th scope="col">Date</th>
      <th scope="col">Contents</th>
      <th scope="col">Status</th>
    </tr>
<?php $i=1; ?>
<?php do{ ?>
<?php
$orderID = $row_view_orders['seno'];
$customerID = $row_view_orders['customer_id'];
	
$query_order_contents = "SELECT COUNT(seno), SUM(quantity) FROM carts_items WHERE cart_id = '$orderID'";
$order_contents = mysql_query($query_order_contents, $dbconnect) or die(mysql_error());
$row_order_contents = mysql_fetch_assoc($order_contents);
$totalRows_order_contents = mysql_num_rows($order_contents);
	
$query_get_customer = "SELECT * FROM customers WHERE seno = '$customerID'";
$get_customer = mysql_query($query_get_customer, $dbconnect) or die(mysql_error());
$row_get_customer = mysql_fetch_assoc($get_customer);
$totalRows_get_customer = mysql_num_rows($get_customer);
?>
    <tr>
      <td width="30"><?php echo $i; ?></td>
      <td><?php echo $row_view_orders['seno']; ?></td>
      <td><?php echo $row_get_customer['name']; ?> <?php echo $row_get_customer['l_name']; ?></td>
      <td><?php echo $row_view_orders['date']; ?></td>
      <td><?php echo $row_order_contents['COUNT(seno)']; ?> Items / <?php echo $row_order_contents['SUM(quantity)']; ?> Quantity</td>
      <td><?php echo $row_view_orders['status']; ?></td>
      </tr>
<?php $i++; ?>
<?php } while ($row_view_orders = mysql_fetch_assoc($view_orders)); ?>
  </tbody>
</table>
	
	
<div style="margin-top:10px;"><button class="btn btn-block btn-primary" onclick="window.print()">Print Orders List</button></div>
	
</body>
</html>