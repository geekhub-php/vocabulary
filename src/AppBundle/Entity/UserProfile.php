<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserProfile
 *
 * @ORM\Table(name="user_profile")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserProfileRepository")
 */
class UserProfile extends BaseSuperClass
{
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=45)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=45)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $lastName;

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return UserProfile
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return UserProfile
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}
