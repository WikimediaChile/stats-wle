<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FotoRepository;
use App\Repository\UsersCommonsRepository;

class Dashboard
{
    /** @var EntityManagerInterface Acceso al repositorio */
    private $entityManager;

    /**
     * Constructor de clase
     * @param EntityManagerInterface $entityManager
     * @param FotoRepository $entityManager
     * @param UsersCommonsRepository
     */
    public function __construct(EntityManagerInterface $entityManager, FotoRepository $fotoRepository, UsersCommonsRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->fotoRepository = $fotoRepository;
        $this->userRepository = $userRepository;
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
     * Obtiene un resumen de usuario y conteo de archivos
     * @param  boolean $grouped Determina si está agrupado por número de contribuciones
     * @return array            Si está agrupado, usa un arreglo de orden númerico para
     * agrupar los usuarios [x, [yyy, yyyy, yyyy]]
     */
    public function getUsers(bool $grouped = true) : array
    {
        $conn = $this->entityManager->getConnection();
        $sql = '
          select author as usuario, count(1) as archivos
          from foto
          group by author
          order by archivos desc';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll();
        if ($grouped) {
            $elements = [];
            foreach ($data as $element) {
                $elements[$element['archivos']][] = $element['usuario'];
            }
            return $elements;
        }
        return $data;
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

    /**
     * Obtiene las imágenes subidas por un usuario
     * @param  string $user Nombre del usuario
     * @return array        arreglo
     */
    public function getUserUpload(string $user) : array
    {
        return $this->fotoRepository->findBy(['author' => $user]);
    }

    /**
     * Obtiene las imágenes subidas en una fecha determinada
     * @param  string $date Fecha de subida
     * @return array        arreglo
     */
    public function getDateUpload(string $date) : array
    {
      if (preg_match('/\d{4}(-\d{2}){2}/', $date)){
        return $this->fotoRepository->getByDate($date);
      }
      else{
        throw new \Exception("Error en la fecha ingresada", 1);
      }

    }

    /**
     * Obtiene la cantidad de usuarios nuevos, viejso y veteranos hay en el concurso
     * @return array
     */
    public function getVeterans() : array {
      $conn = $this->entityManager->getConnection();
      $sql = '
        select count((case when is_new = 1 then 1 end)) nuevos,
          count((case when is_new = 0 then 1 end)) viejos,
          count((case when is_new is null then 1 end)) tbd
        from users_commons';
      $stmt = $conn->prepare($sql);
      $stmt->execute();

      return $stmt->fetch();
    }

}
