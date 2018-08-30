<?php
/**
 * Created by PhpStorm.
 * User: Trent
 * Date: 11/10/2017
 * Time: 4:37 PM
 */

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @return User[]
     */
    public function findAllVerified(){
        return $this->createQueryBuilder('user')
            ->andWhere('user.isVerified = :isVerified')
            ->setParameter('isVerified',true)
            ->orderBy('user.id','DESC')
            ->getQuery()
            ->execute();
    }
}