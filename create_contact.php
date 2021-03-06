<?php
// set page headers
$page_title = "Create Contact";

// include database and object files
include_once 'config/database.php';
include_once 'objects/contact.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// pass connection to objects
$contact = new Contact($db);

include_once "header.php";

echo "<div class='right-button-margin'>";
echo "<a href='index.php' class='btn btn-success pull-right'>View Contacts</a>";
echo "</div><br><br>";
?>

<?php
// if the form was submitted 
if ($_POST) {
    // set contact property values
    $contact->firstname = $_POST['firstname'];
    $contact->surname = $_POST['surname'];
    $contact->birthdate = $_POST['birth_date'];
    $contact->mobile = $_POST['cellphone_number'];
    $contact->email = $_POST['email_address'];
    
    //Check if email exist
    if ($contact->emailExists()) 
        echo "<div class='alert alert-danger'>The email address has been taken, please enter a different email.</div>";        
    else
    // create the contact
    if ($contact->create())
        echo "<div class='alert alert-success'>Contact was created.</div>";

    // if unable to create the contact, tell the user
    else 
        echo "<div class='alert alert-danger'>Unable to create contact.</div>";
}
?>

<!-- HTML form for creating a contact -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <table class='table table-hover table-responsive table-bordered'>

        <tr>
            <td>First Name</td>
            <td><input type='text' name='firstname' class='form-control'  required/></td>
        </tr>

        <tr>
            <td>Surname</td>
            <td><input type='text' name='surname' class='form-control'  required/></td>
        </tr>

        <tr>
            <td>Birth Date</td>
            <td>
                <div class="input-group date" data-provide="datepicker">
                    <input id="datepicker" type="text" name="birth_date" class="form-control" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" >
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>    
            </td>
        </tr>

        <tr>
            <td>Mobile Number</td>
            <td><input type='text' name='cellphone_number' class='form-control'  pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\ " required/></td>
        </tr>

        <tr>
            <td>Email Address</td>
            <td><input type='email' name='email_address' class='form-control'  required/></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>

    </table>
</form>

<?php
// footer
include_once "footer.php";
