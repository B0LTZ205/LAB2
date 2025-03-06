<?php
include "Config/dbconfig.php";
$query = "SELECT * FROM customers";
$stmt = $conn->prepare($query);
$stmt->execute();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <title>Data Table</title>
    </head>
    <body>
        <div class="container mt-3">
            <table class="table table-stripped text-center mt-3">
            <thead>                <tr>
                    <th>CUSTOMER_ID</th>
                    <th>STORE_ID</th>
                    <th>FIRST_NAME</th>
                    <th>LAST_NAME</th>
                    <th>EMAIL</th>
                    <th>ADDRESS</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                echo "<tr>";
                    echo"<td>{$CUSTOMER_ID}</td>";
                    echo"<td>{$STORE_ID}</td>";
                    echo"<td>{$FIRST_NAME}</td>";
                    echo"<td>{$LAST_NAME}</td>";
                    echo"<td>{$EMAIL}</td>";
                    echo"<td>{$ADDRESS}</td>";
                    echo"<td> 
                    <div class='d-flex justify-content-center'>
                    <button class='btn btn-primary btn-sm ms-1' onclick='readCustomer($CUSTOMER_ID)'>Read</button>";
                    echo "<a href='#' onclick='delete_user({$CUSTOMER_ID});' class='btn btn-danger btn-sm ms-1'>Delete</a>";
                    echo "<a href='Edit.php?id={$CUSTOMER_ID}' class='btn btn-warning btn-sm ms-1'>Edit</a>";
                    echo "</div>";
                    echo "</td>";
                echo "</tr>";
                }?>
            </tbody>
        </table>
    </div>

    <!-- read Customer Modal -->
 <div class="modal fade" id="readCustomerModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Customer Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>


        </div>
        <div class="modal-body" id="customerDetails">
            Loading...

        </div>
      </div>
    </div>
 </div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/FetchCustomerDetails.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/datatables.min.js"></script>
        <script> 
        $(document).ready(function() {
            $('table').DataTable({
                order: [0, 'desc'],
                initComplete: function() {
                    // Add the button directly after the search input within the filter div
                    $('.dataTables_filter').append('<a href="create.php" class="btn btn-success ms-3">Add Customer Info</a>');
                }
            });
        });
        </script>
          <script>
    function delete_user(CustomerID){
      var answer = confirm("Are you sure you want to delete customer " + CustomerID + "?");
      if (answer) {
        window.location.href = 'delete.php?id='+CustomerID;
      } else {
        // Do nothing!
      }
    }
  </script>
</body>
</html>