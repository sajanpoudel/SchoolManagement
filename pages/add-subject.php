<?php
session_start ();
include('../config/DbFunction.php');
	$obj=new DbFunction();
	$rs=$obj->showCourse();
	$rs1=$obj->showCourse();
if (! (isset ( $_SESSION ['login'] ))) {
	
	header ( 'location:../index.php' );
}
  if(isset($_POST['submit'])){
	
	$obj=new DbFunction();
	
	$obj->create_subject($_POST['course-short'],$_POST['course-full'],$_POST['sub1'],$_POST['sub2'],$_POST['sub3']);	
	
}


	?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title></title>
<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
<link href="../dist/css/sb-admin-2.css" rel="stylesheet">
<link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>
<form method="post" >
	<div id="wrapper">

		<!-- Navigation -->
		<?php include('leftbar.php')?>;


		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h4 class="page-header"> <?php echo strtoupper("welcome"." ".htmlentities($_SESSION['login']));?></h4>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">Add Subject</div>
						<div class="panel-body">
							<div class="row">
						 	<div class="col-lg-10">
									
										<div class="form-group">
											<div class="col-lg-4">
					 <label>Course Short Name<span id="" style="font-size:11px;color:Red">*</span>	</label>
											</div>
			
			<div class="col-lg-6">
			<select class="form-control" name="course-short" id="cshort" onchange="courseAvailability()" required="required" >
			<option VALUE="">SELECT</option>
				<?php while($res=$rs->fetch_object()){?>							
			
                        <option VALUE="<?php echo htmlentities($res->cid);?>"><?php echo htmlentities($res->cshort)?></option>
                        
                        
                    <?php }?>   			</div>
											 
                        </select>
					<span id="course-availability-status" style="font-size:12px;"></span>	
					</div>
					    </div>	
										
								<br><br>
								
		<div class="form-group">
		<div class="col-lg-4">
		<label>Course Full Name<span id="" style="font-size:11px;color:red">*</span></label>
		</div>
		<div class="col-lg-6">
		<select class="form-control" name="course-full"  id="cfull"required="required" onchange="coursefullAvail()">
        <option VALUE="">SELECT</option>
        <?php while($res1=$rs1->fetch_object()){?>							
			
     <option VALUE="<?php echo htmlentities($res1->cfull);?>"><?php echo htmlentities($res1->cfull)?></option>
                        
                        
                    <?php }?>   
       </select>
	   <span id="course-status" style="font-size:12px;"></span>
	 </div>
	 </div>	
	<br><br>								
								
		<div class="form-group">
		<div class="col-lg-4">
		<label>Subject1</label>
		</div>
		<div class="col-lg-6">
		<input class="form-control"  name="sub1">
	</div>
	 </div>	
	<br><br>	

     <div class="form-group">
		<div class="col-lg-4">
		<label>Subject2</label>
		</div>
		<div class="col-lg-6">
		<input class="form-control"  name="sub2">
	 </div>
	 </div>	
	<br><br>									
	<div class="form-group">
	<div class="col-lg-4">
	 <label>Subject3</label>
	</div>
	<div class="col-lg-6">
	<input class="form-control"  name="sub3">
	
	</div>
	</div>
	</div>	
	<br><br><br>								
										
	<div class="form-group">
											<div class="col-lg-4">
												
											</div>
											<div class="col-lg-6"><br><br>
	<input type="submit" class="btn btn-primary" name="submit" value="Add Subject"></button>
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
	

	<!-- jQuery -->
	<script src="../bower_components/jquery/dist/jquery.min.js"
		type="text/javascript"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"
		type="text/javascript"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script src="../bower_components/metisMenu/dist/metisMenu.min.js"
		type="text/javascript"></script>

	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js" type="text/javascript"></script>
	
	<script>
function coursefullAvail() {
	$("#loaderIcon").show();
jQuery.ajax({
url: "course_availability.php",
data:'cfull1='+$("#cfull").val(),
type: "POST",
success:function(data){
$("#course-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

function courseAvailability() {
	$("#loaderIcon").show();
jQuery.ajax({
url: "course_availability.php",
data:'cshort1='+$("#cshort").val(),
type: "POST",
success:function(data){
$("#course-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

</script>
</form>
</body>

</html>
