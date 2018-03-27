<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This entity represents a single event on the account - either login or logout.
 *
 * @ORM\Entity(repositoryClass="App\Repository\LoginLogRepository")
 */
class LoginLog
{
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Which user did the action
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Which action was performed
     *
     * @ORM\Column(type="string", length=255)
     */
    private $action;

    /**
     * Date of the action. Defaults to current time
     *
     * @ORM\Column(type="datetime")
     */
    private $date;


    public function __construct()
    {
        $this->date = new \DateTime();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
