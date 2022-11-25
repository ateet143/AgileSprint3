<?php
// Team      : ALE (Atit, Ellena, Low)
// Date      : Oct 2022
?>
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect user to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<?php
include_once('include/db_connect_acme_pdo.php');

// Proces delete operation after confirmation
if (isset($_POST["Email"]) && !empty($_POST["Email"])) {
    $email = $_POST["Email"];

    try {
        $sql = "DELETE FROM Member WHERE Email=?";
        if ($stmt = $pdo->prepare($sql)) {
            if ($stmt->execute([$email])) {
                // Record deleted successfully. Redirect to landing page
                header("location: MemberTable.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        unset($stmt);
    } catch (PDOException $e) {
        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
    }
    include_once('include/db_close_pdo.php');
} else {
    if (empty(trim($_GET["Email"]))) {
        //Redirect to landing page					
        header("location: MemberTable.php");
        exit();
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Low Kok Wei">    
        <title>Delete Member</title>

        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">        
        <!-- Custom styles for this template -->
        <link href="navbar-top-fixed.css" rel="stylesheet">
    </head>

    <body>    		    
        <?php
        include_once('include/navbar.php');
        include_once('include/db_connect_acme_pdo.php');
        ?>
        <main class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="mt-5 mb-3">Delete Member</h2>                    
                        <!-- Avoid PHP_SELF exploit -->
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="alert alert-danger">
								<!-- Display which member we are about to delete in a readonly field. -->
                                <input type="text" readonly name="Email" value="<?php echo trim($_GET["Email"]); ?>"/>
                                <p>Are you sure you want to delete this member record?</p>
                                <p>
                                    <input type="submit" value="Yes" class="btn btn-danger">
                                    <!-- "No" button to redirect to landing page -->
                                    <a href="MemberTable.php" class="btn btn-secondary">No</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>        
            </div>    
        </main> 
        <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>  
    </body>
</html>