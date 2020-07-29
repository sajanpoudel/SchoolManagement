<?php
session_start();
include('../config/DbFunction.php');
$obj = new DbFunction();
if (! (isset($_SESSION ['login']))) {

    header('location:../index.php');
    exit;
}

$id = intval($_GET['cid'] ?? 0);

$rs = $obj->showCourse1($id);
$res = $rs->fetch_object();
if (!$res) {
    header('location:view-course.php');
    exit;
}

if (isset($_POST['submit'])) {

    $obj->edit_course($_POST['course-short'], $_POST['course-full'], $_POST['udate'], $id);

}

?>
<?php
$pageTitle = 'Edit course';
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
						<div class="panel-heading">Edit Course</div>
						<div class="panel-body">
							<div class="row">
						 	<div class="col-lg-10">
									
										<div class="form-group">
											<div class="col-lg-4">
					 <label>Course Short Name<span id="" style="font-size:11px;color:red">*</span>	</label>
											</div>
											<div class="col-lg-6">
			
  <input class="form-control" name="course-short" id="cshort"  value="<?php echo htmlentities($res->cshort);?>" required="required"  onblur="courseAvailability()">       
							<span id="course-availability-status" style="font-size:12px;"></span>				</div>
											
										</div>	
										
								<br><br>
								
		<div class="form-group">
		<div class="col-lg-4">
		<label>Course Full Name<span id="" style="font-size:11px;color:red">*</span></label>
		</div>
		<div class="col-lg-6">
<input class="form-control" name="course-full" id="cfull" value="<?php echo htmlentities($res->cfull);?>" required="required"  onblur="coursefullAvail()">         
	<span id="course-status" style="font-size:12px;"></span>				</div>
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
	
	<script>
function courseAvailability() {
	
jQuery.ajax({
url: "course_availability.php",
data:'cshort='+$("#cshort").val(),
type: "POST",
success:function(data){
$("#course-availability-status").html(data);


},
error:function (){}
});
}

function coursefullAvail() {
	
jQuery.ajax({
url: "course_availability.php",
data:'cfull='+$("#cfull").val(),
type: "POST",
success:function(data){
$("#course-status").html(data);


},
error:function (){}
});
}



</script>
</form>
</body>

</html>
