<?php


namespace Ephone;

/**
 * Class.
 * 
 * 
 * 
 */
abstract class eBaseCountryBuilder {


    const TYPE_ROW_COUNTRY_PHONE_NUMBER           = 1;
    const TYPE_ROW_COUNTRY_PHONE_NUMBER_DIAL_PLAN = 2;

    /**
     * Builder name.
     * 
     * @var string 
     */
    protected $builderName;


    /**
     * Return builder name.
     *
     * @return string
     * @access public
     */
    public function getBuilderName() {
        return $this->builderName;

    }


    /**
     * Retrieve a row capable of populating a CountryPhoneNumber.
     *
     * @param string $code code
     *
     * @return array
     * @access protected
     */
    abstract protected function retrieveCountryPhoneNumberRow($code);


    /**
     * Retrieve a row capable of populating a CountryPhoneNumber, from an international code.
     *
     * @param string $code International code
     *
     * @return array
     * @access protected
     */
    abstract protected function retrieveCountryPhoneNumberRowFromInternationalCode($code);


    /**
     * Retrieve a row capable of populating a CountryPhoneNumberDialPlan.
     *
     * @param string $code code
     *
     * @return array
     * @access protected
     */
    abstract protected function retrieveCountryPhoneNumberDialPlanRows($code);


    /**
     * Build a CountryPhoneNumber and retrun it.
     *
     * @param string $code code
     *
     * @return CountryPhoneNumber
     * @access public
     * @throws ePhonenumberDetectionException
     * @throws Exception
     */
    public function getBuiltCountry($code) {
        $countryPhoneNumberRowData = $this->retrieveCountryPhoneNumberRow($code);
        if (empty($countryPhoneNumberRowData) === true) {
            throw new ePhonenumberDetectionException(ePhonenumberDetectionException::NO_COUNTRY, $code);
        }

        $countryPhoneNumber = new eCountryPhoneNumber();
        $countryPhoneNumber->hydrate($countryPhoneNumberRowData);

        $countryPhoneNumberDialPlanRowsData = $this->retrieveCountryPhoneNumberDialPlanRows($code);

        foreach ($countryPhoneNumberDialPlanRowsData as $countryPhoneNumberDialPlanRowData) {
            $countryPhoneNumberDialPlan = new eCountryPhoneNumberDialPlan();
            $countryPhoneNumberDialPlan->hydrate($countryPhoneNumberDialPlanRowData);

            // Associate the dial plan to the country
            $countryPhoneNumber->addCountryDialPlan($countryPhoneNumberDialPlan);
            unset($countryPhoneNumberDialPlan);
        }

        unset($countryPhoneNumberDialPlanRowsData);
        return $countryPhoneNumber;
        
    }


    /**
     * Build a CountryPhoneNumber and retrun it.
     *
     * @param string $internationalCode international code
     *
     * @return CountryPhoneNumber
     * @access public
     * @throws ePhonenumberDetectionException
     * @throws Exception
     */
    public function getBuiltCountryFromInternationalCode($internationalCode) {
        $countryPhoneNumberRowData = $this->retrieveCountryPhoneNumberRowFromInternationalCode($internationalCode);
        if (empty($countryPhoneNumberRowData) === true) {
            throw new ePhonenumberDetectionException(ePhonenumberDetectionException::NO_COUNTRY, $internationalCode);
        }

        $countryPhoneNumber = new eCountryPhoneNumber();
        $countryPhoneNumber->hydrate($countryPhoneNumberRowData);

        return $countryPhoneNumber;
        
    }


}