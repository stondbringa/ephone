<?php

namespace Ephone;

/**
 * Class.
 * 
 * 
 * 
 */
class ePhonenumberDetection {

    const PHONENUMBER_TYPE_UNKNOWN      = 0;
    const PHONENUMBER_TYPE_MOBILE       = 1;
    const PHONENUMBER_TYPE_LANDLINE     = 2;
    const PHONENUMBER_TYPE_NO_DIAL_PLAN = 3;

    const FORMAT_MODE_WITH_PLUS_AND_DOT_SEPARATOR = 0;
    const FORMAT_MODE_WITHOUT_PLUS                = 1;
    const FORMAT_MODE_WITHOUT_DOT_SEPARATOR       = 2;


    /**
     * Try to identify the type of a phoneNumber.
     *
     * @param string $countryCode Country Iso Format
     * @param string $number      PhoneNumber
     *
     * @access public
     * @throws Exception
     * @return int
     */
    public static function getPhoneNumberType($countryCode, $number) {
        $dialType = self::PHONENUMBER_TYPE_UNKNOWN;
        
        try {
            $countryCode              = self::checkCountryCode($countryCode);
            $countryBuilder           = eCountryBuilderFactory::getBuilder(eCountryBuilderFactory::BUILDER_PHP);
            $countryPhoneNumberObject = $countryBuilder->getBuiltCountry($countryCode);

            if ($countryPhoneNumberObject instanceof eCountryPhoneNumber) {
                $dialPlan = $countryPhoneNumberObject->getMatchingDialPlan($number);
                if (is_null($dialPlan) === false) {
                    $dialType = $dialPlan->getDialType();
                }
            }

            unset($countryPhoneNumberObject);
            unset($countryBuilder);

        } catch (ePhonenumberDetectionException $e) {
            switch ($e->getCode()) {
                case ePhonenumberDetectionException::NON_VALID_NUMBER:
                    throw $e;
                    break;

                case ePhonenumberDetectionException::NO_COUNTRY_DIAL_PLAN:
                    $dialType = self::PHONENUMBER_TYPE_NO_DIAL_PLAN;
                    break;

                default:
                    // Nothing
                    break;
            }
        } catch (\Exception $e) {
            throw new \Exception('ePhonenumberDetection::getTypeFromPhoneNumber : '.$e->getMessage());
        }
        
        return $dialType;

    }


    /**
     * Try to format a phonenumber.
     *
     * @param string  $countryCode Country Iso Format
     * @param string  $number      PhoneNumber
     * @param integer $mode        Format mode
     *
     * @access public
     * @throws Excepton
     * @throws ePhonenumberException
     * @return int
     */
    public static function formatPhonenumber($countryCode, $number, $mode = self::FORMAT_MODE_WITH_PLUS_AND_DOT_SEPARATOR) {
        $countryCode = self::checkCountryCode($countryCode);
        self::checkFormatModeValidity($mode);
        $countryBuilder           = eCountryBuilderFactory::getBuilder(eCountryBuilderFactory::BUILDER_PHP);
        $countryPhoneNumberObject = $countryBuilder->getBuiltCountry($countryCode);

        $formattedNumber = false;
        if ($countryPhoneNumberObject instanceof eCountryPhoneNumber) {
            $formattedNumber = $countryPhoneNumberObject->formatDialNumber($number, $mode);
        }

        unset($countryPhoneNumberObject);
        unset($countryBuilder);

        return $formattedNumber;
        
    }


    /**
     * Try to get a country code form a phonenumber.
     *
     * @param string $number PhoneNumber
     *
     * @access public
     * @throws Exception
     * @return int
     */
    public static function getCountryCodeFromNumber($number) {
        $pattern = '@^\+(?:([0-9]+)\.)[0-9]+$@';
        $nb      = preg_match($pattern, $number, $matches);
        
        $countryCode = false;
        if ($nb > 0) {
            $internationalCode = $matches[1];
        } else {
            return $countryCode;
        }
        
        try {
            $countryBuilder           = eCountryBuilderFactory::getBuilder(eCountryBuilderFactory::BUILDER_PHP);
            $countryPhoneNumberObject = $countryBuilder->getBuiltCountryFromInternationalCode($internationalCode);

            if ($countryPhoneNumberObject instanceof eCountryPhoneNumber) {
                $countryCode = $countryPhoneNumberObject->getCode();
            }

            unset($countryPhoneNumberObject);
            unset($countryBuilder);

        } catch (\Exception $e) {
            throw new \Exception('ePhonenumberDetection::getTypeFromPhoneNumber : '.$e->getMessage());
        }

        return $countryCode;

    }


    /**
     * Check if the mode is valid.
     *
     * @param integer $mode Format mode
     *
     * @access private
     * @return void
     * @throws Exception
     */
    private static function checkFormatModeValidity($mode) {
        $validMode = array(
            self::FORMAT_MODE_WITH_PLUS_AND_DOT_SEPARATOR,
            self::FORMAT_MODE_WITHOUT_PLUS,
            self::FORMAT_MODE_WITHOUT_DOT_SEPARATOR,
        );
        
        if (in_array($mode, $validMode) === false) {
            throw new \Exception('The format mode asked is not valid !');
        }
        
    }


    /**
     * Check if the country code is valid.
     *
     * @param string $countryCode Country code
     *
     * @access private
     * @return void
     * @throws Exception
     */
    private static function checkCountryCode($countryCode) {
        $countryCode = strtolower($countryCode);

        if (empty($countryCode) === true || is_numeric($countryCode) === true) {
            throw new \Exception('Invalid country code !');
        }

        return $countryCode;

    }


}