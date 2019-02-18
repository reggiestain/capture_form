<?php
// set page headers
$page_title = "Read One Contact";

// get ID of the contact to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/contact.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$contact = new Contact($db);
 
// set ID property of contact to be read
$contact->id = $id;
 
// read the details of contact to be read
$contact->readOne();

include_once "header.php";
 
// read contacts button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> view Contacts";
    echo "</a><br><br>";
echo "</div>";
// HTML table for displaying a contact details
echo "<table class='table table-hover table-responsive table-bordered'>";
 
    echo "<tr>";
        echo "<td>First Name</td>";
        echo "<td>{$contact->firstname}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Surname</td>";
        echo "<td>{$contact->surname}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Birth Date</td>";
        echo "<td>{$contact->birthdate}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Cellphone Number</td>";
        echo "<td>{$contact->mobile}</td>";
    echo "</tr>";
    
    echo "<tr>";
        echo "<td>Email Address</td>";
        echo "<td>{$contact->email}</td>";
    echo "</tr>";
    
    echo "<tr>";
        echo "<td>Created</td>";
        echo "<td>{$contact->created}</td>";
    echo "</tr>";
 
echo "</table>";
 
// set footer
include_once "footer.php";
