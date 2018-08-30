<?php
/**
 * Created by PhpStorm.
 * User: Trent
 * Date: 11/11/2017
 * Time: 2:20 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string",nullable =true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string",nullable =true)
     */
    private $lastname;


    /**
     * @ORM\Column(type="string",nullable =true)
     */
    private $description;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }


    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string User's role change to text (used as css class)
     */
    public function getChatRoleAsText()
    {
        $role = $this->getRoles();
        switch ($role[0]) {
            case 'ROLE_ADMIN':
                return 'administrator';
            default:
                return 'user';
        }

    }

    /**
     * Changes User's role, removes other roles
     *
     * @param string $role Role that User will have
     *
     * @return $this
     */
    public function changeRole($role)
    {
        switch ($role) {
            case 'user':
                $this->removeRole('ROLE_ADMIN');

                break;

            case 'administrator':
                $this->removeRole('ROLE_USER');
                $this->addRole('ROLE_ADMIN');
                break;
        }

        return $this;
    }

}