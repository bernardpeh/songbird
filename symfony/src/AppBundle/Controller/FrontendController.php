<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class FrontendController extends Controller
{
    /**
     * @Route("/{slug}", name="app_frontend_index", requirements = {"slug" = "^((|home)$)"})
     * @Method("GET")
     * @param Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $page = $this->getDoctrine()->getRepository('AppBundle:Page')->findOneBySlug($request->get('_route_params')['slug']);
        $pagemeta = $this->getDoctrine()->getRepository('AppBundle:PageMeta')->findPageMetaByLocale($page, $request->getLocale());
        $rootMenuItems = $this->getDoctrine()->getRepository('AppBundle:Page')->findParent();

        return array(
            'pagemeta' => $pagemeta,
            'tree' => $rootMenuItems,
        );
    }


    /**
     * @Route("/{slug}", name="app_frontend_view")
     * @Method("GET")
     */
    public function pageAction(Request $request)
    {

        $page = $this->getDoctrine()->getRepository('AppBundle:Page')->findOneBySlug($request->get('_route_params')['slug']);
        $pagemeta = $this->getDoctrine()->getRepository('AppBundle:PageMeta')->findPageMetaByLocale($page, $request->getLocale());
        $rootMenuItems = $this->getDoctrine()->getRepository('AppBundle:Page')->findParent();

        return array(
            'pagemeta' => $pagemeta,
            'tree' => $rootMenuItems,
        );
    }
}
