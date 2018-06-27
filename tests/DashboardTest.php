<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashBoardTest extends WebTestCase
{

  /** @var \App\Service\Dashboard */
  private $dashboard;

    public function setUp(){
      self::bootKernel();
      $container = self::$kernel->getContainer();
      $this->dashboard = self::$container->get('App\Service\Dashboard');
    }

    public function testPhotos()
    {
      $photos = $this->dashboard->getPhotos();
      $this->assertInternalType('array', $photos, 'Arreglo son fotos');
      $this->assertArrayHasKey('fecha', $photos[0], 'Fila posee la columna fecha');
      $this->assertArrayHasKey('archivos', $photos[0], 'Fila posee la columna archivos');
      $this->assertArrayHasKey('usuarios', $photos[0], 'Fila posee la columna usuarios');
    }

    public function testUsersGrouped()
    {
      $users = $this->dashboard->getUsers(true);
      $keys = array_keys($users);
      $this->assertInternalType('array', $users, 'Arreglo son usuarios');
      $this->assertGreaterThan(0, $keys[0], 'El primer indice es mayor que 0');
      $this->assertInternalType('array', $users[$keys[0]], 'Es un subarreglo de usuarios');
    }

    public function testUsersUngrouped()
    {
      $users = $this->dashboard->getUsers(false);
      $keys = array_keys($users);
      $this->assertInternalType('array', $users, 'Arreglo son usuarios');
      $this->assertEquals(0, $keys[0], 'El primer indice es 0');
      $this->assertArrayHasKey('archivos', $users[0], 'Fila posee la columna archivos');
      $this->assertArrayHasKey('usuario', $users[0], 'Fila posee la columna usuario');
    }

    public function testResume()
    {
      $resume = $this->dashboard->getResume();
      $this->assertInternalType('array', $resume, 'Arreglo es un resumen');
      $this->assertCount(3, $resume, 'El resumen posee tres columnas');
      $this->assertArrayHasKey('dias', $resume, 'Fila posee la columna fecha');
      $this->assertArrayHasKey('archivos', $resume, 'Fila posee la columna archivos');
      $this->assertArrayHasKey('usuarios', $resume, 'Fila posee la columna usuarios');
    }

    public function testInvalidUserUpload()
    {
      $user = $this->dashboard->getUserUpload('**NO EXISTE**');
      $this->assertInternalType('array', $user, 'Arreglo es un resumen');
      $this->assertCount(0, $user, 'El arreglo no posee filas');
    }

    public function testValidUserUpload()
    {
      $user = $this->dashboard->getUserUpload('Pazuag');
      $foto = $user[0];
      $this->assertInternalType('array', $user, 'Arreglo es un resumen');
      $this->assertGreaterThan(0, count($user), 'Al menos hay una fila');
      $this->assertInstanceOf('App\Entity\Foto', $foto, 'Retorno de fila es Entidad Foto');
    }

    public function testInvalidDateUpload()
    {
      $this->expectException(\Exception::class);
      $fecha = $this->dashboard->getDateUpload('2015-02-31');
      $fecha2 = $this->dashboard->getDateUpload('gatito'); #genera excepción por no ser una fecha
      $this->assertInternalType('array', $fecha, 'Arreglo es un resumen');
      $this->assertCount(0, $fecha, 'El arreglo no posee filas');
    }

    public function testValidDateUpload()
    {
      $fecha = $this->dashboard->getDateUpload('2018-06-20');
      $foto = $fecha[0];
      $this->assertInternalType('array', $fecha, 'Arreglo es un resumen');
      $this->assertGreaterThan(0, count($fecha), 'El arreglo posee al menos una fila');
      $this->assertInstanceOf('App\Entity\Foto', $foto, 'Retorno de fila es Entidad Foto');
    }

    public function tearDown(){
      $this->dashboard = null;
    }
}
