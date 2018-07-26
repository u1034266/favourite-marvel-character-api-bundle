<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        /* Get Auth Errors */
        $errors = $authenticationUtils->getLastAuthenticationError();

        /* Get Last Username */
        $lastUserName = $authenticationUtils->getLastUsername();

        return $this->render('AppBundle:Login:login.html.twig', array(
            'errors' => $errors,
            'username' => $lastUserName
        ));
    }

    /*
     * Logout action
     *
     * @Route("/logout", name="logout")
     * */
    public function logoutAction () {
        return $this->render('AppBundle:Login.login.html.twig');
    }

}
