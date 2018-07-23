<?php

namespace AppBundle\Repository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository implements UserLoaderInterface
{
    /*
     * Loads the user for the given username
     *
     * @param string $username The username
     *
     * @return UserInterface|null
     * */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('username = :username OR email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
