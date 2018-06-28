<?php

namespace App\Repository;

use App\Entity\UsersCommons;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UsersCommons|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersCommons|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersCommons[]    findAll()
 * @method UsersCommons[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersCommonsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UsersCommons::class);
    }

    /**
     * Obtiene un registro por el nombre de usuario
     * @param  string $user Nombre de usuario
     * @return UsersCommons|null
     */
    public function getbyUsername(string $user) : ?UsersCommons
    {
        return $this->findOneBy(['username' => $user]);
    }

    /**
     * Guarda un elemento nuevo en el repositorio
     * @param UsersCommons $user Objeto del repositorio
     */
    public function save(UsersCommons $user) :void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
