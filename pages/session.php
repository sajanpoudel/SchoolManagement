<?php
session_start();
require_once('../src/Auth.php');

requireLogin();

include('../config/DbFunction.php');
$obj = new DbFunction();
$rs = $obj->showSession();
?> 

<?php
$pageTitle = 'Sessions';
$useDataTables = true;
include('partials/head.php');
?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
      
     <?php include('leftbar.php'); ?>

           
         <nav>
        <div id="page-wrapper">
            <?php include('partials/welcome.php'); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            View Session
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                            <div class="form-group">
		    
			
			 <div class="col-lg-2">
			<label>Session<span id="" style="font-size:11px;color:red">*</span></label>
			
			</div>
                  <div class="col-lg-4">
				  <?php while ($res = $rs->fetch_object()) {
				      if ($res->status == 1) {
				          ?>
		 <input type="radio" name="gender" id="male" value="<?php echo htmlentities($res->session);?>" checked required="required">
		 &nbsp;&nbsp;<?php echo htmlentities($res->session);?> <br>
		<?php  } ?>
		
		 <input type="radio" name="gender" id="male" value="<?php echo htmlentities($res->session);?>" checked required="required">
		 &nbsp;&nbsp;<?php echo htmlentities($res->session);?> <br>
		 
		 <?php }?>
			</div>         
                 
<input type="submit" class="btn btn-primary" name="submit" value="Update Session">
				 </div>
    
	
                    </div>
                    
	
	
                </div>
                
            </div>
           
           
            
           
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php $useDataTables = true; include('partials/scripts.php'); ?>

</body>

</html>
