<?php
namespace JakubOnderka\BirthNumber;

/**
 * Class BirthNumber
 *
 * Based on code from David Grudl
 * http://latrine.dgx.cz/jak-overit-platne-ic-a-rodne-cislo
 *
 * License: MIT
 *
 * @package JakubOnderka\BirthNumber
 */
class BirthNumber
{
    const GENDER_MALE = 'male',
        GENDER_FEMALE = 'female';

    /** @var int */
    private $year;

    /** @var int */
    private $month;

    /** @var int */
    private $day;

    /** @var int */
    private $extension;

    /** @var int */
    private $checksum;

    /**
     * @param string $birthNumber
     */
    public function __construct($birthNumber)
    {
        if (!preg_match('#^\s*(\d\d)(\d\d)(\d\d)[ /]*(\d\d\d)(\d?)\s*$#', $birthNumber, $matches)) {
            throw new \InvalidArgumentException("Invalid birth number format '$birthNumber'.");
        }

        $this->year = $matches[1];
        $this->month = $matches[2];
        $this->day = $matches[3];
        $this->extension = $matches[4];
        $this->checksum = $matches[5];
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->isValidChecksum() && $this->isValidDate();
    }

    /**
     * @return bool
     */
    public function isValidChecksum()
    {
        if ($this->checksum === '') {
            return $this->year < 54;
        }

        $mod = ($this->year . $this->month . $this->day . $this->extension) % 11;
        if ($mod === 10) {
            $mod = 0;
        }
        if ($mod !== (int) $this->checksum) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isValidDate()
    {
        return checkdate($this->getMonth(), $this->getDay(), $this->getYear());
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year + ($this->year < 54 ? 2000 : 1900);
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        $month = $this->month;
        if ($this->month > 70 && $this->year > 2003)  {
            $month -= 70;
        } elseif ($this->month > 50) {
            $month -= 50;
        } elseif ($this->month > 20 && $this->year > 2003) {
            $month -= 20;
        }

        return $month;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return (int) $this->day;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDay()
    {
        $dateTime = new \DateTime();
        $dateTime->setDate($this->getYear(), $this->getMonth(), $this->getDay());
        $dateTime->setTime(0, 0, 0);

        return $dateTime;
    }

    /**
     * @return int
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return int
     */
    public function getChecksum()
    {
        return $this->checksum;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        if ($this->month > 70 && $this->year > 2003 || $this->month > 50)  {
            return self::GENDER_FEMALE;
        }

        return self::GENDER_MALE;
    }

    /**
     * @param bool $withSlash
     * @return string
     */
    public function toString($withSlash = true)
    {
        $slash = $withSlash ? '/' : '';
        return "$this->year$this->month$this->day$slash$this->extension$this->checksum";
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}