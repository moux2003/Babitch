<?php

namespace Cytron\Bundle\BabitchBundle\Entity\Tournament;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use FSC\HateoasBundle\Annotation as Hateoas;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Cytron\Bundle\BabitchBundle\Entity\AbstractEntity;
use Cytron\Bundle\BabitchBundle\Entity\Team;

/**
 * Babitch TournamentGroup Entity.
 *
 * @ORM\Entity()
 * @ORM\Table(name="tournament_group")
 * @Hateoas\Relation("self", href = @Hateoas\Route("get_tournament_group", parameters = { "id" = ".id", "tournamentId" = ".tournament.id"}))
 */
class Group extends AbstractEntity
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
     * @ORM\ManyToOne(targetEntity="Tournament")
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    protected $tournament;

    /**
     * @ORM\ManyToMany(targetEntity="Cytron\Bundle\BabitchBundle\Entity\Team")
     * @ORM\JoinTable(name="tournament_groups_teams",
     *     joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")}
     * )
     * @Assert\NotBlank()
     */
    protected $teams;

    /**
     * @ORM\ManyToMany(targetEntity="Cytron\Bundle\BabitchBundle\Entity\Tournament\Match", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="tournament_groups_matchs",
     *     joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="cascade")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="match_id", referencedColumnName="id", onDelete="cascade")}
     * )
     */
    protected $matchs;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->matchs = new ArrayCollection();
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

    /**
     * Gets matchs.
     *
     * @return string
     */
    public function getMatchs()
    {
        return $this->matchs;
    }

    public function setMatchs(Collection $matchs)
    {
        $this->matchs = $matchs;

        return $this;
    }

    public function addMatch(Match $match)
    {
        if (!$this->matchs->contains($match)) {
            $this->matchs->add($match);
        }

        return $this;
    }

    public function removeMatch(Match $match)
    {
        if ($this->matchs->contains($match)) {
            $this->matchs->removeElement($match);
        }

        return $this;
    }

    /**
     * Gets the value of tournament.
     *
     * @return mixed
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * Sets the value of tournament.
     *
     * @param mixed $tournament the tournament
     *
     * @return self
     */
    public function setTournament(Tournament $tournament)
    {
        $this->tournament = $tournament;

        return $this;
    }
}
