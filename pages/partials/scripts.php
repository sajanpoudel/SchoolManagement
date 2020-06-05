<?php
// Loads the scripts every admin page needs. $useDataTables turns the table with the id dataTables-example into a sortable one.
$useDataTables = !empty($useDataTables);
?>
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>
<?php if ($useDataTables) { ?>
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<?php } ?>
    <script src="../dist/js/sb-admin-2.js"></script>
<?php if ($useDataTables) { ?>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
<?php } ?>
