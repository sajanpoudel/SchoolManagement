<?php
session_start();
require_once('../src/Auth.php');
requireLogin();
include('../config/DbFunction.php');
$obj = new DbFunction();

$id = intval($_GET['sid'] ?? 0);

$rs = $obj->showSubject1($id);
$res = $rs->fetch_object();
if (!$res) {
    header('location:view-subject.php');
    exit;
}

if (isset($_POST['submit'])) {

    $obj->edit_subject($_POST['sub1'], $_POST['sub2'], $_POST['sub3'], $_POST['udate'], $id);

}

?>
<?php
$pageTitle = 'Edit subject';
include('partials/head.php');
?>

<body>
<form method="post" >
	<div id="wrapper">

		<!-- Navigation -->
		<?php include('leftbar.php'); ?>

		<div id="page-wrapper">
			<?php include('partials/welcome.php'); ?>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">Edit Subject</div>
						<div class="panel-body">
							<div class="row">
						 	<div class="col-lg-10">
									
										<div class="form-group">
											<div class="col-lg-4">
					 <label>Subject1</label>
											</div>
											<div class="col-lg-6">
			
  <input class="form-control" name="sub1" id="sub1"  value="<?php echo htmlentities($res->sub1);?>" required="required">       
											</div>
											
										</div>	
										
								<br><br>
								
		<div class="form-group">
		<div class="col-lg-4">
		<label>Subject2</label>
		</div>
		<div class="col-lg-6">
<input class="form-control" name="sub2" id="sub2" value="<?php echo htmlentities($res->sub2);?>" required="required">         
		</div>
	 </div>	
										
	 <br><br>								
			<div class="form-group">
		<div class="col-lg-4">
		<label>Subject3</label>
		</div>
		<div class="col-lg-6">
<input class="form-control" name="sub3" id="sub3" value="<?php echo htmlentities($res->sub3);?>" required="required">         
		</div>
	 </div>	
										
	 <br><br>								
	<div class="form-group">
	<div class="col-lg-4">
	 <label>Date</label>
	</div>
	<div class="col-lg-6">
	<input class="form-control" value="<?php echo date('d-m-Y');?>" readonly="readonly" name="udate">
	
	</div>
	</div>
	</div>	
										
		<br><br>		
		
							<div class="form-group">
											<div class="col-lg-4">
												
											</div>
											<div class="col-lg-6"><br><br>
							<input type="submit" class="btn btn-primary" name="submit" value="Update Course"></button>
											</div>
											
										</div>		
													
				</div>

					</div>
								
							</div>
							
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
		

	</div>
	
	<?php include('partials/scripts.php'); ?>
	
	
</form>
</body>

</html>
