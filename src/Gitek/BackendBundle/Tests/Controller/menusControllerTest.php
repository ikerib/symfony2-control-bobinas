<?php

namespace Gitek\BackendBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MenusControllerTest extends WebTestCase
{

    public function testMenusCompleteScenario()
    {
        // Nabigatzailea sortu
        $client = static::createClient();

        // Orrira sartzen den frogatu
        $crawler = $client->request('GET', '/admin/menus');
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/");
        $this->assertCount(1, $crawler->filter('h1:contains("Mantenimiento de menus")'),"¿Se encuentra en el mantenimiento de menus?");

        // Menu Berria sortu
        $crawler = $client->click($crawler->selectLink('Nuevo Menu')->link(), "Ez da menu berria sortzeko formularioa aurkitu");

        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'menus[texto]'  => 'Test',
            'menus[orden]'  => '666',
        ), "Ez da menu berria sortzeko formularioa aurkitu");

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

//        // Edit the entity
//        $crawler = $client->click($crawler->selectLink('Edit')->link());
//
//        $form = $crawler->selectButton('Update')->form(array(
//            'gitek_backendbundle_menus[field_name]'  => 'Foo',
//            // ... other fields to fill
//        ));
//
//        $client->submit($form);
//        $crawler = $client->followRedirect();
//
//        // Check the element contains an attribute with value equals "Foo"
//        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');
//
//        // Delete the entity
//        $client->submit($crawler->selectButton('Delete')->form());
//        $crawler = $client->followRedirect();
//
//        // Check the entity has been delete on the list
//        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }
}
