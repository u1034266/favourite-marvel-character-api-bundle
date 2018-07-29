<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
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
            return $this->favouriteCharacterAction($response,0);

        }

        /* Default Action */
        $response = $client->getCharacters();
        $totalCharactersCount = 0;
        foreach ($response as $element) {
            $totalCharactersCount += 1;
        }

        return $this->render('AppBundle:Characters:index.html.twig', array(
            'response' => $response,
            'totalCharacters' => $totalCharactersCount
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
     * @Route("/setFavourite/{characterid}", name="setFavourite")
     */
    public function setFavouriteAction($characterid)
    {
        /* Fetch Entity data */
        $entityManager = $this->getDoctrine()->getManager();
        $userCharacter = $entityManager->getRepository(User::class)->find($this->getUser()->getId());

        /* Throw Error */
        if (!$userCharacter) {
            throw $this->createNotFoundException(
                'User does not exist in this Universe!'
            );
        }

        $userCharacter->setCharacterid($characterid);

        $entityManager->flush();

        return $this->indexAction();
    }

    /**
     * @Route("/newFavourite", name="newFavourite")
     */
    public function newFavouriteAction()
    {
        /* Fetch Entity data */
        $entityManager = $this->getDoctrine()->getManager();
        $userCharacter = $entityManager->getRepository(User::class)->find($this->getUser()->getId());

        /* Throw Error */
        if (!$userCharacter) {
            throw $this->createNotFoundException(
                'User does not exist in this Universe!'
            );
        }

        $userCharacter->setCharacterid(0);

        $entityManager->flush();

        return $this->indexAction();
    }

}