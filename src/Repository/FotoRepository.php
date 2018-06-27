<?php

namespace App\Repository;

use App\Entity\Foto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Foto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Foto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Foto[]    findAll()
 * @method Foto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FotoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Foto::class);
    }

    /**
     * Obtiene una página por su pageid
     * @param  int    $pageid Número interno de la página en Wikimedia Commons
     * @return Foto|null
     */
    public function getByPageid(int $pageid)
    {
        return $this->findOneBy(['pageid' => $pageid]);
    }


    public function getByDate(string $date)
    {
        $dateTime = \DateTime::createFromFormat("Y-m-d", $date);
        $query = $this->_em->createQuery("SELECT f FROM App\Entity\Foto f WHERE f.timestamp between :dateStart and :dateEnd");
        $query->setParameter('dateStart', $dateTime->format('Y-m-d 00:00:00'));
        $query->setParameter('dateEnd', $dateTime->format('Y-m-d 23:59:59'));
        return $query->execute();
    }

    /**
     * Guarda una foto en el repositorio
     * @param  Foto   $foto Clase instanciada de foto
     */
    public function save(Foto $foto)
    {
        $this->_em->persist($foto);
        $this->_em->flush();
    }
}
