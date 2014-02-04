<?php

namespace Ephone;

/**
 * eCollectUtils class.
 * 
 * 
 * 
 */
class eCollectUtils {

    const PHONENUMBER_TYPE_UNKNOWN      = 0;
    const PHONENUMBER_TYPE_MOBILE       = 1;
    const PHONENUMBER_TYPE_LANDLINE     = 2;
    const PHONENUMBER_TYPE_NO_DIAL_PLAN = 3;

    const FORMAT_MODE_WITH_PLUS_AND_DOT_SEPARATOR = 0;
    const FORMAT_MODE_WITHOUT_PLUS                = 1;
    const FORMAT_MODE_WITHOUT_DOT_SEPARATOR       = 2;


    /**
     * Check if phonenumber is valid. If Valid, return number formated as +33423567899 form example.
     *
     * @param string  $phonenumber phonenumber
     * @param string  $countryCode country code
     * @param integer $mode        format mode
     *
     * @return false or phonenumber
     * @access public
     */
    public static function isValidPhonenumber($phonenumber, $countryCode, $mode = self::FORMAT_MODE_WITH_PLUS_AND_DOT_SEPARATOR) {
        try {
            return ePhonenumberDetection::formatPhonenumber($countryCode, $phonenumber, $mode);
        } catch (ePhonenumberDetectionException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }
        
    }
    
    
    /**
     * Check if it is forbiden phonen number.
     * 
     * @param string $formated +XX.XXXXXX
     * 
     * @return boolean
     * @access public
     */
    public static function isForbiddenPhonenumber($formated) {        
        $position = strpos($formated, '+33.8');  
        return $position === false ? false : true;
  
    }
    
    
    /**
     * Get the phonenumber type (mobile, landline, unknown) from a valid formated number.
     *
     * @param string $phonenumber phonenumber
     * @param string $countryCode country code
     *
     * @return integer
     * @access public
     * @throws Exception
     */
    public static function getPhonenumberType($phonenumber, $countryCode) {
        try {
            $type = ePhonenumberDetection::getPhoneNumberType($countryCode, $phonenumber);
        } catch (ePhonenumberDetectionException $e) {
            throw new \Exception($e->getMessage());
        }

        return $type;

    }


    /**
     * Get the country code from a phonenumber.
     *
     * @param string $phonenumber phonenumber
     *
     * @return string
     * @access public
     * @throws Exception
     */
    public static function getCountryCodeFromNumber($phonenumber) {
        try {
            $countryCode = ePhonenumberDetection::getCountryCodeFromNumber($phonenumber);
        } catch (ePhonenumberDetectionException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }

        return $countryCode;

    }


}