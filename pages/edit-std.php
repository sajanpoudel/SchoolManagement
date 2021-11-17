

<?php
session_start ();

if (! (isset ( $_SESSION ['login'] ))) {
	
	header ( 'location:../index.php' );
}
include('../config/DbFunction.php');
	$obj=new DbFunction();
	$id=$_GET['id'];
    $rs=$obj->showStudents1($id);
    $res=$rs->fetch_object(); 
	$c=$res->course;
    $cname=$obj->showCourse1($c);
    $res1=$cname->fetch_object();
	$rs1=$obj->showCourse();
	$rs2=$obj->showCountry();
	if(isset($_POST['submit'])){
	
     
     $obj->edit_std($_POST['course-short'],$_POST['c-full'],$_POST['fname'],$_POST['mname'],$_POST['lname'],
     	            $_POST['gender'],$_POST['gname'],$_POST['ocp'],$_POST['income'],$_POST['category'],$_POST['ph'],$_POST['nation']

     	             , $_POST['mobno'],$_POST['email'],$_POST['country'],$_POST['state'],$_POST['city'],$_POST['padd'],
     	              $_POST['cadd'],$_POST['board1'],$_POST['board2'],$_POST['roll1'],$_POST['roll2'],$_POST['pyear1'],
     	              $_POST['pyear2'],$_POST['sub1'],$_POST['sub2'],$_POST['marks1'],$_POST['marks2'],$_POST['fmarks1'],
     	              $_POST['fmarks2'] ,$_GET['id']);
	
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
<title>edit students</title>
<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css"
	rel="stylesheet">
<link href="../bower_components/metisMenu/dist/metisMenu.min.css"
	rel="stylesheet">
<link href="../dist/css/sb-admin-2.css" rel="stylesheet">
<link href="../bower_components/font-awesome/css/font-awesome.min.css"
	rel="stylesheet" type="text/css">
</head>

<body>
<form method="post" >
	<div id="wrapper">
	<!--left !-->
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
			<div class="panel-heading">Register</div>
			<div class="panel-body">
			<div class="row">
			<div class="col-lg-10">
			<div class="form-group">
		    <div class="col-lg-4">
			<label>Select Course<span id="" style="font-size:11px;color:red">*</span>	</label>
			</div>
			<div class="col-lg-6">
<select class="form-control" name="course-short" id="cshort"  onchange="showSub(this.value)" required="required" >			
<option VALUE="<?php echo $res1->cid?>"><?php echo $res1->cshort?></option>
				<?php while($res2=$rs1->fetch_object()){?>							
			
                   <?php if($res2->cid==$res1->cid){
				   continue;
				   }else
				   
				   ?>                     
					 <option VALUE="<?php echo htmlentities($res2->cid);?>"><?php echo htmlentities($res2->cshort)?></option>
                        
                        
                    <?php }?>   </select>
										</div>
											
										</div>	
										
								<br><br>
								
		<div class="form-group">
		<div class="col-lg-4">
		<label>Select Subject<span id="" style="font-size:11px;color:red">*</span></label>
		</div>
		<div class="col-lg-6">
 <input class="form-control" name="c-full"  id="c-full"  value="<?php echo $res->subject;?>">
       </select>
	</div>
	 </div>	
										
	 <br><br>								
			
			<div class="form-group">
		<div class="col-lg-4">
		<label>Current  Session<span id="" style="font-size:11px;color:red">*</span></label>
		</div>
		<div class="col-lg-6">
		
	   <input class="form-control" name="session" value="<?php echo htmlentities($res->session);?>" readonly>
	 </div>	
										
	 <br><br>								
	
	</div>	
	<br><br>		
		
									
													
				</div>

					</div>
								
							</div>
							
						</div>
						
					</div>
			<div class="row">
			<div class="col-lg-12">
			<div class="panel panel-default">
			<div class="panel-heading">Personal Informations</div>
			<div class="panel-body">
			<div class="row">
			<div class="col-lg-12">
			<div class="form-group">
		    <div class="col-lg-2">
			<label>First Name<span id="" style="font-size:11px;color:red">*</span>	</label>
			
			</div>
			<div class="col-lg-4">
			<input class="form-control" name="fname" value="<?php echo htmlentities($res->fname);?>"required="required">
			</div>
			 <div class="col-lg-2">
			<label>Middle Name</label>
			
			</div>
			<div class="col-lg-4">
			<input class="form-control" name="mname" value="<?php echo htmlentities($res->mname);?>">
			</div>
			</div>	
			<br><br>
								
		<div class="form-group">
		    <div class="col-lg-2">
			<label>Last Name</label>
			</div>
			<div class="col-lg-4">
			<input class="form-control" name="lname" value="<?php echo htmlentities($res->lname);?>">
			</div>
			 <div class="col-lg-2">
			<label>Gender<span id="" style="font-size:11px;color:red">*</span></label>
			
			</div>
			<div class="col-lg-4">
			<?php 
			if (strcasecmp($res->gender,"Male")==0){?>
		 <input type="radio" name="gender" id="male" value="Male" required="required" checked> &nbsp; Male &nbsp;
		 <?php }else{ ?>
		 <input type="radio" name="gender" id="male" value="Male" required="required"> &nbsp; Male &nbsp;
		 <?php }?>
		 <?php 
			if (strcasecmp($res->gender,"female")==0){?>
		 <input type="radio" name="gender" id="female" value="female" checked> &nbsp; Female &nbsp;
		 <?php } else{?>
		 <input type="radio" name="gender" id="female" value="female"> &nbsp; Female &nbsp;
		 <?php }?>
		 <?php 
			if (strcasecmp($res->gender,"other")==0){?>
		 <input type="radio" name="gender" id="other" value="other" checked> &nbsp; Other &nbsp;
		 <?php } else{?>
		 <input type="radio" name="gender" id="other" value="other"> &nbsp; Other &nbsp;
		 <?php }?>
			</div>
			</div>	
	<br><br>		
		     <div class="form-group">
			 <div class="col-lg-2">
			<label>Guardian Name<span id="" style="font-size:11px;color:red">*</span>	</label>
			
			</div>
			<div class="col-lg-4">
			<input class="form-control" name="gname" required="required" 
			value="<?php echo htmlentities($res->gname);?>">
			</div>
			 <div class="col-lg-2">
			<label>Occupation</label>
			
			</div>
			<div class="col-lg-4">
			<input class="form-control" name="ocp" id="ocp" value="<?php echo htmlentities($res->ocp);?>">
			</div>
			</div>	
			<br><br>
					
		     <div class="form-group">
			 <div class="col-lg-2">
			<label>Family Income<span id="" style="font-size:11px;color:red">*</span></label>
			
			</div>
			<div class="col-lg-4">
			<select class="form-control" name="income"  id="income"required="required" >
        <option value="<?php echo htmlentities($res->income);?>"><?php echo htmlentities($res->income);?></option>
        <option VALUE="200000">200000</option>
        <option value="500000">500000</option>
        <option value="700000">700000</option>
        
       </select>
			</div>
			 <div class="col-lg-2">
			<label>Category<span id="" style="font-size:11px;color:red">*</span></label>
			
			</div>
			<div class="col-lg-4">
			<select class="form-control" name="category"  id="category" required="required" >
        <option value="<?php echo htmlentities($res->category);?>"><?php echo htmlentities($res->category);?></option>
        <option VALUE="general">General</option>
        <option value="obc">OBC</option>
        <option value="sc">SC</option>
        <option value="st">ST</option>
		<option value="other">Other</option>
       </select>
			</div>
			</div>	
			<br><br>
			
			
					
		     <div class="form-group">
			 <div class="col-lg-2">
			<label>Physically Challenged<span id="" style="font-size:11px;color:red">*</span></label>
			
			</div>
			<div class="col-lg-4">
			<select class="form-control" name="ph"  id="ph"required="required" >
        <option VALUE="<?php echo htmlentities($res->category);?>"><?php echo htmlentities($res->category);?></option>
        <option VALUE="yes">Yes</option>
        <option value="no">No</option>
               
       </select>
			</div>
			 <div class="col-lg-2">
			<label>Nationality<span id="" style="font-size:11px;color:red">*</span></label>
			
			</div>
			<div class="col-lg-4">
			<input class="form-control" name="nation" id="nation" required="required" 
			value="<?php echo htmlentities($res->nationality);?>">
			</div>
			</div>	
			<br><br>
			</div>	
			<br><br>
		</div>
      	</div>
		</div>
			
		<div class="row">
			<div class="col-lg-12">
			<div class="panel panel-default">
			<div class="panel-heading">Contact Informations</div>
			<div class="panel-body">
			<div class="row">
			<div class="col-lg-12">
			<div class="form-group">
		    <div class="col-lg-2">
			<label>Mobile Number<span id="" style="font-size:11px;color:red">*</span>	</label>
			
			</div>
			<div class="col-lg-4">
			<input class="form-control" type="number" name="mobno" required="required" maxlength="10" 
			   value="<?php echo htmlentities($res->mobno);?>">
			</div>
			 <div class="col-lg-2">
			<label>Email Id<span id="" style="font-size:11px;color:red">*</span></label>
			
			</div>
			<div class="col-lg-4">
			<input class="form-control"  type="email" name="email" required="required" 
			value="<?php echo htmlentities($res->emailid);?>">
			</div>
			</div>	
			<br><br>
								
		<div class="form-group">
		    <div class="col-lg-2">
			<label>Country<span id="" style="font-size:11px;color:red">*</span></label>
			</div>
			<div class="col-lg-4">
			<select class="form-control" name="country" id="country" onchange="showState(this.value)"
			required="required"  value="<?php echo htmlentities($res->country);?>">			
<option VALUE="">Select Country</option>
				<?php while($res3=$rs2->fetch_object()){?>							
			
   <option VALUE="<?php echo htmlentities($res3->id);?>"><?php echo htmlentities($res3->name)?></option>
                        
                        
                    <?php }?>   </select>
			</div>
			 <div class="col-lg-2">
			<label>State<span id="" style="font-size:11px;color:red">*</span></label>
			
			</div>
			<div class="col-lg-4">
 <select name="state" id="state"  class="form-control" onchange="showDist(this.value)" required="required">
        <option value="">Select State</option>
        </select>
			</div>
			
			</div>	
			
	<br><br><br><br>		
		     <div class="form-group">
			 <div class="col-lg-2">
			<label>City<span id="" style="font-size:11px;color:red">*</span>	</label>
			
			</div>
			<div class="col-lg-4">
           <select name="city" id="dist"  class="form-control" onchange="showDist(this.value)" >
        <option value="">Select City</option>
		</select>
			</div>
			 <div class="col-lg-2">
			<label>Permanent Address<span id="" style="font-size:11px;color:red">*</span></label>
			
			</div>
			<div class="col-lg-4">
			<textarea class="form-control" rows="3" name="padd"><?php echo htmlentities($res->padd);?></textarea>
			</div>
			</div>	
			<br><br><br><br>
					
		     
			<br><br>
			
			
					
		     <div class="form-group">
			 <div class="col-lg-2">
			<label>Correspondence Address<span id="" style="font-size:11px;color:red">*</span>
			</label>
			</div>
			<div class="col-lg-4">
      <textarea class="form-control" rows="3" name="cadd"><?php echo htmlentities($res->cadd);?></textarea>
			</div>
			 <div class="col-lg-2">
			
			
			
			</div>
			<div class="col-lg-4">
			
			</div>
			</div>	
			<br><br>
			
			
			</div>	
			<br><br>
		</div>
      	</div>
		</div>					
        <div class="row">
			<div class="col-lg-12">
			<div class="panel panel-default">
			<div class="panel-heading">Academic Informations</div>
			<div class="panel-body">
			<div class="row">
			
			<div class="col-lg-12">
			<div class="form-group">
		    <div class="panel panel-default">
            <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                         <div class="col-lg-6">
			<th>&nbsp;&nbsp;&nbsp;&nbsp;Board<span id="" style="font-size:11px;color:red">*</span>	</label></th>
			</div>   
            <div class="col-lg-6">
			<th>&nbsp;&nbsp;&nbsp;&nbsp;Roll No</th>
			</div>   
              <div class="col-lg-6">
			 <th>&nbsp;&nbsp;&nbsp;&nbsp;Year Of Passing<span id="" style="font-size:11px;color:red">*</span></th>
			</div>                                 
            </tr>
                                    </thead>
                                    <tbody>
                                        <tr> 
                  <td><div class="col-lg-6">
				  <input class="form-control" type="text" name="board1" value="<?php echo htmlentities($res->board);?>">
				  </div></td>
                  <td><div class="col-lg-6">
			<input class="form-control" type="text" name="roll1" value="<?php echo htmlentities($res->roll);?>">
			</div></td>
            <td><div class="col-lg-6">
			<input class="form-control"  type="text" name="pyear1" value="<?php echo htmlentities($res->pyear);?>">
			</div></td>
                  </tr>

              <tr> 
                  <td><div class="col-lg-6">
				  <input class="form-control" type="text" name="board2" value="<?php echo htmlentities($res->board1);?>">
				  </div></td>
                  <td><div class="col-lg-6">
			<input class="form-control" type="text" name="roll2" value="<?php echo htmlentities($res->roll1);?>">
			</div></td>
            <td><div class="col-lg-6">
			<input class="form-control"  type="text" name="pyear2" value="<?php echo htmlentities($res->yop1);?>">
			</div></td>
                  </tr>      
                                        
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
			</div>	
			<br><br>					
		  </div>	
			<br><br>			
			<br><br>
			<div class="col-lg-12">
			<div class="form-group">
		    <div class="panel panel-default">
            <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                         <div class="col-lg-6">
			<th>S.No</th>
			</div>   
            <div class="col-lg-6">
			<th>&nbsp;&nbsp;&nbsp;&nbsp;Subject</th>
			</div>   
              <div class="col-lg-6">
			 <th>&nbsp;&nbsp;&nbsp;&nbsp;Marks Obtained</th>
			</div>                                 
             <div class="col-lg-6">
			   <th>&nbsp;&nbsp;&nbsp;&nbsp;Full Marks</th>
			</div>                               
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr> 
                  <td>1</td>
                  <td><div class="col-lg-6">
			<input class="form-control"  type="text" name="sub1" value="<?php echo htmlentities($res->sub);?>">
			</div></td>
                  <td><div class="col-lg-6">
			<input class="form-control"  type="text" name="marks1" value="<?php echo htmlentities($res->marks);?>">
			</div></td>
			                  <td><div class="col-lg-6">
			<input class="form-control"  type="text" name="fmarks1" value="<?php echo htmlentities($res->fmarks);?>">
			</div></td>
                  </tr>
				  
	         <tr> 
                  <td>2</td>
                  <td><div class="col-lg-6">
			<input class="form-control"  type="text" name="sub2" value="<?php echo htmlentities($res->sub1);?>">
			</div></td>
                  <td><div class="col-lg-6">
			<input class="form-control"  type="text" name="marks2" value="<?php echo htmlentities($res->marks1);?>">
			</div></td>
			                  <td><div class="col-lg-6">
			<input class="form-control"  type="text" name="fmarks2" value="<?php echo htmlentities($res->fmarks1);?>">
			</div></td>
                  </tr>			  
                                        
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
			</div>	
							
		  </div>	
			<br>
		
	<div class="form-group">
	<div class="col-lg-4">
	</div>
	<div class="col-lg-6"><br><br>
	<input type="submit" class="btn btn-primary" name="submit" value="Update"></button>
	</div>
	</div>			
	</div>
	</div><!--row!-->	

					
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
function showState(val) {
    
  	$.ajax({
	type: "POST",
	url: "subject.php",
	data:'id='+val,
	success: function(data){
	  // alert(data);
		$("#state").html(data);
	}
	});
}

function showDist(val) {
    
  	$.ajax({
	type: "POST",
	url: "subject.php",
	data:'did='+val,
	success: function(data){
	  // alert(data);
		$("#dist").html(data);
	}
	});
	
}



function showSub(val) {
    
    //alert(val);
  	$.ajax({
	type: "POST",
	url: "subject.php",
	data:'cid='+val,
	success: function(data){
	  // alert(data);
		$("#c-full").val(data);
	}
	});
	
}
</script>
</form>
</body>

</html>
