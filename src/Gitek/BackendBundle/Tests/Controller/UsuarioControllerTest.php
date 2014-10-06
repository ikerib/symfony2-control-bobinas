<?php

namespace Gitek\BackendBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsuarioControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        // Nabigatzailea sortu
        $client = static::createClient();

        // Orrira sartzen den frogatu
        $crawler = $client->request('GET', '/admin/usuarios');
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/");
        $this->assertCount(1, $crawler->filter('h1:contains("Mantenimiento de Usuarios")'),"¿Se encuentra en el mantenimiento de usuarios?");

        // Menu Berria sortu
        $crawler = $client->click($crawler->selectLink('Nuevo Usuario')->link(), "Ez da menu berria sortzeko formularioa aurkitu");

        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'gitek_backendbundle_usuario[nombre]'  => 'Test',
            'gitek_backendbundle_usuario[apellidos]'  => 'Test',
            'gitek_backendbundle_usuario[admin]'  => '0',
        ));

        $client->submit($form);
        //$content = $client->getResponse()->getContent();
        //file_put_contents('somefile', $content);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Editar')->link());

        $form = $crawler->selectButton('Grabar')->form(array(
            'gitek_backendbundle_usuario[nombre]'  => 'tesT',
            'gitek_backendbundle_usuario[apellidos]'  => '999',
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();

//        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('td:contains("tesT")')->count(), 'Missing element [value="tesT"]');
//
//        // Delete the entity
        $crawler = $client->click($crawler->selectLink('Eliminar')->link());
        $crawler = $client->followRedirect();
//
//        // Check the entity has been delete on the list
        $this->assertNotRegExp('/tesT/', $client->getResponse()->getContent());

    }


}
