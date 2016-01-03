<?php
if(!isset($connect)) {
    include './sqlconn.php';
}

  if (isset($_POST["id"], $_POST["tripid"], $_POST["startloc"], $_POST["endloc"], $_POST["ridingcost"], $_POST["seatsavail"], $_POST["tripdate"], $_POST["triptime"], $_POST["plateno"])) {
    //json_decode for numerical type, otherwise refrain from json_decode for varchar/non-numerical type
    $id = json_decode($_POST["id"]);
    $tripid = json_decode($_POST["tripid"]);
    $startloc = $_POST["startloc"];
    $endloc = $_POST["endloc"];
    $ridingcost = json_decode($_POST["ridingcost"]);
    $seatsavail = json_decode($_POST["seatsavail"]);
    $tripdate = "'".$_POST["tripdate"]." ".$_POST["triptime"]."'";
    $plateno = $_POST["plateno"];

    $stmt = "UPDATE TRIPS
              SET TRIPNO = :tripid,
                  START_LOCATION = :departure,
                  END_LOCATION = :destination,
                  RIDING_COST = :cost,
                  SEATS_AVAILABLE = :seatsavail,
                  TRIP_DATE = TO_DATE(:tripdate, 'DD-Mon-YY HH24:MI'),
                  PLATENO = :plateno
              WHERE TRIPNO = :id";
    // Prepare statement
    $query = oci_parse($connect, $stmt);
    // Bind variables to placeholders
    // json_decode for numerical type, otherwise refrain from json_decode for varchar/non-numerical type
    oci_bind_by_name($query, ":tripid", json_decode($_POST["tripid"]));
    oci_bind_by_name($query, ":departure", $_POST["startloc"]);
    oci_bind_by_name($query, ":destination", $_POST["endloc"]);
    oci_bind_by_name($query, ":cost", json_decode($_POST["ridingcost"]);
    oci_bind_by_name($query, ":seatavail", json_decode($_POST["seatsavail"]));
    oci_bind_by_name($query, ":tripdate", "'".$_POST["tripdate"]." ".$_POST["triptime"]."'");
    oci_bind_by_name($query, ":plateno", $_POST["plateno"]);
    oci_bind_by_name($query, ":departure", $_POST["startloc"]);
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
