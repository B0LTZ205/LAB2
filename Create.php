<?php
$msg = "";
$errors = [];

function sanitizeInput($data) {
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = trim($data);

  return $data;
}

function validateInput($data, $pattern) {
  return preg_match($pattern, $data);

}

// Define patterns
$pattern = [
  'FIRST_NAME' => '/^[a-zA-Z\s\,\#.\-]{1,100}$/',
  'LAST_NAME' => '/^[a-zA-Z\s\,\#.\-]{1,100}$/',
  'EMAIL' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
  'ADDRESS' => '/^[a-zA-Z0-9\s\,\#.\-]+$/',
];



if($_SERVER["REQUEST_METHOD"] == "POST")

{
  //echo "hi";
  $FIRST_NAME = sanitizeInput($_POST['FIRST_NAME']);
  $LAST_NAME = sanitizeInput($_POST['LAST_NAME']);
  $EMAIL = sanitizeInput($_POST['EMAIL']);
  $ADDRESS = sanitizeInput($_POST['ADDRESS']);




  // Validate input fields
if(!validateInput($FIRST_NAME, $pattern['FIRST_NAME'])) {
  $errors['FIRST_NAME'] = "Invalid FIRST_NAME (Letters, numbers, spaces, ',', '#' '.', '-').";
}

if(!validateInput($LAST_NAME, $pattern['LAST_NAME'])) {
  $errors['LAST_NAME'] = "Invalid LAST_NAME (Only alphabetic characters and spaces allowed Max 100 characters).";
}

if(!validateInput($EMAIL, $pattern['EMAIL'])) {
  $errors['EMAIL'] = "Invalid Email Address.";
}

if(!validateInput($ADDRESS, $pattern['ADDRESS'])) {
  $errors['ADDRESS'] = "Invalid Address (Letters, numbers, spaces, ',', '#', '.', '-' are allowed).";
}


// proceed if no errors
try {
if(empty($errors)) {
  
    // include database connection
    include'Config/dbconfig.php';

    // inset query
    $query = "INSERT INTO customers SET FIRST_NAME = ?, LAST_NAME = ?, EMAIL = ?, ADDRESS = ?";

    // prepare query for execution
    $stmt = $conn->prepare($query);

    // binding parameters
    $stmt->bindParam(1, $FIRST_NAME);
    $stmt->bindParam(2, $LAST_NAME);
    $stmt->bindParam(3, $EMAIL);
    $stmt->bindParam(4, $ADDRESS);
    // execute the query
    
    if($stmt->execute()){
      $msg = "<div class='alert alert-success'><strong>Record was saved</strong></div>";
    }

    else{
      $msg = "<div class='alert alert-danger'><strong>unable to save record</strong></div>";
    } 
  } 
}
  catch(PDOException $e)
  {
  echo "ERROR: ". $e->getMessage();
  }
}






  

?>



<!DOCTYPE html>
<html>
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>

        <div class="container mt-5 mb-5 d-flex justify-content-center">
          <div class="card w-50">
        <div class="card-body">
          <?php echo $msg; ?>
          <form action="#" method="POST">

            <!-- FIRST_NAME -->
            <div class="form-group mt-2">
                <label for="FIRST_NAME">First Name:</label>
                <input type="text" class="form-control" name="FIRST_NAME" maxlength="100">
                <span class="text-danger"><?php echo $errors['FIRST_NAME']?? '';?></span>
            </div>

            <!-- LAST_NAME -->
            <div class="form-group mt-2">
                <label for="LAST_NAME">Last Name:</label>
                <input type="text" class="form-control" name="LAST_NAME" maxlength="100">
                <span class="text-danger"><?php echo $errors['LAST_NAME']?? '';?></span>
            </div>

            <!-- Email -->
             <div class="form-group mt-2">
                <label for="EMAIL">Email:</label>
                <input type="email" class="form-control" name="EMAIL" maxlength="255">
                <span class="text-danger"><?php echo $errors['EMAIL']?? '';?></span>
                <small class="form-text text-muted">Example: john.doe@example.com</small>
            </div>

            <!-- Address -->
            <div class="form-group mt-2">
                <label for="ADDRESS">Address:</label>
                <input type="text" class="form-control" name="ADDRESS" maxlength="255">
                <span class="text-danger"><?php echo $errors['ADDRESS']?? '';?></span>
                <small class="form-text text-muted">Format example: 123 Main St, City, State ZIP</small>
            </div>

            <!-- Submit Button -->
            <div class="form-group mt-2 d-flex justify-content-center">
                <button class="btn btn-primary">Add</button>
                <a href="Index.php" class="btn btn-danger ms-3">Cancel</a>
            </div>

          </form>
        </div>

        </div>

    </body>
</html>


