<?php
namespace App\Entity\Trait;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;


trait CreatedAtTrait{
#[ORM\Column(type:'datetime_immutable', options: ['default'=>'CURRENT_TIMESTAMP'])]
private $created_at;

    /**
     * @return null
     */
    public function getCreatedAt():?\DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * @param null $created_at
     * @return User
     */
    public function setCreatedAt(\DateTimeImmutable $created_at):self
    {
        $this->created_at = $created_at;
        return $this;
    }
}