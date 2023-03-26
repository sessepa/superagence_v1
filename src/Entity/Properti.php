<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\PropertiRepository;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\ConstraintValidator;

#[ORM\Entity(repositoryClass: PropertiRepository::class)]
#[UniqueEntity('title')]
class Properti
{
    //Utilise la date de creation définit dans Entity\Trait\CreatedAtTrait.php
    use CreatedAtTrait;
    const HEAT = [
        0 =>'Electric',
        1 =>'Gaz',
        2 =>'Fioul',
        3 =>'A bois ',
        4 =>'Pompe à chaleur ',
        5 =>'Granulé'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id ;

    #[ORM\Column(length: 255)]
    private ?string $title ;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description ;


    #[Assert\Range(
        min: 10,
        max: 2500,
        notInRangeMessage:'Cette valeur doit être comprise entre  {{ min }} m² et {{ max }} m²'
    )]
    #[ORM\Column]
    private ?int $surface ;

    #[ORM\Column]
    private ?int $rooms ;

    #[ORM\Column]
    private ?int $bedrooms ;

    #[ORM\Column]
    private ?int $floor ;

    #[ORM\Column]
    private ?float $price ;

    #[ORM\Column]
    private ?int $heat ;

    #[ORM\Column(length: 255)]
    private ?string $city ;

    #[ORM\Column(length: 255)]
    private ?string $adresse ;

    #[ORM\Column]
    private ?bool $sold ;

    #[Assert\Regex('/^[0-9]{5}$/')]
    #[ORM\Column(length: 6)]
    private ?string $postalcode;

    public function __construct(){
        $this->created_at = new \DateTimeImmutable();

    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Permet de récupérer le title dans l'url
     * @return string
     */
    public function getSlug(): string {
        return (new Slugify())->slugify($this->title);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFormattedPrice(): string {
        return number_format($this->price,0,'', ' ');
    }

    public function getHeat(): ?int
    {
        return $this->heat;
    }

    public function setHeat(int $heat): self
    {
        $this->heat = $heat;

        return $this;
    }

    /**
     * Permet de recuperer le type de chauffage en chaine de caractères
     * @return string
     */
    public function getHeatType(){

        return self::HEAT[$this->heat];
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function isSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getPostalcode(): ?string
    {
        return $this->postalcode;
    }

    public function setPostalcode(string $postalcode): self
    {
        $this->postalcode = $postalcode;

        return $this;
    }



}
