<?php
if(!isset($connect)) {
    include './sqlconn.php';
}

if (isset($_POST["id"], $_POST["profileid"], $_POST["tripid"], $_POST["receiptno"])) {

    $stmt = "UPDATE BOOKINGS
              SET PROFILEID = :profileid,
                  TRIPID = :tripid,
                  RECEIPTNO = :receiptno
              WHERE RECEIPTNO = :id";

    // Prepare statement
    $query = oci_parse($connect, $stmt);
    // Bind variables to placeholders
    // json_decode for numerical type, otherwise refrain from json_decode for varchar/non-numerical type
    oci_bind_by_name($query, ":profileid", json_decode($_POST["profileid"]));
    oci_bind_by_name($query, ":tripid", json_decode($_POST["tripid"]));
    oci_bind_by_name($query, ":receiptno", $_POST["receiptno"];);
    oci_bind_by_name($query, ":id", json_decode($_POST["id"]);

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
