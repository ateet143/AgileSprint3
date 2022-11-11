<?php 
session_start(); 
include_once('include/db_connect_pdo.php');

// If all the field in the form is filled and error free then execute this code
if (isset($_POST['FfirstName']) && isset($_POST['FlastName'])
    && isset($_POST['FEmail']) ) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$FfirstName = validate($_POST['FfirstName']);
	$FlastName = validate($_POST['FlastName']);
	$FEmail = validate($_POST['FEmail']);
   

    //if the checkbox has value then assign 1 otherwise 0
    (isset($_POST['FcheckNewsLetter'])) ? $FcheckNewsLetter = 1 :  $FcheckNewsLetter = 0;
    (isset($_POST['FcheckBreakingNews'])) ? $FcheckBreakingNews = 1 :  $FcheckBreakingNews = 0;

    // to assign the value in querystring
	$user_data = 'First Name='. $FfirstName. '&Last Name='. $FlastName. '&Email='. $FEmail;

    //if the first Name field is empty then send this error
	if (empty($FfirstName)) {
		header("Location: Subscribe.php?errorFirstName=First Name is required&$user_data");
	    exit();
    //Allows only letter and whitespace
	}else if (!preg_match("/^[a-zA-Z-' ]*$/",$FfirstName)) {
        header("Location: Subscribe.php?errorFirstName=Only letters and white space allowed&$user_data");
	    exit();
        
      }
    //if the Last Name field is empty then send this error
    else if(empty($FlastName)){
        header("Location: Subscribe.php?errorLastName=Last Name is required&$user_data");
	    exit();
    //Allows only letter and whitespace
	}else if (!preg_match("/^[a-zA-Z-' ]*$/",$FlastName)) {
        header("Location: Subscribe.php?errorLastName=Only letters and white space allowed&$user_data");
	    exit();
      }
    //if the Email field is empty then send this error
	else if(empty($FEmail)){
        header("Location: Subscribe.php?errorEmail=Email  is required&$user_data");
	    exit();
	}
    else if((empty($_POST['FcheckNewsLetter'])) && (empty($_POST['FcheckBreakingNews'])) ){
        header("Location: Subscribe.php?errorCheckBox=At Least choose one&$user_data");
	    exit();
	}

	else{
        // to check if the email already assigned with other user in database
	    $sql = "SELECT * FROM Member WHERE Email='$FEmail' ";
        $result = $pdo->query($sql);

        // if the email already exist in database then send this error
        if ($result->rowCount() > 0) {
			header("Location: Subscribe.php?errorEmail=$FEmail Already Subscribed or Try Using Different Email&$user_data");
	        exit();
		}
        else{
            try {
                $sql = "INSERT INTO Member (FirstName, LastName, Email, MonthlyNewsletter, BreakingNews) VALUES (?,?,?,?,?)";
                if ($stmt = $pdo->prepare($sql)) {
                    if ($stmt->execute([$FfirstName, $FlastName, $FEmail, $FcheckNewsLetter, $FcheckBreakingNews])) {

                            if($FcheckNewsLetter == 1 && $FcheckBreakingNews == 1){
                            // Records created successfully. Redirect to landing page
                                header("Location: Subscribe.php?success=Congratulation!, $FfirstName, You are Sucessfully Subscribed to Both Subscription");
                                exit();
                             }
                            if($FcheckNewsLetter == 1 && $FcheckBreakingNews == 0){
                                    header("Location: Subscribe.php?success=Congratulation!, $FfirstName, You are Sucessfully Subscribed to Monthly Newsletter");
                                    exit();
                            }
                            if($FcheckNewsLetter == 0 && $FcheckBreakingNews == 1){
                                    header("Location: Subscribe.php?success=Congratulation!, $FfirstName, You are Sucessfully Subscribed to Breaking News");
                                    exit();
                            }
                       
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