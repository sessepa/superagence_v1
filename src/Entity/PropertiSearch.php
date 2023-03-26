<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
class PropertiSearch  {

    /**
     * @var int|null
     */
     private $maxPrice;

    /**
     * @var int|
     * @Assert\Range(min=10, max=500)
     */
    private $minSurface;

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     * @return PropertiSearch
     */
    public function setMaxPrice(int $maxPrice): PropertiSearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * @param int|null $minSurface
     * @return PropertiSearch
     */
    public function setMinSurface(int $minSurface): PropertiSearch
    {
        $this->minSurface = $minSurface;
        return $this;
    }



}