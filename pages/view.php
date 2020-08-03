<?php
session_start();
require_once('../src/Auth.php');

requireLogin();

include('../config/DbFunction.php');
$obj = new DbFunction();
$rs = $obj->showStudents();


if (isset($_GET['del'])) {

    $obj->del_std(intval($_GET['del']));
}

?> 

<?php
$pageTitle = 'View students';
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
                            View Students
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>SNo</th>
											<th>RegNo</th>
											<th>Name</th>
                                            <th>Email</th>
                                            <th>MobNO</th>
											<th>Course</th>
											<th>Subject</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                         $sn = 1;
while ($res = $rs->fetch_object()) {

    $c = $res->course;
    $cname = $obj->showCourse1($c);
    $res1 = $cname->fetch_object();
    $courseName = $res1 ? $res1->cshort : '';

    ?>	
                                        <tr class="odd gradeX">
                              <td><?php echo $sn?></td>
                              <td><?php echo htmlentities(strtoupper($res->regno));?></td>
             <td><?php echo htmlentities(strtoupper($res->fname." ".$res->mname." ".$res->lname));?></td>
       <td><?php echo htmlentities(strtoupper($res->emailid));?></td>
	  <td><?php echo htmlentities($res->mobno);?></td>
	  <td><?php echo htmlentities(strtoupper($courseName));?></td>
      <td><?php echo htmlentities(strtoupper($res->subject));?></td>											  
      <td>&nbsp;&nbsp;<a href="edit-std.php?id=<?php echo htmlentities($res->id);?>">
	  <p class="fa fa-edit"></p></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="view.php?del=<?php echo htmlentities($res->id); ?>" onclick="return confirm('Delete this student?');">
	  <p class="fa fa-times-circle"></p></a>
	  </td>
                                            
                                        </tr>
                                        
                                    <?php $sn++;
}?>   	           
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                           
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           
            
           
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php $useDataTables = true; include('partials/scripts.php'); ?>

</body>

</html>
