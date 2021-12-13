<?php
// How the fields of the registration form map to the columns of the registration table.

/** Column name => name of the form field. The order is the order of the columns in the queries. */
const STUDENT_FIELDS = [
    'course' => 'course-short',
    'subject' => 'c-full',
    'fname' => 'fname',
    'mname' => 'mname',
    'lname' => 'lname',
    'gender' => 'gender',
    'gname' => 'gname',
    'ocp' => 'ocp',
    'income' => 'income',
    'category' => 'category',
    'pchal' => 'ph',
    'nationality' => 'nation',
    'mobno' => 'mobno',
    'emailid' => 'email',
    'country' => 'country',
    'state' => 'state',
    'dist' => 'city',
    'padd' => 'padd',
    'cadd' => 'cadd',
    'board' => 'board1',
    'board1' => 'board2',
    'roll' => 'roll1',
    'roll1' => 'roll2',
    'pyear' => 'pyear1',
    'yop1' => 'pyear2',
    'sub' => 'sub1',
    'sub1' => 'sub2',
    'marks' => 'marks1',
    'marks1' => 'marks2',
    'fmarks' => 'fmarks1',
    'fmarks1' => 'fmarks2',
];

/** The values of the form in column order. A field that was not sent is an empty string. */
function studentFromPost(array $post)
{
    $student = [];
    foreach (STUDENT_FIELDS as $column => $field) {
        $student[$column] = isset($post[$field]) ? trim((string) $post[$field]) : '';
    }
    return $student;
}

/** An INSERT statement with one placeholder per column. The names come from code, never from a visitor. */
function buildInsertSql($table, array $columns)
{
    $names = implode(', ', array_map(function ($c) { return "`$c`"; }, $columns));
    $marks = implode(', ', array_fill(0, count($columns), '?'));
    return "INSERT INTO `$table` ($names) VALUES ($marks)";
}

/** An UPDATE statement for the given columns that selects the row with the id column. */
function buildUpdateSql($table, array $columns, $idColumn)
{
    $sets = implode(', ', array_map(function ($c) { return "`$c`=?"; }, $columns));
    return "UPDATE `$table` SET $sets WHERE `$idColumn`=?";
}
