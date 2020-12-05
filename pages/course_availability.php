<?php
require_once('../config/Database.php');

$mysqli = Database::getInstance()->getConnection();

// Tables and columns the form fields may ask about. The names go into the query text, so they come from this list only.
$checks = [
    'cshort'  => ['tbl_course', 'cshort', 'Course Short Name'],
    'cshort1' => ['subject', 'cshort', 'Course Short Name'],
    'cfull'   => ['tbl_course', 'cfull', 'Course Full Name'],
    'cfull1'  => ['subject', 'cfull', 'Course Full Name'],
];

/** True when a row of $table already has $value in $column. */
function valueExists($mysqli, $table, $column, $value)
{
    $stmt = $mysqli->prepare("SELECT count(*) FROM $table WHERE $column=?");
    $stmt->bind_param('s', $value);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}

foreach ($checks as $field => [$table, $column, $label]) {
    if (!empty($_POST[$field]) && valueExists($mysqli, $table, $column, $_POST[$field])) {
        echo "<span style='color:red'> $label Already Exist .</span>";
    }
}
