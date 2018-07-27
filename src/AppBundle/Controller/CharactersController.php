<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
class CharactersController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction()
    {
        /*
         * Call the Marvel API Client
         * */
        $client = $this->get('marvel_api_client');

        /* Auth user has a fave marvel char? */
        if ($this->getUser()->getCharacterid() > 0) {

            $response = $client->getCharacter($this->getUser()->getCharacterid());
            return $this->favouriteCharacterAction($response);

        }

        /* Default Action */
        $response = $client->getCharacters();

        return $this->render('AppBundle:Characters:index.html.twig', array(
            'response' => $response
        ));
    }

    /**
     * @Route("/favouriteCharacter")
     */
    public function favouriteCharacterAction($response)
    {
        return $this->render('AppBundle:Characters:favourite_character.html.twig', array(
            'response' => $response
        ));
    }

    /**
     * @Route("/allCharacters")
     */
    public function allCharactersAction()
    {
        return $this->render('AppBundle:Characters:all_characters.html.twig', array(
            // ...
        ));
    }

}