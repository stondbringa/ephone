<?php

namespace Ephone;

/**
 * Class.
 * 
 * 
 * 
 */
abstract class eBaseCountryPhoneNumberDialPlan {

    /**
     * Country iso Code.
     *
     * @var integer
     */
    protected $countryCode;

    /**
     * Leading digit.
     *
     * @var string
     */
    protected $leadingDigit;

    /**
     * Regex rule.
     *
     * @var string
     */
    protected $regexRule;

    /**
     * Dial Type.
     *
     * @var integer
     */
    protected $dialType;

    
    /**
     * Return country's code.
     *
     * @return mixed
     * @access public
     */
    public function getCountryCode() {
        return $this->countryCode;

    }


    /**
     * Set country's code.
     *
     * @param string $countryCode Country code
     *
     * @return void
     * @access public
     */
    public function setCountryCode($countryCode) {
        $this->countryCode = $countryCode;

    }


    /**
     * Return leading digit.
     *
     * @return mixed
     * @access public
     */
    public function getLeadingDigit() {
        return $this->leadingDigit;

    }

    /**
     * Set leading digit.
     *
     * @param string $leadingDigit Country leading digit
     *
     * @return void
     * @access public
     */
    public function setLeadingDigit($leadingDigit) {
        $this->leadingDigit = $leadingDigit;

    }


    /**
     * Return regex rule.
     *
     * @return mixed
     * @access public
     */
    public function getRegexRule() {
        return $this->regexRule;

    }


    /**
     * Set regex rule.
     *
     * @param string $regexRule Regex rule
     *
     * @return void
     * @access public
     */
    public function setRegexRule($regexRule) {
        $this->regexRule = $regexRule;

    }


    /**
     * Get dial type.
     *
     * @return mixed
     * @access public
     */
    public function getDialType() {
        return $this->dialType;

    }


    /**
     * Set dial type.
     *
     * @param string $dialType Dial type
     *
     * @return void
     * @access public
     */
    public function setDialType($dialType) {
        $this->dialType = $dialType;

    }


    /**
     * Constructor.
     *
     * @return void
     * @access public
     */
    public function __construct() {
        
    }


    /**
     * Hydrates (populates) the object variables with values from an array.
     *
     * @param array $row row
     *
     * @return void
     * @access public
     */
    public function hydrate($row) {
        try {
            $this->countryCode  = (is_null($row[0]) === false) ? (string) $row[0] : null;
            $this->leadingDigit = (is_null($row[1]) === false) ? (string) $row[1] : null;
            $this->regexRule    = (is_null($row[2]) === false) ? (string) $row[2] : null;
            $this->dialType     = (is_null($row[3]) === false) ? (int) $row[3] : null;

        } catch (\Exception $e) {
            throw new \Exception("Error populating eCountryPhoneNumberDialPlan object", $e);
        }
    }


}