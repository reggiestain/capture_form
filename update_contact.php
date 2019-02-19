<?php

// get ID of the contact to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/contact.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$contact = new Contact($db);
 
// set ID property of contact to be edited
$contact->id = $id;
 
// read the details of contact to be edited
$contact->readOne();

// set page header
$page_title = "Update Contact";
include_once "header.php";
 
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>View Contacts</a>";
echo "</div><br><br>"; 

// if the form was submitted
if($_POST){
 
    // set contact property values
    $contact->firstname = $_POST['firstname'];
    $contact->surname = $_POST['surname'];
    $contact->birthdate = $_POST['birth_date'];
    $contact->mobile = $_POST['cellphone_number'];
    $contact->email = $_POST['email_address'];
 
    // update the contact
    if($contact->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Contact was updated.";
        echo "</div>";
    }
 
    // if unable to update the contact, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update contact.";
        echo "</div>";
    }
}
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>First Name</td>
            <td><input type='text' name='firstname' value='<?php echo $contact->firstname; ?>' class='form-control'  required/></td>
        </tr>
 
        <tr>
            <td>Surname</td>
            <td><input type='text' name='surname' value='<?php echo $contact->surname; ?>' class='form-control'  required/></td>
        </tr>
 
        <tr>
            <td>Birth Date</td>
            <td>
             <div class="input-group date" data-provide="datepicker">
                    <input id="datepicker" type="text" name="birth_date" value='<?php echo $contact->birthdate; ?>' class="form-control"  required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" required>
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>                       
            </td>
        </tr>
 
        <tr>
            <td>Mobile Number</td>
            <td><input type='text' name='cellphone_number' value='<?php echo $contact->mobile; ?>' class='form-control' pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\ " required/></td>
        </tr>
        
        <tr>
            <td>Email Address</td>
            <td><input type='email' name='email_address' value='<?php echo $contact->email; ?>' class='form-control'  required/></td>
        </tr>
 
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
 
    </table>
</form>
<?php
// set page footer
include_once "footer.php";

