<?php
if(!isset($connect)) {
    include './sqlconn.php';
}

if (isset($_POST["profileid"], $_POST["tripid"])) {
    $stmt = "INSERT INTO BOOKINGS (ProfileID, TripID) VALUES (:profileid, :tripid)";
    // Prepare statement
    $query = oci_parse($connect, $stmt);
    // Bind variables to placeholders
    // json_decode for numerical type, otherwise refrain from json_decode for varchar/non-numerical type
    oci_bind_by_name($query, ":profileid", json_decode($_POST["profileid"]));
    oci_bind_by_name($query, ":tripid", json_decode($_POST["tripid"]));

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
