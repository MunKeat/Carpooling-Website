<?php
if(!isset($connect)) {
    include './sqlconn.php';
}

if (isset($_POST["id"], $_POST["profileid"], $_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["password"], $_POST["postalcode"], $_POST["contactnum"], $_POST["dob"], $_POST["creditcardnum"], $_POST["csc"], $_POST["cardholder"], $_POST["acct"])) {

    $stmt = "UPDATE PROFILE
              SET PROFILEID = :profileid,
                  EMAIL = :email,
                  PASSWORD = :password,
                  FIRSTNAME = :firstname,
                  LASTNAME = :lastname,
                  POSTALCODE = :postalcode,
                  CONTACTNUM = :contactnum,
                  DATEOFBIRTH = :dob,
                  CREDITCARDNUM =  :creditnum,
                  CARDSECURITYCODE = :csc,
                  CARDHOLDERNAME = :cardholder,
                  ACCBALANCE = :acct,
                  ADMIN = :admin
              WHERE PROFILEID = :id";

    // Prepare statement
    $query = oci_parse($connect, $stmt);
    // Bind variables to placeholders
    // json_decode for numerical type, otherwise refrain from json_decode for varchar/non-numerical type
    oci_bind_by_name($query, ":profileid", json_decode($_POST["profileid"]));
    oci_bind_by_name($query, ":email", $_POST["email"]);
    oci_bind_by_name($query, ":password", $_POST["password"]);
    oci_bind_by_name($query, ":firstname", $_POST["firstname"]);
    oci_bind_by_name($query, ":lastname", $_POST["lastname"]);
    oci_bind_by_name($query, ":postalcode", json_decode($_POST["postalcode"]));
    oci_bind_by_name($query, ":contactnum", json_decode($_POST["contactnum"]));
    oci_bind_by_name($query, ":dob", $_POST["dob"]);
    oci_bind_by_name($query, ":creditnum", json_decode($_POST["creditcardnum"]));
    oci_bind_by_name($query, ":csc", json_decode($_POST["csc"]));
    oci_bind_by_name($query, ":cardholder", $_POST["cardholder"]);
    oci_bind_by_name($query, ":acct", json_decode($_POST["acct"]);
    oci_bind_by_name($query, ":admin", json_decode($_POST["admin"]));
    oci_bind_by_name($query, ":id", json_decode($_POST["id"]));


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
