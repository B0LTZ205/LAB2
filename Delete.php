<?php

try{
    include "Config/dbconfig.php";

    $id = isset($_GET['id'])? $_GET['id'] :  die("ERROR: record ID not found.");

    //delete query
    $query = "DELETE FROM customers WHERE CUSTOMER_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindparam(1, $id);

    if ($stmt->execute()){
        header("location: Index.php");
    }

    
}

catch(PDOException $e) {
    echo "ERROR: ". $e->getMessage();
}



?>