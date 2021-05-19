<?php require_once('../Connections/dbconnect2.php'); ?>
<?php
$query_view_orders = "SELECT * FROM carts ORDER BY seno ASC";
if(isset($_GET['id'])){
	$query_view_orders = "SELECT * FROM carts WHERE seno = '".$_GET['id']."'";
}
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
	
<h4 class="alert-heading mt-4">Tracking Summary</h4>		
	
	
	


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
<table width="100%" border="0" class="table-bordered">
  <tbody>
    <tr>
      <td colspan="2" bgcolor="#DDD"><strong>Order ID: <?php echo $orderID; ?></strong></td>
      </tr>
    <tr>
      <td width="150"><strong>Customer Name:</strong></td>
      <td><?php echo $row_get_customer['name']; ?> <?php echo $row_get_customer['l_name']; ?></td>
      </tr>
    <tr>
      <td width="150"><strong>Phone:</strong></td>
      <td><?php echo $row_get_customer['phone']; ?></td>
      </tr>
    <tr>
      <td width="150"><strong>e-mail:</strong></td>
      <td><?php echo $row_get_customer['email']; ?></td>
      </tr>
    <tr>
      <td width="150"><strong>Cotents:</strong></td>
      <td><?php echo $row_order_contents['COUNT(seno)']; ?> Items / <?php echo $row_order_contents['SUM(quantity)']; ?> Quantity</td>
      </tr>
  </tbody>
</table>	
	
<?php	
$query_get_order_details = "SELECT * FROM carts WHERE seno = '$orderID'";
$get_order_details = mysql_query($query_get_order_details, $dbconnect) or die(mysql_error());
$row_get_order_details = mysql_fetch_assoc($get_order_details);
$totalRows_get_order_details = mysql_num_rows($get_order_details);

$query_get_tracking_data = "SELECT * FROM tracking ORDER BY `updated_date` ASC";
$get_tracking_data = mysql_query($query_get_tracking_data, $dbconnect) or die(mysql_error());
$row_get_tracking_data = mysql_fetch_assoc($get_tracking_data);
$totalRows_get_tracking_data = mysql_num_rows($get_tracking_data);		
?>
		
<table width="100%" border="0" class="table-bordered table-striped">
  <tbody>
    <tr>
      <td colspan="5" bgcolor="#DDD"><strong>Order ID: <?php echo $row_get_order_details['seno']; ?></strong></td>
      </tr>
    <tr>
      <td width="30" bgcolor="#CCC">#</td>
      <td bgcolor="#CCC">Description</td>
      <td bgcolor="#CCC">Date</td>
      <td bgcolor="#CCC">Updated By</td>
    </tr>
    <tr>
      <td width="30" align="center">1</td>
      <td>Order Placed</td>
      <td><?php echo $row_get_order_details['date']; ?></td>
      <td></td>
    </tr>
	  <?php $i=2; ?>
	  <?php do{ ?>
<?php
$userID = $row_get_tracking_data['user'];
	
$query_get_admin_details = "SELECT * FROM user WHERE seno = '$userID'";
$get_admin_details = mysql_query($query_get_admin_details, $dbconnect) or die(mysql_error());
$row_get_admin_details = mysql_fetch_assoc($get_admin_details);
$totalRows_get_admin_details = mysql_num_rows($get_admin_details);	
?>
    <tr>
      <td width="30" align="center"><?php echo $i; ?></td>
      <td><?php echo $row_get_tracking_data['description']; ?></td>
      <td><?php echo $row_get_tracking_data['updated_date']; ?></td>
      <td><?php echo $row_get_admin_details['name']; ?></td>
    </tr>
	  <?php $i++; ?>
	  <?php } while ($row_get_tracking_data = mysql_fetch_assoc($get_tracking_data)); ?>
  </tbody>
</table>
	<br><br>

		
<?php $i++; ?>
<?php } while ($row_view_orders = mysql_fetch_assoc($view_orders)); ?>
	
	
<div style="margin-top:10px;"><button class="btn btn-block btn-primary" onclick="window.print()">Print Tracking List</button></div>
	
</body>
</html>