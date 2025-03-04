<?php

include "Config/dbconfig.php";
if (isset($_GET['id'])) {
    $CUSTOMER_ID = $_GET['id'];
    $query = "SELECT * FROM customers WHERE CUSTOMER_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(1, $CUSTOMER_ID, PDO::PARAM_INT);
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<p><strong>Address:</strong>". htmlspecialchars($row['FIRST_NAME'])."</p>";
        echo "<p><strong>City:</strong>". htmlspecialchars($row['LAST_NAME'])."</p>";
        echo "<p><strong>Postal Code:</strong>". htmlspecialchars($row['EMAIL'])."</p>";
        echo "<p><strong>Country:</strong>". htmlspecialchars($row['ADDRESS'])."</p>";
    }
    else {
        echo "<p class='text-danger'>Customer not found.</p>";
    }
}
else {
    echo "<p class='text-danger'>Invalid request.</p>";
}

?>