<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class LocaleController extends Controller
{
    /**
     * Redirects user based on their referer
     *
     * @Route("/{_locale}/locale", name="app_set_locale")
     * @Method("GET")
     */
    public function setLocaleAction(Request $request, $_locale)
    {
        $auth_checker = $this->get('security.authorization_checker');

        // if referrer exists, redirect to referrer
        $referer = $request->headers->get('referer');
        if ($referer) {
            return $this->redirect($referer);
        }
        // if logged in, redirect to dashboard
        elseif ($auth_checker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('dashboard');
        }
        // else redirect to homepage
        else {
            return $this->redirect('/');
        }
    }
}