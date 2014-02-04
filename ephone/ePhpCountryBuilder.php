<?php

namespace Ephone;

/**
 * Class.
 * 
 * 
 * 
 */
class ePhpCountryBuilder extends eBaseCountryBuilder {

    const COUNTRY_PHP_FILENAME = 'eCountry.php';
    const COUNTRY_PNS_PHP_FILENAME = 'eCountryPhonenumberScheme.php';
    const COUNTRY_FIELD_ISO2CODE = 'ISO2_CODE';
    const COUNTRY_FIELD_NAME = 'NAME';
    const COUNTRY_FIELD_INTERNATIONAL_CODE = 'INTERNATIONAL_CODE';
    const COUNTRY_PNS_COUNTRY_CODE = 'COUNTRY_CODE';
    const COUNTRY_PNS_LEADING_DIGIT = 'LEADING_DIGIT';
    const COUNTRY_PNS_REGEX_RULE = 'REGEX_RULE';
    const COUNTRY_PNS_SCHEME_TYPE = 'SCHEME_TYPE';

    /**
     * country.
     *
     * @var Array
     */
    private static $country = null;

    /**
     * country pns.
     *
     * @var Array
     */
    private static $countryScheme = null;

    /**
     * Instance.
     *
     * @var PhpCountryBuilder
     */
    private static $instance = null;

    /**
     * Builder name.
     *
     * @var string
     */
    protected $builderName = 'phpData';

    /**
     * Constructor : initialize static vars.
     *
     * @access private
     * @return void
     */
    private function __construct() {

        self::$country = include self::getCountryPhpFile();
        self::$countryScheme = include self::getCountryPnsPhpFile();
    }

    /**
     * Get Instance.
     *
     * @access public
     * @return PhpCountryBuilder
     */
    public static function getInstance() {
        if (isset(self::$instance) === false) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Get country file.
     *
     * @access private
     * @return string
     */
    private static function getCountryPhpFile() {
        return dirname(__FILE__) . '/data/' . self::COUNTRY_PHP_FILENAME;
    }

    /**
     * Get country pns file.
     *
     * @access private
     * @return string
     */
    private static function getCountryPnsPhpFile() {
        return dirname(__FILE__) . '/data/' . self::COUNTRY_PNS_PHP_FILENAME;
    }

    /**
     * Retrieve a row capable of populating a CountryPhoneNumber.
     *
     * @param string $code code
     *
     * @return array
     * @access protected
     * @throws Exception
     */
    protected function retrieveCountryPhoneNumberRow($code) {
        try {
            $country = self::findCountryByCode($code);
            if (is_null($country) === true) {
                return array();
            }

            $rows = self::filterAndOrderValues(array($country), self::TYPE_ROW_COUNTRY_PHONE_NUMBER);

            unset($country);
            return $rows;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieve a row capable of populating a CountryPhoneNumber, from an international code.
     *
     * @param string $internationalCode International code
     *
     * @return array
     * @access protected
     * @throws Exception
     */
    protected function retrieveCountryPhoneNumberRowFromInternationalCode($internationalCode) {
        try {
            $country = self::findCountryByInternationalCode($internationalCode);
            if (is_null($country) === true) {
                return array();
            }

            $rows = self::filterAndOrderValues(array($country), self::TYPE_ROW_COUNTRY_PHONE_NUMBER);

            unset($country);
            return $rows;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieve a row capable of populating a CountryPhoneNumberDialPlan.
     *
     * @param string $code code
     *
     * @return array
     * @access protected
     * @throws Exception
     */
    protected function retrieveCountryPhoneNumberDialPlanRows($code) {
        try {
            $countrySchemes = self::findCountryPnsByCode($code);

            $rows = self::filterAndOrderValues($countrySchemes, self::TYPE_ROW_COUNTRY_PHONE_NUMBER_DIAL_PLAN);
            unset($countrySchemes);
            return $rows;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Filter not needed columns and order it.
     *
     * @param array $rows    Rows
     * @param int   $typeRow Type of row
     *
     * @access private
     * @return array
     */
    private static function filterAndOrderValues($rows, $typeRow) {
        switch ($typeRow) {
            case self::TYPE_ROW_COUNTRY_PHONE_NUMBER:
                $neededColumns = array(
                    self::COUNTRY_FIELD_ISO2CODE => 0,
                    self::COUNTRY_FIELD_NAME => 1,
                    self::COUNTRY_FIELD_INTERNATIONAL_CODE => 2,
                );
                break;

            case self::TYPE_ROW_COUNTRY_PHONE_NUMBER_DIAL_PLAN:
                $neededColumns = array(
                    self::COUNTRY_PNS_COUNTRY_CODE => 0,
                    self::COUNTRY_PNS_LEADING_DIGIT => 1,
                    self::COUNTRY_PNS_REGEX_RULE => 2,
                    self::COUNTRY_PNS_SCHEME_TYPE => 3,
                );
                break;

            default:
                $neededColumns = array();
                break;
        }

        $returnRows = array();

        foreach ($rows as $row) {
            $filteredRow = array();
            foreach ($row as $key => $value) {
                if (in_array($key, array_keys($neededColumns)) === true) {
                    $filteredRow[$neededColumns[$key]] = $value;
                }
            }

            $returnRows[] = $filteredRow;
        }


        return ($typeRow === self::TYPE_ROW_COUNTRY_PHONE_NUMBER) ? array_shift($returnRows) : $returnRows;
    }

    /**
     * Find Country by Code.
     *
     * @param string $code code
     * 
     * @return array
     * @access public
     */
    public static function findCountryByCode($code) {
        
        foreach (self::$country as $country) {
            if ($country['iso2code'] === $code) {

                $countryArray = array(
                    self::COUNTRY_FIELD_ISO2CODE => $country['iso2code'],
                    self::COUNTRY_FIELD_NAME => $country['name'],
                    self::COUNTRY_FIELD_INTERNATIONAL_CODE => $country['internationalCode'],
                );

                return $countryArray;
            }
        }
    }

    /**
     * Find Country by international Code.
     *
     * @param string $internationalCode code
     *
     * @return array
     * @access public
     */
    public static function findCountryByInternationalCode($internationalCode) {
        foreach (self::$country as $country) {
            if ($country['internationalCode'] === $internationalCode) {

                $countryArray = array(
                    self::COUNTRY_FIELD_ISO2CODE => $country['iso2code'],
                    self::COUNTRY_FIELD_NAME => $country['name'],
                    self::COUNTRY_FIELD_INTERNATIONAL_CODE => $country['internationalCode'],
                );

                return $countryArray;
            }
        }
    }

    /**
     * Find Country PNS by Code.
     *
     * @param string  $code   code
     * @param integer $active active ?
     *
     * @return array
     * @access public
     */
    public static function findCountryPnsByCode($code, $active = 1) {


        $countryPsnArray = array();
        foreach (self::$countryScheme as $countryScheme) {
            if ($countryScheme['countryIso2code'] === $code && $countryScheme['active'] == $active) {

                $countryPsnArray[] = array(
                    self::COUNTRY_PNS_COUNTRY_CODE => $countryScheme['countryIso2code'],
                    self::COUNTRY_PNS_SCHEME_TYPE => $countryScheme['schemeType'],
                    self::COUNTRY_PNS_LEADING_DIGIT => $countryScheme['leadingDigit'],
                    self::COUNTRY_PNS_REGEX_RULE => $countryScheme['regexRule'],
                );
            }
        }

        return $countryPsnArray;
    }

}
