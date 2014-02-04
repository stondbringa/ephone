<?php

namespace Ephone;

/**
 * Class.
 * 
 * 
 * 
 */
class eCountryPhoneNumberDialPlan extends eBaseCountryPhoneNumberDialPlan {

    const INTERNATIONAL_CODE_PLUS        = '+';
    const INTERNATIONAL_CODE_DOUBLE_ZERO = '00';
    const INTERNATIONAL_CODE_SEPARATOR   = '.';

    const REGEX_MATCH_NOPREFIX = 1;
    const REGEX_MATCH_PREFIX   = 2;
    const REGEX_NOMATCH        = 3;
    

    /**
     * Attempt to match the regex rule for a string.
     * 
     * @param string $string String to regex
     * @param string $prefix Dial prefix
     * 
     * @return int
     * @access public
     */
    public function matchesRegexRule($string, $prefix) {
        // cleanup
        $originalString = $string;
        $string         = trim($string);
        $formated       = (strpos($string, '+') === 0) ? '+' : '';
        $formated      .= preg_replace(eRegexUtils::delimitRegex('[^0-9]', false, false), '', $string);
        $string         = $formated;

        if (is_numeric($string) === false || empty($string) === true || strlen($string) < 3) {
            throw new ePhonenumberDetectionException(ePhonenumberDetectionException::NON_VALID_NUMBER, $originalString);
        }

        $number = $this->stripLeadingDigit($string);

        // Without prefix and without leading digit
        if (preg_match(eRegexUtils::delimitRegex($this->regexRule), $number) > 0) {
            return self::REGEX_MATCH_NOPREFIX;
            
        } else if (empty($prefix) === false) {
            $number = $this->stripDialPrefix($string, $prefix);
            $number = $this->stripLeadingDigit($number);

            if (preg_match(eRegexUtils::delimitRegex($this->regexRule), $number) > 0) {
                return self::REGEX_MATCH_PREFIX;
            } else {
                return self::REGEX_NOMATCH;
            }
        }

        return self::REGEX_NOMATCH;
        
    }


    /**
     * Remove, if exists, the leading digit from the number.
     *
     * @param string $number number
     *
     * @return string
     * @access public
     */
    public function stripLeadingDigit($number) {
        if ($this->leadingDigit !== '' && $number[0] === $this->leadingDigit) {
            return substr($number, 1);
        } 
        
        return $number;
        
    }


    /**
     * Remove, if exists, the dial prefix from the number.
     *
     * @param string $number number
     * @param string $prefix Dial prefix
     *
     * @return string
     * @access public
     */
    public function stripDialPrefix($number, $prefix) {
        if (preg_match(eRegexUtils::delimitRegex($prefix, true, false), $number) > 0) {
            return substr($number, strlen($prefix));

        } else if (preg_match(eRegexUtils::delimitRegex('\\'.self::INTERNATIONAL_CODE_PLUS.$prefix, true, false), $number) > 0) {
            return substr($number, strlen($prefix) + 1);

        } else if (preg_match(eRegexUtils::delimitRegex(self::INTERNATIONAL_CODE_DOUBLE_ZERO.$prefix, true, false), $number) > 0) {
            return substr($number, strlen($prefix) + 2);
            
        }

        return $number;
            
    }


}