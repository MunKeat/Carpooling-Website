<?php
if(!isset($connect)) {
    include './sqlconn.php';
}

if (isset($_POST["id"], $_POST["platenum"], $_POST["profileid"], $_POST["model"], $_POST["seatsnum"])) {
    //json_decode for numerical type, otherwise refrain from json_decode for varchar/non-numerical type
    $id = $_POST["id"];
    $platenum = $_POST["platenum"];
    $profileid = json_decode($_POST["profileid"]);
    $model = $_POST["model"];
    $seatsnum = json_decode($_POST["seatsnum"]);

    $stmt = "UPDATE VEHICLE
              SET PLATENO = :platenum,
                  PROFILEID = :profileid,
                  MODEL = :model,
                  NUMOFSEATS = seatsnum
              WHERE PLATENO = :id";

    // Prepare statement
    $query = oci_parse($connect, $stmt);
    // Bind variables to placeholders
    // json_decode for numerical type, otherwise refrain from json_decode for varchar/non-numerical type
    oci_bind_by_name($query, ":platenum", $_POST["platenum"]);
    oci_bind_by_name($query, ":profileid", json_decode($_POST["profileid"]);
    oci_bind_by_name($query, ":model", $_POST["model"]);
    oci_bind_by_name($query, ":seatsnum", json_decode($_POST["seatsnum"]);
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

else if (isset($_POST["id"], $_POST["platenum"], $_POST["model"], $_POST["seatsnum"])) {

    $id = $_POST["id"];
    $platenum = $_POST["platenum"];
    $model = $_POST["model"];
    $seatsnum = json_decode($_POST["seatsnum"]);

    $query = "UPDATE VEHICLE
              SET PLATENO = ".$platenum.",
                  MODEL = ".$model.",
                  NUMOFSEATS = ".$seatsnum."
              WHERE PLATENO = ".$id;

    $result = oci_parse($connect, $query);
    $check = oci_execute($result, OCI_DEFAULT);

    if($check == true) {
      oci_commit($connect);
      echo $query;
    } else {
      //TODO
      echo $query;
    }

    oci_free_statement($result);

}
?>
