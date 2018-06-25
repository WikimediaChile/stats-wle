<?php

namespace App\Service;

use App\Entity\Foto;
use App\Repository\FotoRepository;

class Commons
{
    private $fotoRepository;

    /**
     * Constructor de clase
     * @param FotoRepository $fotoRepository Repositorio de Fotos
     */
    public function __construct(FotoRepository $fotoRepository)
    {
        $this->fotoRepository = $fotoRepository;
    }

    /**
     * Añade un arreglo de fotos en el repositorio
     * @param array $list Listado de fotos a añadir
     */
    public function addPhotos(array $list) : void
    {
        array_map([$this, 'addPhoto'], $list);
    }

    /**
     * Añade una foto en el repositorio
     * @param array $element Elemento a añadir en el repositorio
     */
    public function addPhoto(array $element) : void
    {
        if (is_null($this->fotoRepository->getByPageid($element['pageid']))) {
            $data = (array)$element['imageinfo'][0];
            $foto = new Foto();
            $foto->setTitle($element['title']);
            $foto->setAuthor($data['user']);
            $foto->setTimestamp(\DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['timestamp']));
            $foto->setPageid($element['pageid']);
            $this->fotoRepository->save($foto);
        }
    }
}
