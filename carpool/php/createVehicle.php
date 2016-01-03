<?php
if(!isset($connect)) {
    include './sqlconn.php';
}

if (isset($_POST["platenum"], $_POST["profileid"], $_POST["model"], $_POST["seatsnum"])) {

    $stmt = "INSERT INTO VEHICLE (PlateNo, ProfileID, Model, NumOfSeats)
            VALUES (:platenum, :profileid, :model, :seatsnum)";
    // Prepare statement
    $query = oci_parse($connect, $stmt);
    // Bind variables to placeholders
    // json_decode for numerical type, otherwise refrain from json_decode for varchar/non-numerical type
    oci_bind_by_name($query, ":platenum", $_POST["platenum"]);
    oci_bind_by_name($query, ":profileid", json_decode($_POST["profileid"]);
    oci_bind_by_name($query, ":model", $_POST["model"]);
    oci_bind_by_name($query, ":seatsnum", json_decode($_POST["seatsnum"]);

    // Check if query fails
    $result = oci_execute($query, OCI_NO_AUTO_COMMIT);
    if($result === true) {
        oci_commit($connect);
    } else {
        //TODO
        echo $query;
    }

    oci_free_statement($query);
    exit;
}
?>
