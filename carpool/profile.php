<?php

include './php/libaries.php';
include './php/sqlconn.php'; // Connect to database

if(isUserLoggedIn() == false) {
    redirectToLoginPage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="./foundation/css/foundation.css" />
    <link rel="stylesheet" href="./css/customise.css" />

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script src="js/profile.js"></script>
</head>
<body>

<?php
include 'includes/navbar.php';
?>

<div class="large-12 columns ">
    <div class="large-8 large-offset-2 columns">

        <div class="row collapse">
            <div class="username large-12 columns">
                <h2 class="white-font"><?php getProfileName() ?></h2>
            </div>
        </div>

        <!--Query user's car-->
        <div class="row collapse">
            <table class="large-12 columns">
            <caption class="white-font"><b>Your Car(s)</b></caption>
                <tr>
                    <th>Car Plate Number</th>
                    <th>Model</th>
                    <th>Seats Available</th>
                    <th>Actions</th>
                </tr>
                <?php
                $userID = getProfileID();

                // Get detail relating to the user's car
                $stmt = "SELECT PLATENO, MODEL, NUMOFSEATS FROM VEHICLE WHERE PROFILEID = :userid";
                // Prepare statement
                $query = oci_parse($connect, $stmt);
                // Bind variables to placeholders (OCI_B_INT sepcifies that only integers allowed)
                oci_bind_by_name($query, ":userid", $userID, -1, OCI_B_INT);

                $result = oci_execute($query, OCI_NO_AUTO_COMMIT);
                if($result === true) {
                    while($row = oci_fetch_array($query)) {
                        echo'<tr>
                                <td class="plateno">'.$row['PLATENO'].'</td>
                                <td class="model">'.$row['MODEL'].'</td>
                                <td class="numofseats">'.$row['NUMOFSEATS'].'</td>
                                <td><a title="Edit" class="ui-icon ui-icon-pencil editVehicleButton"></a></td>
                                <td><a title="Delete" class="ui-icon ui-icon-trash delVehicleButton"></a></td>
                            </tr>';
                    }
                }
                //Print an add button for users to add new vehicle(s)
                echo'<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><a title="Add" class="ui-icon ui-icon-plus createVehicleButton"></a></td>
                    <td></td>
                </tr>';

                oci_free_statement($query);

                ?>
            </table>
        </div>

        <div class="row collapse">
            <!--Query user's pending passengers-->
            <table class="large-12 columns">
            <caption class="white-font"><b>Pending: Your Passenger(s)</b></caption>
                <tr>
                    <th>Passenger(s)</th>
                    <th>Contact</th>
                    <th>Plate Number</th>
                    <th>Model</th>
                    <th>Departure</th>
                    <th>Destination</th>
                    <th>Departure Time</th>
                </tr>
                <?php
                // Get user's pending passengers
                $stmt = "SELECT PASSENGER, PASSENGER_CONTACT,PLATENO, MODEL, DEPARTURE, DESTINATION, TRIP_DATE, TRIP_TIME
                        FROM PENDINGRIDE WHERE DRIVER_ID= :userid AND TRIP_DATE >=(SYSDATE)";
                // Prepare statement
                $query = oci_parse($connect, $stmt);
                // Bind variables to placeholders
                oci_bind_by_name($query, ":userid", $userID, -1, OCI_B_INT);

                $result = oci_execute($query, OCI_NO_AUTO_COMMIT);
                if($result === true) {
                    while($row = oci_fetch_array($query)) {
                        echo'<tr>
                                <td>'.$row['PASSENGER'].'</td>
                                <td>'.$row['PASSENGER_CONTACT'].'</td>
                                <td>'.$row['PLATENO'].'</td>
                                <td>'.$row['MODEL'].'</td>
                                <td>'.$row['DEPARTURE'].'</td>
                                <td>'.$row['DESTINATION'].'</td>
                                <td>'.$row['TRIP_DATE'].', '.$row['TRIP_TIME'].'</td>
                            </tr>';
                    }
                }

                oci_free_statement($query);
                ?>
            </table>
        </div>

        <div class="row collapse">
            <!--Query user's pending ride-->
            <table class="large-12 columns">
            <caption class="white-font"><b>Pending: Your Rides(s)</b></caption>
                <tr>
                    <th>Driver</th>
                    <th>Contact</th>
                    <th>Plate Number</th>
                    <th>Model</th>
                    <th>Departure</th>
                    <th>Destination</th>
                    <th>Departure Time</th>
                </tr>

                <?php
                $stmt = "SELECT DRIVER, DRIVER_CONTACT, PLATENO, MODEL, DEPARTURE, DESTINATION, TRIP_DATE, TRIP_TIME
                            FROM PENDINGRIDE WHERE PASSENGER_ID= :userid AND TRIP_DATE >=(SYSDATE)";
                // Prepare statement
                $query = oci_parse($connect, $stmt);
                // Bind variables to placeholders
                oci_bind_by_name($query, ":userid", $userID, -1, OCI_B_INT);

                $result = oci_execute($query, OCI_NO_AUTO_COMMIT);
                if($result === true) {
                    while($row = oci_fetch_array($query)) {
                        echo'<tr>
                                <td>'.$row['DRIVER'].'</td>
                                <td>'.$row['DRIVER_CONTACT'].'</td>
                                <td>'.$row['PLATENO'].'</td>
                                <td>'.$row['MODEL'].'</td>
                                <td>'.$row['DEPARTURE'].'</td>
                                <td>'.$row['DESTINATION'].'</td>
                                <td>'.$row['TRIP_DATE'].', '.$row['TRIP_TIME'].'</td>
                            </tr>';
                    }
                }

                oci_free_statement($query);
                ?>
            </table>
        </div>
    </div>
</div>


<form id="editVehicleForm" >
    <label for="idplateno">Plate Number:</label>
    <input required type="text" name="platenum" id="idplateno">
    <label for="idmodel">Model:</label>
    <input required type="text" name="model" id="idmodel">
    <label for="idnumseats">No. Of Seats:</label>
    <input required type="text" name="numseats" id="idnumseats">
</form>

<div id="deleteVehicleForm">
    <div id="deleteVehicleText">
    </div>
</div>

</body>
</html>
