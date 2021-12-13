<?php
require_once __DIR__ . '/../src/Student.php';

$post = ['course-short' => '3', 'c-full' => 'Maths+Physics', 'fname' => ' Ada ', 'gender' => 'female', 'ph' => 'no',
    'board1' => 'CBSE', 'board2' => 'ICSE', 'roll1' => '12', 'roll2' => '34', 'pyear1' => '2014', 'pyear2' => '2016'];
$student = studentFromPost($post);

check('the columns come in table order', array_keys($student) === array_keys(STUDENT_FIELDS));
check('values are trimmed', $student['fname'] === 'Ada');
check('the course field maps to the course column', $student['course'] === '3');
check('the first board maps to board', $student['board'] === 'CBSE' && $student['board1'] === 'ICSE');
check('the second roll maps to roll1', $student['roll'] === '12' && $student['roll1'] === '34');
check('the second year maps to yop1', $student['pyear'] === '2014' && $student['yop1'] === '2016');
check('the physically challenged field maps to pchal', $student['pchal'] === 'no');
check('missing fields are empty', $student['mname'] === '');

check('an insert has a placeholder per column', buildInsertSql('t', ['a', 'b']) === 'INSERT INTO `t` (`a`, `b`) VALUES (?, ?)');
check('an update sets every column and selects by id', buildUpdateSql('t', ['a', 'b'], 'id') === 'UPDATE `t` SET `a`=?, `b`=? WHERE `id`=?');
check('the insert for students has as many marks as fields', substr_count(buildInsertSql('registration', array_keys(STUDENT_FIELDS)), '?') === count(STUDENT_FIELDS));
