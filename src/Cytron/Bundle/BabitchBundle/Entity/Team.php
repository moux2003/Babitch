<?php

namespace Cytron\Bundle\BabitchBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use FSC\HateoasBundle\Annotation as Hateoas;

/**
 * Babitch Team Entity.
 *
 * @ORM\Entity()
 * @ORM\Table(name="team")
 * @Hateoas\Relation("self", href = @Hateoas\Route("get_team", parameters = { "id" = ".id"}))
 */
class Team extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\OneToOne(targetEntity="Player")
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $player1;

    /**
     * @ORM\OneToOne(targetEntity="Player")
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $player2;

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $player
     *
     * @return $this
     */
    public function setPlayer1(Player $player)
    {
        $this->player1 = $player;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * @param string $player
     *
     * @return $this
     */
    public function setPlayer2(Player $player)
    {
        $this->player2 = $player;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    /**
     * Gets the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
