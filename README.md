Birth number library for PHP
============
Library for validating and formatting Czech and Slovak birth numbers.

Usage
-------------
```php
$birthNumber = new BirthNumber('736028/5163');

var_dump($birthNumber->getYear()); // 1973
var_dump($birthNumber->getMonth()); // 10
var_dump($birthNumber->getDay()); // 28
var_dump($birthNumber->getExtension()); // 516
var_dump($birthNumber->getChecksum()); // 3

var_dump($birthNumber->hasValidDate()); // true
var_dump($birthNumber->hasValidChecksum()); // true
var_dump($birthNumber->isValid()); // true

var_dump($birthNumber->getGender()); // female

var_dump($birthNumber->toString()); // 736028/5163
```
