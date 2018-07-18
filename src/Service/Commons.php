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
            preg_match_all('/(\d{1,})×(\d{1,})/', $element['resolution'], $matches, PREG_SET_ORDER, 0);
            $pixeles = ((int)$matches[0][0]*(int)$matches[0][1]);
            $foto = new Foto();
            $foto->setTitle($element['page_title']);
            $foto->setAuthor($element['username']);
            $foto->setTimestamp(\DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $element['date']));
            $foto->setPageid($element['pageid']);
            $foto->setSize((int)$element['size']);
            $foto->setDimensions($element['resolution']);
            $foto->setMegapixels($pixeles);
            $this->fotoRepository->save($foto);
        }
    }

    /**
     * Obtiene a todos los usuarios desde el repositorio
     * @return array Arreglo con todos los usuarios
     */
    public function getUsers(): array
    {
        return $this->fotoRepository->getUsers();
    }
}
