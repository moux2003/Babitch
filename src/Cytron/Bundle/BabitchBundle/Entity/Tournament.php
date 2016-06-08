<?php

namespace Cytron\Bundle\BabitchBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use FSC\HateoasBundle\Annotation as Hateoas;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Babitch Tournament Entity.
 *
 * @ORM\Entity()
 * @ORM\Table(name="tournament")
 * @Hateoas\Relation("self", href = @Hateoas\Route("get_tournament", parameters = { "id" = ".id"}))
 */
class Tournament extends AbstractEntity
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
     * @ORM\ManyToMany(targetEntity="Team")
     * @ORM\JoinTable(name="tournaments_teams",
     *     joinColumns={@ORM\JoinColumn(name="tournament_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")}
     * )
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $teams;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

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

    /**
     * Gets teams.
     *
     * @return string
     */
    public function getTeams()
    {
        return $this->teams;
    }

    public function setTeams(Collection $teams)
    {
        $this->teams = $teams;

        return $this;
    }

    public function addTeam(Team $team)
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
        }

        return $this;
    }

    public function removeTeam(Team $team)
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
        }

        return $this;
    }
}
