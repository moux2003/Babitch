<?php

namespace Cytron\Bundle\BabitchBundle\Entity\Tournament;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use FSC\HateoasBundle\Annotation as Hateoas;
use Cytron\Bundle\BabitchBundle\Entity\Game;
use Cytron\Bundle\BabitchBundle\Entity\Team;
use Cytron\Bundle\BabitchBundle\Entity\AbstractEntity;

/**
 * Babitch Tournament Match Entity.
 *
 * @ORM\Entity()
 * @ORM\Table(name="tournament_match")
 * @Hateoas\Relation("self", href = @Hateoas\Route("get_match", parameters = { "id" = ".id"}))
 */
class Match extends AbstractEntity
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
     * @ORM\ManyToOne(targetEntity="Cytron\Bundle\BabitchBundle\Entity\Team")
     * @ORM\JoinColumn(name="blue_id", referencedColumnName="id"))
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $blueTeam;

    /**
     * @ORM\ManyToOne(targetEntity="Cytron\Bundle\BabitchBundle\Entity\Team")
     * @ORM\JoinColumn(name="red_id", referencedColumnName="id"))
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $redTeam;

    /**
     * @ORM\OneToOne(targetEntity="Cytron\Bundle\BabitchBundle\Entity\Game")
     *
     * @var string
     */
    protected $game;

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
     * Gets the value of game.
     *
     * @return string
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Sets the value of game.
     *
     * @param string $game the game
     *
     * @return self
     */
    public function setGame(Game $game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Gets the value of blueTeam.
     *
     * @return string
     */
    public function getBlueTeam()
    {
        return $this->blueTeam;
    }

    /**
     * Sets the value of blueTeam.
     *
     * @param string $blueTeam the blue team
     *
     * @return self
     */
    public function setBlueTeam(Team $blueTeam)
    {
        $this->blueTeam = $blueTeam;

        return $this;
    }

    /**
     * Gets the value of redTeam.
     *
     * @return string
     */
    public function getRedTeam()
    {
        return $this->redTeam;
    }

    /**
     * Sets the value of redTeam.
     *
     * @param string $redTeam the red team
     *
     * @return self
     */
    public function setRedTeam(Team $redTeam)
    {
        $this->redTeam = $redTeam;

        return $this;
    }
}
