<?php
use JakubOnderka\BirthNumber\BirthNumber;

require_once __DIR__ . '/BirthNumber.php';

class BirthNumberTest extends \PHPUnit_Framework_TestCase
{
    public function testFormatInvalid()
    {
        $this->setExpectedException('\InvalidArgumentException');
        new BirthNumber('Jakub');
    }

    public function testFormatValid()
    {
        new BirthNumber('1212121212');
    }

    public function testFormatValidNumeric()
    {
        new BirthNumber(1212121212);
    }

    public function testFormatValidWithSlash()
    {
        new BirthNumber('121212/1212');
    }

    public function testFormatValidOld()
    {
        new BirthNumber('121212121');
    }

    public function testFormatValidOldWithSlash()
    {
        new BirthNumber('121212/121');
    }

    public function testValidFemaleNumber()
    {
        $birthNumber = new BirthNumber('736028/5163');

        $this->assertEquals(1973, $birthNumber->getYear());
        $this->assertEquals(10, $birthNumber->getMonth());
        $this->assertEquals(28, $birthNumber->getDay());
        $this->assertEquals(516, $birthNumber->getExtension());
        $this->assertEquals(3, $birthNumber->getChecksum());

        $this->assertTrue($birthNumber->isValidDate());
        $this->assertTrue($birthNumber->isValidChecksum());
        $this->assertTrue($birthNumber->isValid());

        $this->assertEquals(BirthNumber::GENDER_FEMALE, $birthNumber->getGender());

        $this->assertEquals('736028/5163', $birthNumber->toString());
        $this->assertEquals('7360285163', $birthNumber->toString(false));
        $this->assertEquals('736028/5163', $birthNumber->__toString());
    }

    public function testValidMaleNumber()
    {
        $birthNumber = new BirthNumber('731028/5169');

        $this->assertEquals(1973, $birthNumber->getYear());
        $this->assertEquals(10, $birthNumber->getMonth());
        $this->assertEquals(28, $birthNumber->getDay());
        $this->assertEquals(516, $birthNumber->getExtension());
        $this->assertEquals(9, $birthNumber->getChecksum());

        $this->assertTrue($birthNumber->isValidDate());
        $this->assertTrue($birthNumber->isValidChecksum());
        $this->assertTrue($birthNumber->isValid());

        $this->assertEquals(BirthNumber::GENDER_MALE, $birthNumber->getGender());

        $this->assertEquals('731028/5169', $birthNumber->toString());
        $this->assertEquals('7310285169', $birthNumber->toString(false));
        $this->assertEquals('731028/5169', $birthNumber->__toString());
    }

    public function testInvalidDate()
    {
        $birthNumber = new BirthNumber('731328/5166');

        $this->assertFalse($birthNumber->isValidDate());
        $this->assertTrue($birthNumber->isValidChecksum());
        $this->assertFalse($birthNumber->isValid());
    }

    public function testInvalidChecksum()
    {
        $birthNumber = new BirthNumber('731028/5163');

        $this->assertTrue($birthNumber->isValidDate());
        $this->assertFalse($birthNumber->isValidChecksum());
        $this->assertFalse($birthNumber->isValid());
    }
}