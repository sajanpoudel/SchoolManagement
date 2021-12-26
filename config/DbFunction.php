
<?php
require('Database.php');
//$db = Database::getInstance();
//$mysqli = $db->getConnection();
class DbFunction
{
    /**
     * Checks the login id and password of the admin.
     * On success it starts the session and redirects to add-course.php.
     */
    public function login($loginid, $password)
    {

        if (!ctype_alpha($loginid) || !ctype_alpha($password)) {

            echo "<script>alert('Either LoginId or Password is Missing')</script>";

        } else {
            $db = Database::getInstance();
            $mysqli = $db->getConnection();
            $query = "SELECT password FROM tbl_login where loginid=?";
            $stmt = $mysqli->prepare($query);
            if (false === $stmt) {

                trigger_error("Error in query: " . mysqli_connect_error(), E_USER_ERROR);
            } else {

                $stmt->bind_param('s', $loginid);
                $stmt->execute();
                $stmt->bind_result($storedPassword);
                $rs = $stmt->fetch();
                if (!$rs || !$this->passwordMatches($password, $storedPassword)) {
                    echo "<script>alert('Invalid Details')</script>";
                    header('location:login.php');
                } else {

                    // Only a successful login may start the admin session
                    $_SESSION['login'] = $loginid;
                    header('location:add-course.php');
                    exit;
                }
            }

        }

    }

    // Accepts bcrypt hashes and the plain text passwords already stored in tbl_login
    /** Compares a typed password with a stored bcrypt hash or plain text value. */
    private function passwordMatches($input, $stored)
    {
        if (strpos($stored, '$2y$') === 0) {
            return password_verify($input, $stored);
        }
        return hash_equals($stored, $input);
    }

    /** Inserts a new course after checking that both names were given. */
    public function create_course($cshort, $cfull, $cdate)
    {

        if ($cshort == "") {

            echo "<script>alert('Select  Course Short Name')</script>";

        } elseif ($cfull == "") {

            echo "<script>alert('Select  Course Full Name')</script>";

        } else {


            $db = Database::getInstance();
            $mysqli = $db->getConnection();
            $query = "insert into tbl_course(cshort,cfull,cdate)values(?,?,?)";
            $stmt = $mysqli->prepare($query);
            if (false === $stmt) {

                trigger_error("Error in query: " . mysqli_connect_error(), E_USER_ERROR);
            } else {

                $stmt->bind_param('sss', $cshort, $cfull, $cdate);
                $stmt->execute();
                echo "<script>alert('Course Added Successfully')</script>";
                //header('location:login.php');

            }
        }
    }

    /** Returns every course as a mysqli result. */
    public function showCourse()
    {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $query = "SELECT * FROM tbl_course ";
        $stmt = $mysqli->query($query);
        return $stmt;

    }

    /** Returns the course with the given id. */
    public function showCourse1($cid)
    {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $stmt = $mysqli->prepare("SELECT * FROM tbl_course where cid=?");
        $stmt->bind_param('s', $cid);
        $stmt->execute();
        return $stmt->get_result();

    }

    /** Returns every subject row as a mysqli result. */
    public function showSubject()
    {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $query = "SELECT * FROM subject ";
        $stmt = $mysqli->query($query);
        return $stmt;

    }


    /** Returns every academic session. */
    public function showSession()
    {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $query = "SELECT * FROM session  ";
        $stmt = $mysqli->query($query);
        return $stmt;

    }

    /** Returns the subject row with the given id. */
    public function showSubject1($sid)
    {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $stmt = $mysqli->prepare("SELECT * FROM subject where subid=?");
        $stmt->bind_param('s', $sid);
        $stmt->execute();
        return $stmt->get_result();

    }


    /** Inserts the three subjects of a course. */
    public function create_subject($cshort, $cfull, $sub1, $sub2, $sub3)
    {

        if ($cshort == "") {

            echo "<script>alert('Select  Course Short Name')</script>";

        } elseif ($cfull == "") {

            echo "<script>alert('Select  Course Full Name')</script>";

        } else {


            $db = Database::getInstance();
            $mysqli = $db->getConnection();
            $query = "insert into subject(cshort,cfull,sub1,sub2,sub3)values(?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            if (false === $stmt) {

                trigger_error("Error in query: " . mysqli_connect_error(), E_USER_ERROR);
            } else {

                $stmt->bind_param('sssss', $cshort, $cfull, $sub1, $sub2, $sub3);
                $stmt->execute();
                echo "<script>alert('Course Added Successfully')</script>";


            }
        }
    }


    /** Returns the list of countries for the registration form. */
    public function showCountry()
    {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $query = "SELECT * FROM countries ";
        $stmt = $mysqli->query($query);
        return $stmt;

    }
    /** Returns every registered student. */
    public function showStudents()
    {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $query = "SELECT * FROM registration ";
        $stmt = $mysqli->query($query);
        return $stmt;

    }

    /** Returns the student with the given id. */
    public function showStudents1($id)
    {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $stmt = $mysqli->prepare("SELECT * FROM registration where id=?");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        return $stmt->get_result();

    }

    /** Saves a new student registration and shows the generated registration number. */
    public function register(
        $cshort,
        $cfull,
        $fname,
        $mname,
        $lname,
        $gender,
        $gname,
        $ocp,
        $income,
        $category,
        $ph,
        $nation,
        $mobno,
        $email,
        $country,
        $state,
        $city,
        $padd,
        $cadd,
        $board1,
        $board2,
        $roll1,
        $roll2,
        $pyear1,
        $pyear2,
        $sub1,
        $sub2,
        $marks1,
        $marks2,
        $fmarks1,
        $fmarks2,
        $session
    ) {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();

        //	echo $session;exit;
        $query = "INSERT INTO `registration` (`course`, `subject`, `fname`, `mname`, `lname`, `gender`, `gname`, `ocp`,
                     `income`, `category`, `pchal`, `nationality`, `mobno`, `emailid`, `country`, `state`, `dist`, 
					 `padd`, `cadd`, `board`, `board1`,`roll`,`roll1`,`pyear`,`yop1`,`sub`,`sub1`,`marks`,`marks1`,
					 `fmarks`,`fmarks1`,`session`,regno) 
                   VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $reg = rand();
        $stmt = $mysqli->prepare($query);
        if (false === $stmt) {

            trigger_error("Error in query: " . mysqli_connect_error(), E_USER_ERROR);
        } else {

            $stmt->bind_param(
                'sssssssssssssssssssssssssssssssss',
                $cshort,
                $cfull,
                $fname,
                $mname,
                $lname,
                $gender,
                $gname,
                $ocp,
                $income,
                $category,
                $ph,
                $nation,
                $mobno,
                $email,
                $country,
                $state,
                $city,
                $padd,
                $cadd,
                $board1,
                $board2,
                $roll1,
                $roll2,
                $pyear1,
                $pyear2,
                $sub1,
                $sub2,
                $marks1,
                $marks2,
                $fmarks1,
                $fmarks2,
                $session,
                $reg
            );
            $stmt->execute();
            echo "<script>alert('Successfully Registered , your registration number is $reg')</script>";
            //header('location:login.php');

        }



    }


    /** Updates the names of a course and stamps the update date. */
    public function edit_course($cshort, $cfull, $udate, $id)
    {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        //echo $cshort.$cfull.$udate.$id;exit;
        $query = "update tbl_course set cshort=?,cfull=? ,update_date=? where cid=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sssi', $cshort, $cfull, $udate, $id);
        $stmt->execute();
        echo '<script>';
        echo 'alert("Course Updated Successfully")';
        echo '</script>';

    }


    /** Updates the three subjects of a course. */
    public function edit_subject($sub1, $sub2, $sub3, $udate, $id)
    {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $query = "update subject set sub1=?,sub2=? ,sub3=?,update_date=? where subid=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ssssi', $sub1, $sub2, $sub3, $udate, $id);
        $stmt->execute();
        echo '<script>';
        echo 'alert("Subject Updated Successfully")';
        echo '</script>';

    }

    /** Updates every field of a student record. */
    public function edit_std(
        $cshort,
        $cfull,
        $fname,
        $mname,
        $lname,
        $gender,
        $gname,
        $ocp,
        $income,
        $category,
        $ph,
        $nation,
        $mobno,
        $email,
        $country,
        $state,
        $city,
        $padd,
        $cadd,
        $board1,
        $board2,
        $roll1,
        $roll2,
        $pyear1,
        $pyear2,
        $sub1,
        $sub2,
        $marks1,
        $marks2,
        $fmarks1,
        $fmarks2,
        $id
    ) {
        // echo $id;exit;
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $query = "update registration set course=?,subject=?,fname=?,mname=?,lname=?,gender=?,gname=?,ocp=?
              , income=?,category=?,pchal=?,nationality=?,mobno=?,emailid=?,country=?,state=?,dist=?
         	 ,padd=?,cadd=?,board=?,roll=?,pyear=?,sub=?,marks=?,fmarks=?,board1=?,roll1=?,yop1=?,sub1=?
              ,marks1=?,fmarks1=? where id=?" ;
        //echo $query;
        $stmt = $mysqli->prepare($query);
        if (false === $stmt) {

            trigger_error("Error in query: " . mysqli_connect_error(), E_USER_ERROR);
        }

        $rc = $stmt->bind_param(
            'sssssssssssssssssssssssssssssssi',
            $cshort,
            $cfull,
            $fname,
            $mname,
            $lname,
            $gender,
            $gname,
            $ocp,
            $income,
            $category,
            $ph,
            $nation,
            $mobno,
            $email,
            $country,
            $state,
            $city,
            $padd,
            $cadd,
            $board1,
            $board2,
            $roll1,
            $roll2,
            $pyear1,
            $pyear2,
            $sub1,
            $sub2,
            $marks1,
            $marks2,
            $fmarks1,
            $fmarks2,
            $id
        );

        //echo $rc;
        if (false === $rc) {

            die('bind_param() failed: ' . htmlspecialchars($stmt->error));
        }
        $rc = $stmt->execute();

        if (false == $rc) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        } else {
            echo '<script>';
            echo 'alert(" Successfully Updated")';
            echo '</script>';
        }

    }


    /** Deletes a course and sends the browser back to the course list. */
    public function del_course($id)
    {

        //  echo $id;exit;
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $query = "delete from tbl_course where cid=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        echo "<script>alert('Course has been deleted')</script>";
        echo "<script>window.location.href='view-course.php'</script>";
    }

    /** Deletes a student record. */
    public function del_std($id)
    {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $query = "delete from registration where id=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        echo "<script>alert('One record has been deleted')</script>";
        echo "<script>window.location.href='view-course.php'</script>";

    }

    /** Deletes a subject row. */
    public function del_subject($id)
    {

        //echo $id;exit;
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $query = "delete from subject where subid=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        echo "<script>alert('Subject has been deleted')</script>";
        // echo "<script>window.location.href='view-course.php'</script>";
    }

}

?>



