<?php
include './php/libaries.php';
include './php/sqlconn.php'; // Connect to database

$resultMsg = "";

if(isset($_POST['makePayment'])) {
    //Check that parameters exist
    if(!isset($_POST['topUpAmount'])) {
        exit;
    }

    $topUpAmount = floatval($_POST['topUpAmount']);
    $userID = getProfileID();

    //================================================================
    //Create a pop-out message to double-check amount:
    //$msg = "Amount to top-up is ".$topUpAmount." ProfileID is ".$_SESSION["profileID"];
    //echo "<script type='text/javascript'>alert('$msg');</script>";
    //================================================================
    $stmt = "UPDATE PROFILE SET ACCBALANCE = ACCBALANCE + :topup WHERE PROFILEID = :userid";
    // Prepare statement
    $query = oci_parse($connect, $stmt);
    // Bind variables to placeholders
    oci_bind_by_name($query, ":topup", $topUpAmount);
    oci_bind_by_name($query, ":userid", $userID);

    // Check if query fails
    $result = oci_execute($query, OCI_NO_AUTO_COMMIT);
    if($result === false) {
        $resultMsg = "Your top up failed. Please try again";
        exit;
    } else {
        oci_commit($connect);
    }

    oci_free_statement($query);


    // Find the updated Account Balance
    $stmt = "SELECT ACCBALANCE FROM PROFILE WHERE PROFILEID = :userid";
    // Prepare statement
    $query = oci_parse($connect, $stmt);
    // Bind variables to placeholders
    oci_bind_by_name($query, ":userid", $userID);

    // Check if query fails
    $result = oci_execute($query, OCI_NO_AUTO_COMMIT);

    if($result === false) {
        $resultMsg = "Your top up failed. Please try again";
        exit;
    } elseif ($row = oci_fetch_array($query)) {
        $_SESSION["profileAccountBalance"] = $row["ACCBALANCE"];
        $resultMsg = "You have successfully top-up";
    }

    oci_free_statement($query);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link rel="stylesheet" href="./foundation/css/foundation.css" />
    <link rel="stylesheet" href="./css/customise.css" />
</head>
<body>

    <?php
    include 'includes/navbar.php';
    ?>

    <div class="large-12 center-vertically columns">
        <form method="post" action="payment.php">
            <div class="row">
                <div class="large-6 large-offset-3 columns text-center white-translucent">
                    <h2>Your Account Balance:</h2>
                    <p id="userCurrency">
                        <?php getProfileAccountBalance() ?>
                    </p>
                    <label id="topUpAmount">
                        <select required name = "topUpAmount" class="text-center">
                            <option class="placeholder" selected="selected" value= "" disabled="disabled">Select amount of credits to add</option>
                            <option value="5">+ SGD 5.00</option>
                            <option value="10">+ SGD 10.00</option>
                            <option value="15">+ SGD 15.00</option>
                            <option value="20">+ SGD 20.00</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-6 large-offset-3 columns white-translucent">
                    <input type="submit" name="makePayment" class="large-12 small button" value="DEDUCT FROM CREDITCARD" />
                    <h5><?php echo $resultMsg ?></h5>
                </div>

            </div>
        </form>
    </div>
</body>
</html>
