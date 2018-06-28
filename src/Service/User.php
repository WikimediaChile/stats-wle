<?php

namespace App\Service;

use App\Entity\UsersCommons;
use App\Repository\UsersCommonsRepository;

class User
{
    private $userRepository;

    /**
     * Constructor de clase
     * @param UsersCommonsRepository $userRepository Repositorio de Usuarios
     */
    public function __construct(UsersCommonsRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Añade un arreglo de usuarios en el repositorio
     * @param array $list Listado de usuarios a añadir
     */
    public function process(array $list) : void
    {
        array_map([$this, 'addUser'], $list);
    }

    /**
     * Añade una usuario en el repositorio
     * @param array $element Elemento a añadir en el repositorio
     */
    public function addUser(array $element) : void
    {
        if (is_null($this->userRepository->getbyUsername($element['name']))) {
          $user = new UsersCommons();
          $element['registration'] = $element['registration'] ?: '2001-05-15T00:00:00Z';
          $fecha = \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $element['registration']);
          $diff = \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", '2018-06-01T00:00:00Z') < $fecha;
          $user->setUsername($element['name']);
          $user->setDateCreate($fecha);
          $user->setIsNew($diff);
          $this->userRepository->save($user);
        }
    }
}
