<?php 
session_start(); 
include_once('include/navbar.php');
include_once('include/db_connect_pdo.php');

if (isset($_POST['FfirstName']) && isset($_POST['FlastName'])
    && isset($_POST['FEmail']) && (isset($_POST['FcheckNewsLetter']) || isset($_POST['FcheckBreakingNews']))) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$FfirstName = validate($_POST['FfirstName']);
	$FlastName = validate($_POST['FlastName']);
	$FEmail = validate($_POST['FEmail']);
   

    (isset($_POST['FcheckNewsLetter'])) ? $FcheckNewsLetter = 1 :  $FcheckNewsLetter = 0;
    (isset($_POST['FcheckBreakingNews'])) ? $FcheckBreakingNews = 1 :  $FcheckBreakingNews = 0;


	$user_data = 'First Name='. $FfirstName. '&Last Name='. $FlastName. '&Email='. $FEmail;


	if (empty($FfirstName)) {
		header("Location: Subscribe.php?errorFirstName=First Name is required&$user_data");
	    exit();
	}else if(empty($FlastName)){
        header("Location: Subscribe.php?errorLastName=Last Name is required&$user_data");
	    exit();
	}
	else if(empty($FEmail)){
        header("Location: Subscribe.php?errorEmail=Email  is required&$user_data");
	    exit();
	}
    else if((empty($_POST['FcheckNewsLetter'])) && (empty($_POST['FcheckBreakingNews'])) ){
        header("Location: Subscribe.php?errorCheckBox=At Least choose one&$user_data");
	    exit();
	}

	else{

	    $sql = "SELECT * FROM Member WHERE Email='$FEmail' ";
        $result = $pdo->query($sql);

        if ($result->rowCount() > 0) {
			header("Location: Subscribe.php?errorEmail=The Email is taken try another&$user_data");
	        exit();
		}
        else{
            try {
                $sql = "INSERT INTO Member (FirstName, LastName, Email, MonthlyNewsletter, BreakingNews) VALUES (?,?,?,?,?)";
                if ($stmt = $pdo->prepare($sql)) {
                    if ($stmt->execute([$FfirstName, $FlastName, $FEmail, $FcheckNewsLetter, $FcheckBreakingNews])) {
                        // Records created successfully. Redirect to landing page
                        header("Location: Subscribe.php?success=Congratulation! $FfirstName You are Sucessfully Subscribed");
                        exit();
                    } else {
                        header("Location: Subscribe.php?error=unknown error occurred&$user_data");
                        exit();
                    }
                }
                unset($stmt);
            } catch (PDOException $e) {
                die("ERROR: Could not able to execute $sql. " . $e->getMessage());
            }
        }
	}
    include_once('include/db_close_pdo.php');
	
}else{
	header("Location: Subscribe.php");
	exit();
}