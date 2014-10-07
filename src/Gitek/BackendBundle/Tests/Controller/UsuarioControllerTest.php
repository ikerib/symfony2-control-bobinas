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
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/usuarios/");
        $this->assertCount(1, $crawler->filter('h1:contains("Mantenimiento de Usuarios")'),"¿Se encuentra en el mantenimiento de usuarios?");

        // Menu Berria sortu
        $crawler = $client->click($crawler->selectLink('Nuevo Usuario')->link(), "Ez da menu berria sortzeko formularioa aurkitu");

        $photo = '//Users/ikerib/avatar/avatar.png';
        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form();
        $form['gitek_backendbundle_usuario[nombre]']  = 'Test';
        $form['gitek_backendbundle_usuario[apellidos]']  = 'Test';
        $form['gitek_backendbundle_usuario[encargado]']  = '0';
        $form['gitek_backendbundle_usuario[avatarImg]']->upload($photo);

        $crawler = $client->submit($form);
        //$content = $client->getResponse()->getContent();
        //file_put_contents('somefile', $content);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');


        $crawler = $client->click($crawler->selectLink('Editar')->link());

        $photo = '//Users/ikerib/avatar/avatar04.png';
        $form = $crawler->selectButton('Grabar')->form();
        $form['gitek_backendbundle_usuario[nombre]']  = 'tesT';
        $form['gitek_backendbundle_usuario[apellidos]'] = '999';
        $form['gitek_backendbundle_usuario[encargado]']  = '0';
        $form['gitek_backendbundle_usuario[avatarImg]']->upload($photo);

        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('td:contains("tesT")')->count(), 'Missing element [value="tesT"]');
        $crawler = $client->click($crawler->selectLink('Eliminar')->link());
        $crawler = $client->followRedirect();
        $this->assertNotRegExp('/tesT/', $client->getResponse()->getContent());

    }


}
