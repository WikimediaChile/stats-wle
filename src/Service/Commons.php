<?php

namespace App\Service;

use App\Entity\Foto;
use Doctrine\ORM\EntityManagerInterface;

class Commons
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addPhotos($list)
    {
        array_map([$this, 'addPhoto'], (array)$list);
    }

    public function addPhoto($element)
    {
        $element = is_array($element) ? $element : (array)$element;
        $test = $this->entityManager->getRepository(Foto::class)->findOneBy(['pageid' => $element['pageid']]);
        if (is_null($test)) {
            $data = (array)$element['imageinfo'][0];
            $foto = new Foto();
            $foto->setTitle($element['title']);
            $foto->setAuthor($data['user']);
            $foto->setTimestamp(\DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['timestamp']));
            $foto->setPageid($element['pageid']);
            $this->entityManager->persist($foto);
            $this->entityManager->flush();
        }
    }
}
