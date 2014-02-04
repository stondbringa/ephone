<?php

namespace Ephone;

/**
 * Class.
 * 
 * 
 * 
 */
class eCountryPhoneNumber extends eBaseCountryPhoneNumber {

    const FORMAT_MODE_WITH_PLUS_AND_DOT_SEPARATOR = 0;
    const FORMAT_MODE_WITHOUT_PLUS                = 1;
    const FORMAT_MODE_WITHOUT_DOT_SEPARATOR       = 2;


    /**
     * Format a number.
     *
     * @param string  $number number
     * @param integer $mode   format mode
     *
     * @return string
     * @access public
     * @throws ePhonenumberDetectionException
     */
    public function formatDialNumber($number, $mode = ePhonenumberDetection::FORMAT_MODE_WITH_PLUS_AND_DOT_SEPARATOR) {
        if (count($this->countryDialPlan) === 0) {
            throw new ePhonenumberDetectionException(ePhonenumberDetectionException::NO_COUNTRY_DIAL_PLAN, $this->code);
        }

        $number    = trim($number);
        $formated  = (strpos($number, '+') === 0) ? '+' : '';
        $formated .= preg_replace(eRegexUtils::delimitRegex('[^0-9]', false, false), '', $number);
        $number    = $formated;

        $numberFormatted = false;
        foreach ($this->countryDialPlan as $dialPlan) {
            $matching = $dialPlan->matchesRegexRule($number, $this->dialPrefix);

            switch ($matching) {
                case eCountryPhoneNumberDialPlan::REGEX_MATCH_NOPREFIX:
                    $formatted = $dialPlan->stripLeadingDigit($number);
                    if (empty($this->dialPrefix) === false) {
                        $numberFormatted = eCountryPhoneNumberDialPlan::INTERNATIONAL_CODE_PLUS.$this->dialPrefix.eCountryPhoneNumberDialPlan::INTERNATIONAL_CODE_SEPARATOR.$formatted;
                        return self::formatMode($numberFormatted, $mode);
                    }
                    break;

                case eCountryPhoneNumberDialPlan::REGEX_MATCH_PREFIX:
                    $formatted       = $dialPlan->stripDialPrefix($number, $this->dialPrefix);
                    $numberFormatted = eCountryPhoneNumberDialPlan::INTERNATIONAL_CODE_PLUS.$this->dialPrefix.eCountryPhoneNumberDialPlan::INTERNATIONAL_CODE_SEPARATOR.$formatted;
                    return self::formatMode($numberFormatted, $mode);
                    break;

                case eCountryPhoneNumberDialPlan::REGEX_NOMATCH:
                    // Nothing to format
                    $numberFormatted = false;
                    break;

                default:
                    // Nothing
                    break;
            }
        }

        return $numberFormatted;
        
    }


    /**
     * Get a dial plan matching for the number.
     *
     * @param string $number number
     *
     * @return CountryPhoneNumberDialPlan
     * @access public
     * @throws ePhonenumberDetectionException
     */
    public function getMatchingDialPlan($number) {
        if (count($this->countryDialPlan) === 0) {
            throw new ePhonenumberDetectionException(ePhonenumberDetectionException::NO_COUNTRY_DIAL_PLAN, $this->code);
        }

        foreach ($this->countryDialPlan as $dialPlan) {
            // we have a match: format is without the country dial prefix
            $matching = $dialPlan->matchesRegexRule($number, $this->dialPrefix);
            if ($matching === eCountryPhoneNumberDialPlan::REGEX_MATCH_NOPREFIX || $matching === eCountryPhoneNumberDialPlan::REGEX_MATCH_PREFIX) {
                return $dialPlan;
            }
        }

        return null;

    }


    /**
     * Format according to mode.
     * 
     * @param string $number number
     * @param string $mode   Mode
     *
     * @return string
     * @access private
     */
    private static function formatMode($number, $mode) {
        if ($mode === ePhonenumberDetection::FORMAT_MODE_WITHOUT_PLUS) {
            $number = str_replace(eCountryPhoneNumberDialPlan::INTERNATIONAL_CODE_PLUS, '', $number);
        }

        if ($mode === ePhonenumberDetection::FORMAT_MODE_WITHOUT_DOT_SEPARATOR) {
            $number = str_replace(eCountryPhoneNumberDialPlan::INTERNATIONAL_CODE_SEPARATOR, '', $number);
        }

        return $number;
        
    }


}
