<?php
// set page header
$page_title = "View Contacts";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// set number of records per page
$records_per_page = 10;
 
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/contact.php';
 
// instantiate database and objects
$database = new Database();
$db = $database->getConnection();
 
$contact = new Contact($db);
 
// query products
$stmt = $contact->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();
include_once "header.php";
 
echo "<div class='right-button-margin'>";
    echo "<a href='create_contact.php' class='btn btn-success pull-right'>Create Contact</a>";
echo "</div><br><br>";

// display the products if there are any
if($num>0){
 
    echo "<table id='example' class='table table-hover table-responsive table-bordered'>";
        echo " <thead>";
        echo "<tr>";
            echo "<th>First Name</th>";
            echo "<th>Surname</th>";
            echo "<th>Birth Date</th>";
            echo "<th>Cellphone Number</th>";
            echo "<th>Email Address</th>";
            echo "<th>Date Captured</th>";
            echo "<th>Actions</th>";
            echo"<tbody>";
        echo "</tr>";
        echo " </thead>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
            extract($row);
 
            echo "<tr>";
                echo "<td>{$firstname}</td>";
                echo "<td>{$surname}</td>";
                echo "<td>{$birth_date}</td>";
                echo "<td>{$cellphone_number}</td>";
                echo "<td>{$email_address}</td>";
                echo "<td>{$created}</td>";
                echo "<td>";
                // read, edit and delete buttons
                echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>
                <span class='glyphicon glyphicon-list'></span> Read
                </a>
                <a href='update_contact.php?id={$id}' class='btn btn-info left-margin'>
                <span class='glyphicon glyphicon-edit'></span> Edit
                </a>
                <a delete-id='{$id}' class='btn btn-danger delete-object'>
                <span class='glyphicon glyphicon-remove'></span> Delete
                </a>";
                echo "</td>";
 
            echo "</tr>";
            echo"</tbody>";
        }
 
    echo "</table>";
 
    
}
 
// tell the user there are no contacts
else{
    echo "<div class='alert alert-info'>No contacts found.</div>";
}
 
// set page footer
include_once "footer.php";
