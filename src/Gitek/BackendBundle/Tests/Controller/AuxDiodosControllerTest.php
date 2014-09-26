<?php

namespace Gitek\BackendBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuxDiodosControllerTest extends WebTestCase
{

    public function testAuxdiodosCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Orrira sartzen den frogatu
        $crawler = $client->request('GET', '/admin/auxdiodos/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/");
        $this->assertCount(1, $crawler->filter('h1:contains("Mantenimiento de Auxiliar de Diodos")'),"¿Se encuentra en el mantenimiento de menus?");



//        // Menu Berria sortu
        $crawler = $client->click($crawler->selectLink('Nueva Referencia')->link(), "Ez da referentzia berria sortzeko formularioa aurkitu");
//
//        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'gitek_backendbundle_auxdiodos[referencia]'  => 'Test',
        ));
//
        $client->submit($form);
        //$content = $client->getResponse()->getContent();
        //file_put_contents('somefile', $content);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');
        $h1_contents = array();

//        print_r($client->getRequest()->getRequestUri());

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Editar')->link());

        $form = $crawler->selectButton('Grabar')->form(array(
            'gitek_backendbundle_auxdiodos[referencia]'  => 'tesT',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

//        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('td:contains("tesT")')->count(), 'Missing element [value="tesT"]');

        // Delete the entity
        $crawler = $client->click($crawler->selectLink('Eliminar')->link());
        $crawler = $client->followRedirect();

//        // Check the entity has been delete on the list
        $this->assertNotRegExp('/tesT/', $client->getResponse()->getContent());

    }


}
