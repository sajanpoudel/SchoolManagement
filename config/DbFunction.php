<?php
require_once('Database.php');
require_once(__DIR__ . '/../src/Student.php');
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

                // Only a successful login may start the admin session, under a fresh session id
                session_regenerate_id(true);
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

    /** Number of rows in one of the tables the dashboard reports on. */
    public function countRows($table)
    {
        $allowed = ['registration', 'tbl_course', 'subject', 'session'];
        if (!in_array($table, $allowed, true)) {
            throw new InvalidArgumentException("Unknown table: $table");
        }
        $result = $this->connection()->query("SELECT COUNT(*) AS total FROM `$table`");
        $row = $result->fetch_assoc();
        return (int) $row['total'];
    }

    /** The students who registered most recently, newest first. */
    public function latestStudents($limit = 5)
    {
        $stmt = $this->prepare("SELECT id, regno, fname, lname, emailid, course FROM registration ORDER BY id DESC LIMIT ?");
        $stmt->bind_param('i', $limit);
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

    /**
     * Saves a new student registration and shows the generated registration number.
     * $student is the result of studentFromPost().
     */
    public function register(array $student, $session)
    {
        $columns = array_merge(array_keys($student), ['session', 'regno']);
        $reg = random_int(100000, 2147483647);
        $values = array_merge(array_values($student), [$session, $reg]);

        $stmt = $this->prepare(buildInsertSql('registration', $columns));
        $stmt->bind_param(str_repeat('s', count($values)), ...$values);
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

    /** Updates every field of a student record. $student is the result of studentFromPost(). */
    public function edit_std(array $student, $id)
    {
        $stmt = $this->prepare(buildUpdateSql('registration', array_keys($student), 'id'));
        $values = array_merge(array_values($student), [(int) $id]);
        $stmt->bind_param(str_repeat('s', count($student)) . 'i', ...$values);
        if (!$stmt->execute()) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $this->alert('Successfully Updated');
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
