<?php

namespace Ephone;

/**
 * Class.
 * 
 * 
 * 
 */
abstract class eBaseCountryPhoneNumber {

    /**
     * Country iso Code.
     *
     * @var integer
     */
    protected $code;

    /**
     * Country name.
     *
     * @var integer
     */
    protected $name;

    /**
     * Country international prefix.
     *
     * @var integer
     */
    protected $dialPrefix;

    /**
     * Country Dial Plan.
     *
     * @var CountryPhoneNumberDialPlan
     */
    protected $countryDialPlan;


    /**
     * Constructor.
     *
     * @access public
     * @return void
     */
    public function __construct() {

    }
    

    /**
     * Return country's code.
     *
     * @return mixed
     * @access public
     */
    public function getCode() {
        return $this->code;
        
    }


    /**
     * Set country's code.
     *
     * @param string $code code
     *
     * @return void
     * @access public
     */
    public function setCode($code) {
        $this->code = $code;
        
    }


    /**
     * Return country's name.
     *
     * @return mixed
     * @access public
     */
    public function getName() {
        return $this->name;
        
    }


    /**
     * Set country's name.
     *
     * @param string $name Country name
     *
     * @return void
     * @access public
     */
    public function setName($name) {
        $this->name = $name;
        
    }
    

    /**
     * Return dial prefix.
     *
     * @return mixed
     * @access public
     */
    public function getDialPrefix() {
        return $this->dialPrefix;
        
    }


    /**
     * Set dial prefix.
     *
     * @param string $dialPrefix Country prefix
     *
     * @return void
     * @access public
     */
    public function setDialPrefix($dialPrefix) {
        $this->dialPrefix = $dialPrefix;
        
    }


    /**
     * Return country's dial plan.
     *
     * @return mixed
     * @access public
     */
    public function getCountryDialPlan() {
        return $this->countryDialPlan;

    }


    /**
     * Set country's dial plan.
     *
     * @param CountryPhoneNumberDialPlan $countryDialPlan Country dial plan
     *
     * @return void
     * @access public
     */
    public function setCountryDialPlan($countryDialPlan) {
        $this->countryDialPlan = $countryDialPlan;

    }


    /**
     * Add a country dial plan to the collection.
     *
     * @param CountryPhoneNumberDialPlan $cdp Country Dial Plan
     *
     * @access public
     * @return void
     */
    public function addCountryDialPlan(eCountryPhoneNumberDialPlan $cdp) {
        $this->countryDialPlan[] = $cdp;
        
    }

    
    /**
     * Hydrates (populates) the object variables with values from an array.
     *
     * @param array $row row
     *
     * @return void
     * @access public
     * @throws Exception
     */
    public function hydrate($row) {
        try {
            $this->code       = (is_null($row[0]) === false) ? (string) $row[0] : null;
            $this->name       = (is_null($row[1]) === false) ? (string) $row[1] : null;
            $this->dialPrefix = (is_null($row[2]) === false) ? (string) $row[2] : null;

        } catch (\Exception $e) {
            throw new \Exception('Error populating eCountryPhoneNumber object', $e);
        }
        
    }


}