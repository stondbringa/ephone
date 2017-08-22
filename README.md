# ephone

Simple and lightweight library to check, format and detect both mobile phone numbers and landline phone numbers.

# API

  - `eCollectUtils::isValidPhonenumber($phonenumber, $countryCode, $mode = self::FORMAT_MODE_WITH_PLUS_AND_DOT_SEPARATOR)`
    - Check whether the given phone number is valid according to the country code. 
    - Returns the formatted number in case of valid number
  
  - `eCollectUtils::getPhonenumberType($phonenumber)`
    - Check if the given phone number is a mobile or landline number  
  - `eCollectUtils::getCountryCodeFromNumber($phonenumber)`
    - Retrieve the country code that match the given phone number 


