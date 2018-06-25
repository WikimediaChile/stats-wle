<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class Dashboard
{
    /** @var EntityManagerInterface Acceso al repositorio */
    private $entityManager;

    /**
     * Constructor de clase
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Obtiene un resumen de las fotos desde la base de datos
     * @return array Arreglo de resultados
     */
    public function getPhotos() : array
    {
        $conn = $this->entityManager->getConnection();
        $sql = '
          select date(timestamp) AS fecha, count(distinct title) as archivos
            , count(distinct author) as usuarios
          from foto
          group by fecha
          order by fecha';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Obtiene un resumen de días y fotos subidas
     * @return array
     */
    public function getResume() : array
    {
        $conn = $this->entityManager->getConnection();
        $sql = '
            select count(distinct date(timestamp)) AS dias
              , count(distinct title) as archivos
              , count(distinct author) as usuarios
            from foto';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }
}
