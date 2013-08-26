<?php
namespace JakubOnderka\BirthNumber;

class InvalidFormatException extends Exception
{
    /** @var string */
    private $birthNumber;

    public function __construct($birthNumber, $code = 0, \Exception $previous = null)
    {
        parent::__construct("Invalid birth number format '$birthNumber'.'", $code, $previous);
        $this->birthNumber = $birthNumber;
    }

    /**
     * @return string
     */
    public function getBirthNumber()
    {
        return $this->birthNumber;
    }
}