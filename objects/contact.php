<?php

class Contact {

    // database connection and table name
    private $conn;
    private $table_name = "individuals";
    // object properties
    public $id;
    public $firtname;
    public $surname;
    public $birthdate;
    public $mobile;
    public $email;
    public $timestamp;

    public function __construct($db) {
        $this->conn = $db;
    }

    // create contact
    function create() {

        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    firstname=:firstname, surname=:surname, 
                    birth_date=:birth_date, cellphone_number=:cellphone_number, 
                    email_address=:email_address, created=:created";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->firtname = htmlspecialchars(strip_tags($this->firtname));
        $this->surname = htmlspecialchars(strip_tags($this->surname));
        $this->birthdate = htmlspecialchars(strip_tags($this->birthdate));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));
        $this->email = htmlspecialchars(strip_tags($this->email));
        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');

        // bind values 
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":surname", $this->surname);
        $stmt->bindParam(":birth_date", $this->birthdate);
        $stmt->bindParam(":cellphone_number", $this->mobile);
        $stmt->bindParam(":email_address", $this->email);
        $stmt->bindParam(":created", $this->timestamp);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //read contact
    function readAll($from_record_num, $records_per_page) {

        $query = "SELECT
                id, firstname, surname, birth_date, cellphone_number, email_address, created
            FROM
                " . $this->table_name . "
            ORDER BY
                id ASC
            LIMIT
                {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // used for paging products
    public function countAll() {

        $query = "SELECT id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }

    function readOne() {

        $query = "SELECT
                firstname, surname, birth_date, cellphone_number, email_address, created
            FROM
                " . $this->table_name . "
            WHERE
                id = ?
            LIMIT
                0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->firstname = $row['firstname'];
        $this->surname = $row['surname'];
        $this->birthdate = $row['birth_date'];
        $this->mobile = $row['cellphone_number'];
        $this->email = $row['email_address'];
        $this->created = $row['created'];
    }

    function update() {

        $query = "UPDATE
                " . $this->table_name . "
            SET
                    firstname=:firstname, surname=:surname, 
                    birth_date=:birth_date, cellphone_number=:cellphone_number, 
                    email_address=:email_address
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->firtname = htmlspecialchars(strip_tags($this->firtname));
        $this->surname = htmlspecialchars(strip_tags($this->surname));
        $this->birthdate = htmlspecialchars(strip_tags($this->birthdate));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind parameters
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":surname", $this->surname);
        $stmt->bindParam(":birth_date", $this->birthdate);
        $stmt->bindParam(":cellphone_number", $this->mobile);
        $stmt->bindParam(":email_address", $this->email);
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // delete the contact
    function delete() {

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($result = $stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
