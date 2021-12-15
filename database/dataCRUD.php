<?php

class dataCRUD
{
    private $connection;

    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $martialstatus;
    protected $sqlQuery;
    protected $table_name = 'UserInfo';

    public function __construct($connection)
    {
        $this->connection = $connection;
    }


    public function createDataForm()
    {
        if (isset($_POST['submit'])) {
            $this->sqlQuery = "INSERT INTO " . $this->table_name . " 
        (firstname, lastname, email, phone, martialstatus) 
        VALUES (:firstname, :lastname, :email, :phone, :martialstatus);";
            $bindValues = $this->connection->prepare($this->sqlQuery);

            $this->firstname = ucwords(strtolower(htmlspecialchars(strtolower(strip_tags($_POST['firstname'])))));
            $this->lastname = ucwords(strtolower(htmlspecialchars(strtolower(strip_tags($_POST['lastname'])))));
            $this->email = htmlspecialchars(strip_tags($_POST['email']));
            $this->phone = htmlspecialchars(strip_tags($_POST['phone']));
            $this->martialstatus = ucwords(strtolower(htmlspecialchars(strip_tags($_POST['martialstatus']))));

            if (!$this->duplicateNameHandling($this->firstname, $this->lastname)) {
                $bindValues->bindParam(':firstname', $this->firstname);
                $bindValues->bindParam(':lastname', $this->lastname);
                $bindValues->bindParam(':email', $this->email);
                $bindValues->bindParam(':phone', $this->phone);
                $bindValues->bindParam(':martialstatus', $this->martialstatus);

                if ($bindValues->execute()) {
                    $this->sqlQuery = null;
                    header('Location: ?success=' . urlencode('true'));
                }
            } else {
                header('Location: ?error=' . urlencode('true'));
            }
        }
        $this->connection = null;
        return false;
    }

    public function createDataAPI()
    {
        $this->sqlQuery = "INSERT INTO " . $this->table_name . " 
        (firstname, lastname, email, phone, martialstatus) 
        VALUES (:firstname, :lastname, :email, :phone, :martialstatus);";
        $bindValues = $this->connection->prepare($this->sqlQuery);

        $this->firstname = ucwords(strtolower(htmlspecialchars(strip_tags($this->firstname))));
        $this->lastname = ucwords(strtolower(htmlspecialchars(strip_tags($this->lastname))));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->martialstatus = ucwords(strtolower(htmlspecialchars(strip_tags($this->martialstatus))));

        if (!$this->duplicateNameHandling($this->firstname, $this->lastname)) {
            $bindValues->bindParam(':firstname', $this->firstname);
            $bindValues->bindParam(':lastname', $this->lastname);
            $bindValues->bindParam(':email', $this->email);
            $bindValues->bindParam(':phone', $this->phone);
            $bindValues->bindParam(':martialstatus', $this->martialstatus);

            $this->sqlQuery = null;
            if ($bindValues->execute()) {
                return $this->connection->lastInsertId();
            }
        } else {
            return false;
        }
        return false;
    }


    public function getInfoId()
    {
        $this->sqlQuery = "SELECT id,firstname,lastname,email,phone,martialstatus FROM " . $this->table_name . "
        WHERE id = ? LIMIT 0,1";
        $bindValues = $this->connection->prepare($this->sqlQuery);
        $bindValues->bindParam(1, $this->id);
        $bindValues->execute();
        $row = $bindValues->fetch(PDO::FETCH_ASSOC);
        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->martialstatus = $row['martialstatus'];
        $this->sqlQuery = null;
    }

    public function duplicateNameHandling($fname, $lname)
    {
        $this->sqlQuery = "SELECT * FROM " . $this->table_name . " 
        WHERE firstname = '" . $fname . "' AND lastname = '" . $lname . "';";
        $rows = $this->connection->prepare($this->sqlQuery);
        $rows->execute();
        $rows = $rows->fetchColumn();
        $this->sqlQuery = null;
        if ($rows) {
            return true;
        } else {
            return false;
        }

    }
}