<?php

namespace Ephone;

/**
 * Class.
 * 
 * 
 * 
 */
class ePhonenumberDetectionException extends \Exception {

    const NO_COUNTRY           = 1001;
    const NO_COUNTRY_DIAL_PLAN = 1002;
    const NON_VALID_NUMBER     = 1003;
    
    /**
     * All the messages managed.
     *
     * @var array
     */
    private static $messages = array(
        self::NO_COUNTRY           => 'No country found',
        self::NO_COUNTRY_DIAL_PLAN => 'No country Dial plan found',
        self::NON_VALID_NUMBER     => 'Number not valid',
    );


    /**
     * Contructor.
     *
     * @param int   $code   Code Exception
     * @param array $extras Extra datas
     *
     * @return void
     * @access public
     */
    public function  __construct($code, $extras = null) {
        $message  = self::$messages[$code];
        $message .= (is_null($extras) === false) ? ((is_array($extras)) ? '. '.print_r($extras, true) : '. '.$extras) : '';
        parent::__construct($message, $code);

    }


}
?>
