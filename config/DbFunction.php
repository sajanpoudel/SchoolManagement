<?php
require('Database.php');
class DbFunction
{
    /** The shared mysqli connection. */
    private function connection()
    {
        return Database::getInstance()->getConnection();
    }

    /** Shows a message to the user. The text is encoded so it cannot break out of the script. */
    private function alert($message)
    {
        echo '<script>alert(' . json_encode($message, JSON_HEX_TAG | JSON_HEX_AMP) . ')</script>';
    }

    /** Sends the browser to another page once the current output is done. */
    private function redirect($url)
    {
        echo '<script>window.location.href=' . json_encode($url, JSON_HEX_TAG | JSON_HEX_AMP) . '</script>';
    }

    /** Prepares a statement and stops with the MySQL error when the query is invalid. */
    private function prepare($query)
    {
        $mysqli = $this->connection();
        $stmt = $mysqli->prepare($query);
        if (false === $stmt) {
            trigger_error("Error in query: " . $mysqli->error, E_USER_ERROR);
        }
        return $stmt;
    }

    /**
     * Checks the login id and password of the admin.
     * On success it starts the session and redirects to add-course.php.
     */
    public function login($loginid, $password)
    {

        if (!ctype_alpha($loginid) || !ctype_alpha($password)) {

            $this->alert('Either LoginId or Password is Missing');

        } else {
            $query = "SELECT password FROM tbl_login where loginid=?";
            $stmt = $this->prepare($query);

            $stmt->bind_param('s', $loginid);
            $stmt->execute();
            $stmt->bind_result($storedPassword);
            $rs = $stmt->fetch();
            if (!$rs || !$this->passwordMatches($password, $storedPassword)) {
                $this->alert('Invalid Details');
                header('location:login.php');
            } else {

                // Only a successful login may start the admin session
                $_SESSION['login'] = $loginid;
                header('location:add-course.php');
                exit;
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

            $this->alert('Select Course Short Name');

        } elseif ($cfull == "") {

            $this->alert('Select Course Full Name');

        } else {


            $query = "insert into tbl_course(cshort,cfull,cdate)values(?,?,?)";
            $stmt = $this->prepare($query);

            $stmt->bind_param('sss', $cshort, $cfull, $cdate);
            $stmt->execute();
            $this->alert('Course Added Successfully');
        }
    }

    /** Returns every course as a mysqli result. */
    public function showCourse()
    {

        $mysqli = $this->connection();
        $query = "SELECT * FROM tbl_course ";
        $stmt = $mysqli->query($query);
        return $stmt;

    }

    /** Returns the course with the given id. */
    public function showCourse1($cid)
    {

        $stmt = $this->prepare("SELECT * FROM tbl_course where cid=?");
        $stmt->bind_param('s', $cid);
        $stmt->execute();
        return $stmt->get_result();

    }

    /** Returns every subject row as a mysqli result. */
    public function showSubject()
    {

        $mysqli = $this->connection();
        $query = "SELECT * FROM subject ";
        $stmt = $mysqli->query($query);
        return $stmt;

    }


    /** Returns every academic session. */
    public function showSession()
    {

        $mysqli = $this->connection();
        $query = "SELECT * FROM session  ";
        $stmt = $mysqli->query($query);
        return $stmt;

    }

    /** Returns the subject row with the given id. */
    public function showSubject1($sid)
    {

        $stmt = $this->prepare("SELECT * FROM subject where subid=?");
        $stmt->bind_param('s', $sid);
        $stmt->execute();
        return $stmt->get_result();

    }


    /** Inserts the three subjects of a course. */
    public function create_subject($cshort, $cfull, $sub1, $sub2, $sub3)
    {

        if ($cshort == "") {

            $this->alert('Select Course Short Name');

        } elseif ($cfull == "") {

            $this->alert('Select Course Full Name');

        } else {


            $query = "insert into subject(cshort,cfull,sub1,sub2,sub3)values(?,?,?,?,?)";
            $stmt = $this->prepare($query);

            $stmt->bind_param('sssss', $cshort, $cfull, $sub1, $sub2, $sub3);
            $stmt->execute();
            $this->alert('Subject Added Successfully');
        }
    }


    /** Returns the list of countries for the registration form. */
    public function showCountry()
    {

        $mysqli = $this->connection();
        $query = "SELECT * FROM countries ";
        $stmt = $mysqli->query($query);
        return $stmt;

    }
    /** Returns every registered student. */
    public function showStudents()
    {

        $mysqli = $this->connection();
        $query = "SELECT * FROM registration ";
        $stmt = $mysqli->query($query);
        return $stmt;

    }

    /** Returns the student with the given id. */
    public function showStudents1($id)
    {

        $stmt = $this->prepare("SELECT * FROM registration where id=?");
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


        $query = "INSERT INTO `registration` (`course`, `subject`, `fname`, `mname`, `lname`, `gender`, `gname`, `ocp`,
                     `income`, `category`, `pchal`, `nationality`, `mobno`, `emailid`, `country`, `state`, `dist`, 
					 `padd`, `cadd`, `board`, `board1`,`roll`,`roll1`,`pyear`,`yop1`,`sub`,`sub1`,`marks`,`marks1`,
					 `fmarks`,`fmarks1`,`session`,regno) 
                   VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $reg = rand();
        $stmt = $this->prepare($query);

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
        $this->alert("Successfully registered, your registration number is $reg");



    }


    /** Updates the names of a course and stamps the update date. */
    public function edit_course($cshort, $cfull, $udate, $id)
    {

        $query = "update tbl_course set cshort=?,cfull=? ,update_date=? where cid=?";
        $stmt = $this->prepare($query);
        $stmt->bind_param('sssi', $cshort, $cfull, $udate, $id);
        $stmt->execute();
        $this->alert('Course Updated Successfully');

    }


    /** Updates the three subjects of a course. */
    public function edit_subject($sub1, $sub2, $sub3, $udate, $id)
    {

        $query = "update subject set sub1=?,sub2=? ,sub3=?,update_date=? where subid=?";
        $stmt = $this->prepare($query);
        $stmt->bind_param('ssssi', $sub1, $sub2, $sub3, $udate, $id);
        $stmt->execute();
        $this->alert('Subject Updated Successfully');

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
        $query = "update registration set course=?,subject=?,fname=?,mname=?,lname=?,gender=?,gname=?,ocp=?
              , income=?,category=?,pchal=?,nationality=?,mobno=?,emailid=?,country=?,state=?,dist=?
         	 ,padd=?,cadd=?,board=?,roll=?,pyear=?,sub=?,marks=?,fmarks=?,board1=?,roll1=?,yop1=?,sub1=?
              ,marks1=?,fmarks1=? where id=?" ;
        $stmt = $this->prepare($query);

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

        if (false === $rc) {

            die('bind_param() failed: ' . htmlspecialchars($stmt->error));
        }
        $rc = $stmt->execute();

        if (false == $rc) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        } else {
            $this->alert('Successfully Updated');
        }

    }


    /** Deletes a course and sends the browser back to the course list. */
    public function del_course($id)
    {

        $query = "delete from tbl_course where cid=?";
        $stmt = $this->prepare($query);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $this->alert('Course has been deleted');
        $this->redirect('view-course.php');
    }

    /** Deletes a student record. */
    public function del_std($id)
    {

        $query = "delete from registration where id=?";
        $stmt = $this->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $this->alert('One record has been deleted');
        $this->redirect('view.php');

    }

    /** Deletes a subject row. */
    public function del_subject($id)
    {

        $query = "delete from subject where subid=?";
        $stmt = $this->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $this->alert('Subject has been deleted');
        $this->redirect('view-subject.php');
    }

}
