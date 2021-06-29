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
<?php
$pageTitle = 'Dashboard';
include('partials/head.php');
?>

<body>

    <div id="wrapper">

        <?php include('leftbar.php'); ?>

        <div id="page-wrapper">
            <?php include('partials/welcome.php'); ?>

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

    <?php include('partials/scripts.php'); ?>

</body>

</html>
