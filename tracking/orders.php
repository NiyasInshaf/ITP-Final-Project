<?php require_once('../Connections/dbconnect2.php'); ?>
<?php

if ((isset($_GET['delete'])) && ($_GET['delete'] != "")) {
  $deleteSQL = "DELETE FROM carts WHERE seno=".$_GET['delete'];
  $Result1 = mysql_query($deleteSQL, $dbconnect) or die(mysql_error());
	
  $deleteSQL = "DELETE FROM carts_items WHERE cart_id=".$_GET['delete'];
  $Result1 = mysql_query($deleteSQL, $dbconnect) or die(mysql_error());

  $deleteGoTo = "orders.php";
  header(sprintf("Location: %s", $deleteGoTo));
}

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

<body style="padding-top: 70px">
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light"> <a class="navbar-brand" href="#">Admin Panel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent1">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active"> <a class="nav-link" href="index.php">Tracking Management</a> </li>      
      <li class="nav-item active"> <a class="nav-link" href="feedback.php">Read Feedback</a> </li>       
      <li class="nav-item active"> <a class="nav-link" href="orders.php">Orders List</a> </li>       

      <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Reports </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown1"> 
			<a class="dropdown-item" href="print_orders.php" onclick="window.open('print_orders.php','popup','width=600,height=600'); return false;">Orders List</a>
			<a class="dropdown-item" href="print_feedback.php" onclick="window.open('print_feedback.php','popup','width=600,height=600'); return false;">Feedback List</a>
			<a class="dropdown-item" href="print_tracking.php" onclick="window.open('print_tracking.php','popup','width=600,height=600'); return false;">Tracking Summary</a>
		  </div>
      </li>
		
    </ul>
	  
	  <div class="btn btn-warning">Hi <?php echo $admin_name; ?>! (<a href="<?php echo $logoutAction ?>">Logout</a>)</div>  
  </div>
</nav>
	
<div class="container">
	
<div class="row">

	<div class="col-md-12">
	
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
      <th width="120" scope="col">Actions</th>
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
      <td width="120"><a href="read_order.php?id=<?php echo $row_view_orders['seno']; ?>" target="popup" onclick="window.open('read_order.php?id=<?php echo $row_view_orders['seno']; ?>','popup','width=600,height=600'); return false;">View</a> <a href="orders.php?delete=<?php echo $row_view_orders['seno']; ?>" onClick="return confirm('Are you sure to delete this?')">Delete</a></td>
    </tr>
<?php $i++; ?>
<?php } while ($row_view_orders = mysql_fetch_assoc($view_orders)); ?>
  </tbody>
</table>
    </div>
	</div>
	</div>
	
	
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap-4.3.1.js"></script>
</body>
</html>