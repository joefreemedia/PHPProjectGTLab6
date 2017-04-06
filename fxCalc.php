<?php
/**
 * Money Banks Calculator
 * User: geoffreytrenard
 * Date: 3/23/17
 * Time: 6:39 AM
 * testing
 */

if( !isset( $_SESSION ) )
{
	session_start();
}

$username = "";
	
require_once ('LoginDataModel.php');

//Check if the session username is set if not return to login.php
if(isset( $_SESSION[ LoginDataModel::USER_NAME ] ) )
{
	$username = $_SESSION[ LoginDataModel::USER_NAME ];
}
else
{
    include 'login.php';
    exit;
}

require_once('FxDataModel.php');



// Look to see if a serialized version of FxDataModel is in the session
// If it is, pull it out, unserialize it and store it in a local variable
// If not, instantiate the object and store a serialize version of it in the session for the future.


$fxDataModel = new FxDataModel();
$fxCurrencies = $fxDataModel->getFxCurrencies();
$iniArray = $fxDataModel->getIniArray();
//$srcAmt = $_POST[$iniArray[FxDataModel::SRC_AMT_KEY]];
//$srcCucy = $_POST[$iniArray[FxDataModel::SRC_CUCY_KEY]];
//$dstAmt = $_POST[$iniArray[FxDataModel::DST_AMT_KEY]];
//$dstCucy = $_POST[$iniArray[FxDataModel::DST_CUCY_KEY]];
//$fxRates = $fxDataModel->getFxRate($iniArray[ FxDataModel::SRC_CUCY_KEY ], $iniArray[ FxDataModel::DST_CUCY_KEY ]);

//Get the username from the login.php session

// Check if the input is empty
if( array_key_exists( $iniArray[FxDataModel::SRC_CUCY_KEY], $_POST ) ) {
    $srcAmt = $_POST[$iniArray[FxDataModel::SRC_AMT_KEY]];
}
else{
    $_POST[$iniArray[FxDataModel::SRC_AMT_KEY]] = '';
    $iniArray[FxDataModel::SRC_AMT_KEY] = $_POST[$iniArray[FxDataModel::SRC_AMT_KEY]];
}
if( is_numeric($iniArray[ FxDataModel::SRC_AMT_KEY ])){
    isset( $iniArray[ FxDataModel::SRC_CUCY_KEY ] ) && is_numeric($iniArray[ FxDataModel::SRC_CUCY_KEY ] );
    $iniArray[ FxDataModel::DST_CUCY_KEY ] = $_POST[$iniArray[FxDataModel::DST_CUCY_KEY ]];
    $iniArray[ FxDataModel::SRC_CUCY_KEY ] = $_POST[$iniArray[FxDataModel::SRC_CUCY_KEY]];
    $iniArray[ FxDataModel::DST_AMT_KEY ] = $fxDataModel->getFxRate( $iniArray[FxDataModel::SRC_CUCY_KEY], $iniArray[FxDataModel::DST_CUCY_KEY ] ) * $iniArray[FxDataModel::SRC_AMT_KEY];
}
else
{
    $iniArray[ FxDataModel::DST_AMT_KEY ]  = null;
    $iniArray[ FxDataModel::DST_CUCY_KEY ] = $fxCurrencies[ 0 ];
    $iniArray[ FxDataModel::SRC_AMT_KEY ]  = null;
    $iniArray[ FxDataModel::SRC_CUCY_KEY ] = $fxCurrencies[ 0 ];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>F/X Calculator</title>
</head>

<body>
<h1 align="center">Money Banks F/X Calculator</h1>
<hr/>
<br/>
<span style="text-align: center;"><h1>Welcome <?php echo $username ?></h1></span>
<form name="fxCalc" action="fxCalc.php" method="post">

    <div style="text-align: center">
        <!-- Name should be the key value BUT on page load it is empty so the program does not run. It only runs when the hard-coded name is added-->
        <select name="srcCucy">
            <?php
            foreach( $fxCurrencies as $fxCurrency )
            {
                ?>
                <option value="<?php echo $fxCurrency ?>"

                    <?php
                    if( $fxCurrency === $iniArray[FxDataModel::SRC_CUCY_KEY] )
                    {
                        ?>
                        selected
                        <?php
                    }
                    ?>

                ><?php echo $fxCurrency ?></option>
                <?php
            }
            ?>
        </select>
        <!-- Name should be the key value BUT on page load it is empty so the program does not run. It only runs when the hard-coded name is added-->
        <input type="text" name="srcAmt" value="<?php echo $iniArray[FxDataModel::SRC_AMT_KEY] ?>"/>
        <!-- Name should be the key value BUT on page load it is empty so the program does not run. It only runs when the hard-coded name is added-->
        <select name="dstCucy">
            <?php
            foreach( $fxCurrencies as $fxCurrency )
            {
                ?>
                <option value="<?php echo $fxCurrency ?>"

                    <?php
                    if( $fxCurrency === $iniArray[FxDataModel::DST_CUCY_KEY] )
                    {
                        ?>
                        selected
                        <?php
                    }
                    ?>

                ><?php echo $fxCurrency ?></option>

                <?php
            }
            ?>
        </select>
        <!-- Name should be the key value BUT on page load it is empty so the program does not run. It only runs when the hard-coded name is added-->
        <input type="text" name="dstAmt" disabled="disabled" value="<?php echo $iniArray[FxDataModel::DST_AMT_KEY] ?>"/>

        <br/><br/>

        <input type="submit" value="Convert"/>
        <input type="reset"/>
    </div>
</form>

</body>
</html>
