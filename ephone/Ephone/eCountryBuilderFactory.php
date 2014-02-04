<?php

namespace Ephone;

/**
 * Class.
 * 
 * 
 * 
 */
class eCountryBuilderFactory {

    const BUILDER_DATABASE = 1;
    const BUILDER_PHP      = 2;


    /**
     * Return form in function of action.
     *
     * @param int $builder builder
     *
     * @return mixed
     * @access public
     */
    public static function getBuilder($builder) {
        $countryBuilder = null;

        switch ($builder) {
            case self::BUILDER_DATABASE:
                // Implement a builder from database
                break;

            case self::BUILDER_PHP:
                $countryBuilder = ePhpCountryBuilder::getInstance();
                break;

            default:
                $countryBuilder = null;
                break;
        }

        return $countryBuilder;

    }


}
