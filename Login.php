<?php
// Team      : ALE (Atit, Ellena, Low)
// Developer : Low, Kok Wei
// Date      : Oct 2022
?>
<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to member deletion page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: MemberTable.php");
    exit;
}
  
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){					
		try{
			$pdo = new PDO ("mysql:host=localhost;dbname=acmeArtsDB",$username,$password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			session_start();
                            
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username;                            
                            
            // Redirect user to member deletion page
            header("location: MemberTable.php");
			
		} catch (PDOException $e) {			
			// Password is not valid, display a generic error message
			if ($e->getCode() == '1045')
				$login_err = "Invalid username or password.";	
			else
				die("ERROR: Could not able to execute " . $e->getMessage());			
		}			
        include_once('include/db_close_pdo.php');				      
    }
    
    // Close connection    	
	include_once('include/db_close_pdo.php');
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Low Kok Wei">    
        <title>Login</title>

        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">        
        <!-- Custom styles for this template -->
        <link href="navbar-top-fixed.css" rel="stylesheet">
    </head>

    <body>    		    
        <?php
        include_once('include/navbar.php');        
        ?>
		<main class="container">
			<div class="bg-light p-3 rounded">        
                <h2>Login</h2>
				<p>Please fill in your credentials to login.</p>

				<?php 
				if(!empty($login_err)){
					echo '<div class="alert alert-danger">' . $login_err . '</div>';
				}        
				?>

				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div class="form-group">
						<label>Username</label>
						<input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
						<span class="invalid-feedback"><?php echo $username_err; ?></span>
					</div>    
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
						<span class="invalid-feedback"><?php echo $password_err; ?></span>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Login">
					</div>					
				</form>            
			</div>
		</main>  
        <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>  
    </body>
</html>