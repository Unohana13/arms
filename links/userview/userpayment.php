<?php session_start(); include_once('../config.php'); include('../paginator.class.php'); include('addreservation.php'); $userpaymentID  = $_SESSION['id'];?>
<!doctype html>
<html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec"  prefix="og: http://ogp.me/ns#" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>PHP pagination class with Bootstrap 4</title>

	<link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style type="text/css">
	body{
		background-color:rgba(255, 255, 255, 0.0);
	}
		table.table td a:hover {
			color: #2196F3;
		}

	    table.table td a.edit {
	        color: #F44336;
	    }
	    table.table td i {
	        font-size: 19px;
	    }
		table.table .avatar {
			border-radius: 50%;
			vertical-align: middle;
			margin-right: 10px;
		}
	</style>
</head>

<body>


<div class="container">

</br>
<div class="container" colspan="8" align="center">
	<Strong><span>Tenant Management <?php echo $_SESSION['id'] ?> <p class="fas fa-person-booth"></p> &nbsp;</span></strong>

</div>
</br>
</br>
			<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<div class="form-inline">
					<Strong><span>Search <p class="fas fa-search"></p> &nbsp;</span></strong>
						 <input type="text" name="tb1" onchange="submit()" class="form-control col-lg-7" placeholder="Enter Name of tenant">
						 <div class="col-lg-2">

						 </div>

						<a href="#addTenant" class="btn btn-primary" data-toggle="modal"><span>Add Payment</span></a>

				</div>
			</form>
	<hr>
	<?php
	if(isset($_REQUEST['tb1'])) {
		$condition		=	"";
		if(isset($_GET['tb1']) and $_GET['tb1']!="")
		{
			$condition		.=	" AND Tenant_Name LIKE'%".$_GET['tb1']."%'";
		}

		//Main query
		$pages = new Paginator;
		$pages->default_ipp = 10;
		$sql_forms = $mysqli->query("SELECT * FROM tenant WHERE status !='Archived' 1 ".$condition."");
		$pages->items_total = $sql_forms->num_rows;
		$pages->mid_range = 9;
		$pages->paginate();

		$result	=	$mysqli->query("SELECT * FROM tenant WHERE status !='Archived' 1 ".$condition." ORDER BY Tenant_Name ASC ".$pages->limit."");
	}else {
  $pages = new Paginator;
		$pages->default_ipp = 10;
		$sql_forms = $mysqli->query("SELECT * FROM userpayment1");
		$pages->items_total = $sql_forms->num_rows;
		$pages->mid_range = 9;
		$pages->paginate();

		$result	=	$mysqli->query("SELECT * FROM userpayment1 ORDER BY ID ASC ".$pages->limit."");
}
	?>
	<div class="clearfix"></div>

	<div class="row marginTop">
		<div class="col-sm-12 paddingLeft pagerfwt">
			<?php if($pages->items_total > 0) { ?>
				<?php echo $pages->display_pages();?>
				<?php echo $pages->display_items_per_page();?>
				<?php echo $pages->display_jump_menu(); ?>
			<?php }?>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="clearfix"></div>

	<table class="table table-bordered table-striped" id="empTable">
		<thead>
			<tr class="header">
				<th style="text-align:center;">ID</th>
				<th style="text-align:center;">Reference Number</th>
				<th style="text-align:center;">Date Submitted</th>
				<th style="text-align:center;">Status</th>
				<th style="text-align:center;">Remarks</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if($pages->items_total>0){
				$n=1;
				$s=0;
				$Hello = array($pages->items_total);

				while($val = $result->fetch_assoc()){
					$idEdit = $val['ID'];
					$tenantName = $val['tenantname'];
					$tenantid = $val['Tenant_ID'];
			?>
			<tr>
				<?php $n++; ?>
				<td style="text-align:center;"><?php echo $val['ID']; ?></td>
				<td style="text-align:center;"><?php echo $val['tracking']; ?></td>
				<td style="text-align:center;"><?php echo $val['date']; ?></td>
				<td style="text-align:center;"><?php echo $val['status']; ?></td>
				<?php $Hello[$n-2] = $val['Tenant_Id']; ?>

		<td style="text-align:center;">
			 <a class ="remark" href="#remark<?php echo $idEdit;?>" data-toggle="modal">
			  <i class="fas fa-file-signature" data-toggle="tooltip" title="Purpose of Payment"></i></a>
		</td>

		<div id="deposit<?php echo $val['ID'];?>" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
									<div class="modal-header">
										<h4 class="modal-title"><?php echo $val['tenantname']; ?>'s Deposit Slips'</h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									</div>
									<div class="modal-body">
										<div class="thumbnail">

										<img src="userpayment/<?php echo $val['image'] ?>" alt="userpayment" style="width:100%">
									</div>
									</div>
									<div class="modal-footer">
										<input type="button" class="btn btn-default" data-dismiss="modal" value="Close">
									</div>
								</form>
							</div>
						</div>
					</div>


				<div id="remark<?php echo $val['ID'];?>" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
									<div class="modal-header">
										<h4 class="modal-title"><?php echo $val['tenantname']; ?>'s Purpose of Payment'</h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									</div>
									<div class="modal-body">
										<p><?php echo $val['remark']; ?></p>
									</div>
									<div class="modal-footer">
										<input type="button" class="btn btn-default" data-dismiss="modal" value="Close">
									</div>
								</form>
							</div>
						</div>
					</div>



			</tr>
			<?php
				}
			}else{?>
			<tr>
				<td colspan="8" align="center"><strong>No Record(s) Found!</strong></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	
	<div class="clearfix"></div>

	<div class="row marginTop">
		<div class="col-sm-12 paddingLeft pagerfwt">
			<?php if($pages->items_total > 0) { ?>
				<?php echo $pages->display_pages();?>
				<?php echo $pages->display_items_per_page();?>
				<?php echo $pages->display_jump_menu(); ?>
			<?php }?>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="clearfix"></div>

</div>
<div id="addTenant" class="modal fade">
	<?php $datetoday = date('Y-m-d H:i:s'); ?>
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="adduserpayment.php">
				<input name="userpaymententID" type = "hidden" class="form-control" value="<?php echo $userpaymentID; ?>">
				<input name="date" type = "hidden" class="form-control" value="<?php echo $datetoday; ?>">
					<div class="modal-header">
						<h4 class="modal-title">User Payment Form:</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Refrence Number :</label>
							<input name="trackingnumber" type="text" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Purpose of Payment :</label>
							<input name="remark" type="text" class="form-control" required>
						</div>
						<!---<div class="form-group">
							<label>Upload Image of Deposit Slip :</label>
							<span class="fas fa-upload" style="color:#2196F3"></span><span style="color:#2196F3;"></span><input type="file" name="img" required>
						</div>-->
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" onsubmit="setTimeout(function () { window.location.reload(); }, 10)" class="btn btn-success" name="adduserpayment" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>


</body>
</html>
