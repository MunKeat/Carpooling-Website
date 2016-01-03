<?php
if(!isset($connect)) {
    include './sqlconn.php';
}

if (isset($_POST["startloc"], $_POST["endloc"], $_POST["ridingcost"], $_POST["seatsavail"], $_POST["tripdate"], $_POST["triptime"], $_POST["plateno"])) {

    $stmt = "INSERT INTO (Start_Location, End_Location, Riding_Cost, Seats_Available, Trip_Date, PlateNo)
              VALUES (:departure, :destination, :cost, :seatavail, TO_DATE(:tripdate, 'DD-Mon-YY HH24:MI'), :plateno)";
    // Prepare statement
    $query = oci_parse($connect, $stmt);
    // Bind variables to placeholders
    // json_decode for numerical type, otherwise refrain from json_decode for varchar/non-numerical type
    oci_bind_by_name($query, ":departure", $_POST["startloc"]);
    oci_bind_by_name($query, ":destination", $_POST["endloc"]);
    oci_bind_by_name($query, ":cost", json_decode($_POST["ridingcost"]);
    oci_bind_by_name($query, ":seatavail", json_decode($_POST["seatsavail"]));
    oci_bind_by_name($query, ":tripdate", "'".$_POST["tripdate"]." ".$_POST["triptime"]."'");
    oci_bind_by_name($query, ":plateno", $_POST["plateno"]);

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
