<?php

namespace Songbird\NestablePageBundle\Controller;

use Songbird\NestablePageBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Page controller.
 *
 * @Route("/songbird_page")
 */
class PageController extends Controller
{

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="songbird_page_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('songbird_page_list'));
    }

    /**
     * Lists all nested page
     *
     * @Route("/list", name="songbird_page_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $rootMenuItems = $em->getRepository('SongbirdNestablePageBundle:Page')->findParent();

        return $this->render('page/list.html.twig', array(
            'tree' => $rootMenuItems,
        ));
    }

    /**
     * reorder pages
     *
     * @Route("/reorder", name="songbird_page_reorder")
     * @Method("POST")
     */
    public function reorderAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // id of affected element
        $id = $request->get('id');
        // parent Id
        $parentId = ($request->get('parentId') == '') ? null : $request->get('parentId');
        // new sequence of this element. 0 means first element.
        $position = $request->get('position');

        $result = $em->getRepository('SongbirdNestablePageBundle:Page')->reorderElement($id, $parentId, $position);

        return new JsonResponse(
            array('message' => $this->get('translator')->trans($result[0], array(), 'SongbirdNestablePageBundle')
            , 'success' => $result[1])
        );
    }

    /**
     * Creates a new Page entity.
     *
     * @Route("/new", name="songbird_page_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm('Songbird\NestablePageBundle\Form\PageType', $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('songbird_page_show', array('id' => $page->getId()));
        }

        return $this->render('page/new.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Route("/{id}", name="songbird_page_show")
     * @Method("GET")
     */
    public function showAction(Request $request, Page $page)
    {
        $em = $this->getDoctrine()->getManager();

        $pageMeta = $em->getRepository('SongbirdNestablePageBundle:PageMeta')->findPageMetaByLocale($page,$request->getLocale());

        $deleteForm = $this->createDeleteForm($page);

        return $this->render('page/show.html.twig', array(
            'page' => $page,
            'pageMeta' => $pageMeta,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/{id}/edit", name="songbird_page_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);
        $editForm = $this->createForm('Songbird\NestablePageBundle\Form\PageType', $page);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('songbird_page_edit', array('id' => $page->getId()));
        }

        return $this->render('page/edit.html.twig', array(
            'page' => $page,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Page entity.
     *
     * @Route("/{id}", name="songbird_page_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Page $page)
    {
        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();
        }

        return $this->redirectToRoute('songbird_page_index');
    }

    /**
     * Creates a form to delete a Page entity.
     *
     * @param Page $page The Page entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Page $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('songbird_page_delete', array('id' => $page->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
