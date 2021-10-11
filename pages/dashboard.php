<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('location:../index.php');
    exit;
}

include('../config/DbFunction.php');
$obj = new DbFunction();

$tiles = [
    ['Students', $obj->countRows('registration'), 'fa-users', 'view.php', 'panel-primary'],
    ['Courses', $obj->countRows('tbl_course'), 'fa-book', 'view-course.php', 'panel-green'],
    ['Subjects', $obj->countRows('subject'), 'fa-tasks', 'view-subject.php', 'panel-yellow'],
    ['Sessions', $obj->countRows('session'), 'fa-calendar', 'session.php', 'panel-red'],
];
$latest = $obj->latestStudents(5);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div id="wrapper">

        <?php include('leftbar.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header"> <?php echo strtoupper("welcome" . " " . htmlentities($_SESSION['login'])); ?></h4>
                </div>
            </div>

            <div class="row">
                <?php foreach ($tiles as [$label, $total, $icon, $link, $style]) { ?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel <?php echo $style; ?>">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa <?php echo $icon; ?> fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $total; ?></div>
                                    <div><?php echo $label; ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo $link; ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Latest registrations</div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>RegNo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($student = $latest->fetch_object()) { ?>
                                    <tr>
                                        <td><?php echo htmlentities($student->regno); ?></td>
                                        <td><?php echo htmlentities(strtoupper($student->fname . " " . $student->lname)); ?></td>
                                        <td><?php echo htmlentities($student->emailid); ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
