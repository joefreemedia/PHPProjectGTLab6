<?php

/**
 * Money Banks Calculator
 * User: geoffreytrenard
 * Date: 3/23/17
 * Time: 6:38 AM
 */
define('FX_CALC_INI_FILE', 'fxCalc.ini'); // Define ini file to fxCalc as a constant

class FxDataModel
{

    // declare these variable as constants
    const DST_AMT_KEY = "dst.amt";
    const DST_CUCY_KEY = "dst.cucy";
    const FX_RATES_FILE_KEY = "fx.rates.file";
    const SRC_AMT_KEY = "src.amt";
    const SRC_CUCY_KEY = "src.cucy";


    // Private Data Members
    private $fxCurrencies;
    private $fxRates;
    private $iniArray;

// fgetcsv function to return  fxCurrencies

    /**
     * FxDataModel constructor.
     */
    public function __construct(){
        $this->iniArray = parse_ini_file(FX_CALC_INI_FILE);
        $cur_handle = fopen($this->iniArray[self::FX_RATES_FILE_KEY], 'r'); // Open the fxRates.csv file
        $this->fxCurrencies = fgetcsv($cur_handle);
        while(($rates=fgetcsv($cur_handle, 'r'))){
            $this->fxRates[]=$rates;
        }
        fclose($cur_handle); // close the file using the handle that was assigned.
        //print_r($this->fxRates);
        //print_r($this->iniArray);
    }

    // Public method that return the associated array.
    public function getIniArray(){
        return $this->iniArray;
    }

    // Public method to return a array of Country codes
    public function getFxCurrencies(){
        return $this->fxCurrencies;
    }

    // Public method to return a exchange rate
    public function getFxRate( $srcCucy, $dstCucy ){
        $in  = 0                      ;
        $len = count( $this->fxCurrencies );
        $out = 0                      ;

        for( ; $in < $len ; $in++ )
        { //Assign the 'in' rate to SRC_CUCY_KEY
            if( $this->fxCurrencies[ $in ] == $srcCucy )
            {
                break;
            }
        }

        for( ; $out < $len ; $out++ )
        { //Assign the 'out' rate to DST_CUCY_KEY
            if( $this->fxCurrencies[ $out ] == $dstCucy )
            {
                break;
            }
        }

        return $this->fxRates[ $in ][ $out ];
    }

}

?>