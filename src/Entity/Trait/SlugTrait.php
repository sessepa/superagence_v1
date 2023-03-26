<?php
namespace App\Entity\Trait;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;


trait SlugTrait{
#[ORM\Column(type:'string', length: 255)]
private $slug;

    /**
     * @return null
     */
    public function getSlug():?string
    {
        return $this->slug;
    }

    /**
     * @param null $slug
     * @return User
     */
    public function setSlug(string $slug):self
    {
        $this->slug = $slug;
        return $this;
    }
}