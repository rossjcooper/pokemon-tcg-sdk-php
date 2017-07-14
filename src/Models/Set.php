<?php

namespace Pokemon\Models;

/**
 * Class Set
 *
 * @package Pokemon\Models
 */
class Set extends Model implements \JsonSerializable
{

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $series;

    /**
     * @var int
     */
    private $totalCards;

    /**
     * @var boolean
     */
    private $standardLegal;

    /**
     * @var string
     */
    private $releaseDate;

    /**
     * @return string
     */
    public function getCode()
    {
        return (string)$this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string)$this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSeries()
    {
        return (string)$this->series;
    }

    /**
     * @param string $series
     */
    public function setSeries($series)
    {
        $this->series = $series;
    }

    /**
     * @return int
     */
    public function getTotalCards()
    {
        return (int)$this->totalCards;
    }

    /**
     * @param int $totalCards
     */
    public function setTotalCards($totalCards)
    {
        $this->totalCards = $totalCards;
    }

    /**
     * @return boolean
     */
    public function isStandardLegal()
    {
        return (boolean)$this->standardLegal;
    }

    /**
     * @param boolean $standardLegal
     */
    public function setStandardLegal($standardLegal)
    {
        $this->standardLegal = $standardLegal;
    }

    /**
     * @return string
     */
    public function getReleaseDate()
    {
        return (string)$this->releaseDate;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	function jsonSerialize() {
		return [
			'code' => $this->getCode(),
			'name' => $this->getName()
		];
	}
}