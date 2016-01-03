<?php
include './php/libaries.php';
include './php/sqlconn.php';

if(isUserLoggedIn() == true) {
    redirectToHomePage();
}

// Execute php script if [Login] button is pressed
if(isset($_POST['login'])) {
    //Check that parameters exist
    if(!isset($_POST['username']) || !isset($_POST['password'])) {
        redirectToLoginPage();
    }

    // Find username and password
    $stmt = "SELECT PROFILEID, FIRSTNAME, ACCBALANCE, CREDITCARDNUM, ADMIN FROM PROFILE WHERE Email = :username AND password = :password";
    // Prepare statement
    $query = oci_parse($connect, $stmt);
    // Bind variables to placeholders
    oci_bind_by_name($query, ":username", $_POST['username'], 255);
    oci_bind_by_name($query, ":password", $_POST['password'], 255);

    // Check if query fails
    $result = oci_execute($query, OCI_NO_AUTO_COMMIT);
    if($result === false) {
        redirectToLoginPage();
        exit;
    } elseif ($row = oci_fetch_array($query)){
        // Initialize session variables
        initSessionVar($row);
        oci_free_statement($query);
        redirectToHomePage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="./foundation/css/foundation.css" />
    <link rel="stylesheet" href="./css/customise.css" />
</head>

<body>

<?php
include 'includes/navbar.php';
?>

<div class="large-12 center-vertically">
    <div class="large-3 large-offset-8 columns primary-background-translucent">
        <div class="large-12"><br></div>
        <form method="post" action="login.php">
            <input required type="text" name="username" placeholder="Username" />
            <input required type="password" name="password" placeholder="Password" />
            <input type="submit" name="login" class="large-12 tiny button" value="LOGIN" />
            <br>
            <small><a href="#" class="right">Forget username/password?</a></small>
            <br>
            <br>
            <a href="registration.php" class="large-4 tiny button right">REGISTER</a>
        </form>
    </div>
</div>

</body>

</html>
