<?php
/**
 * Money Banks Login
 * User: geoffreytrenard
 * Date: 3/23/17
 * Time: 6:33 AM
 */

if( !isset( $_SESSION ) )
{
	session_start();
}

// Require once the Data Model Classes
require_once( 'LoginDataModel.php' );
require_once('FxDataModel.php');

// Instantiate the objects in LoginDataModel
$loginDataModel = new LoginDataModel();
$fxLogin = $loginDataModel->getFxLogin();
$usersArray = $loginDataModel->getUsersArray();

//Set username and password to empty strings
$username = "";
$password = "";

if( array_key_exists( $fxLogin[LoginDataModel::USER_NAME], $_POST ) )
{
        $username = $_POST[$fxLogin[LoginDataModel::USER_NAME]];
        $password = $_POST[$fxLogin[LoginDataModel::PASS_WORD]];

        if( isset( $username ) && $loginDataModel->validateUser( $username, $password ) ) 
				{
          //Render fxCalc.php when form is valid
				  $_SESSION[  LoginDataModel::USER_NAME ] = $username;
				
          include 'fxCalc.php';
					
					exit;
			  }
}





?>
<html>
<head>
    <title>Money Banks Login</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <style>
        label{
            padding-right: 10px;
        }
    </style>
</head>
<body>
<h1 align="center">Money Banks Login</h1>
<hr />
<br />
<form name="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <center>
        <label>Username</label><input name="<?php echo $fxLogin[LoginDataModel::USER_NAME] ?>" value="" type="text" /><br /><br />
        <label>Password</label><input name="<?php echo $fxLogin[LoginDataModel::PASS_WORD] ?>" value="" type="password" /><br /><br />
        <input type="submit" value="Login"/>
        <input type="reset"/>
    </center>
</form>
</body>
</html>