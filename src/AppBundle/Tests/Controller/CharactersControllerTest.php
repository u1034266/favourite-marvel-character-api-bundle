<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharactersControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/index');
    }

    public function testFavouritecharacter()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/favouriteCharacter');
    }

    public function testAllcharacters()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/allCharacters');
    }

}
