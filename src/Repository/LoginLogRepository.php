<?php

namespace App\Repository;

use App\Entity\LoginLog;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LoginLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoginLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoginLog[]    findAll()
 * @method LoginLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoginLogRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LoginLog::class);
    }

    /**
     * Return 10 last login events for user.
     *
     * @param User $user
     * @return LoginLog[]
     */
    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('t')
            ->where('t.user = :user')
            ->setParameter('user', $user)
            ->orderBy('t.date', 'desc')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
