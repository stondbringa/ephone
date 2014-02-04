<?php

namespace Ephone;

/**
 * Class.
 * 
 * 
 * 
 */
class eRegexUtils {

    const REGEX_DELIMITER    = '#';
    const REGEX_START_STRING = '^';
    const REGEX_END_STRING   = '$';
    

    /**
     * Delimit a regex with regex delimiter, a begin delimiter and/or a end delimiter.
     *
     * @param string $regex regex
     * @param string $begin begin
     * @param string $end   end
     *
     * @return string
     * @access public
     */
    public static function delimitRegex($regex, $begin = true, $end = true) {
        $regexElements = array(
            self::REGEX_DELIMITER,
            ($begin === true) ? self::REGEX_START_STRING : null,
            $regex,
            ($end === true) ? self::REGEX_END_STRING : null,
            self::REGEX_DELIMITER,
        );

        $regexDelimited = '';

        foreach ($regexElements as $regexElement) {
            if (is_null($regexElement) === false) {
                $regexDelimited .= $regexElement;
            }
        }

        return $regexDelimited;

    }


}
