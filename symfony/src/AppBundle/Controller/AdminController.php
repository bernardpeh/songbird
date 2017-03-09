<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use JavierEguiluz\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\PageMeta;

class AdminController extends BaseAdminController
{
    /**
     * @Route("/dashboard", name="dashboard")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function dashboardAction(Request $request)
    {
        return $this->render('@EasyAdmin/default/dashboard.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showUserAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_SHOW);
        $id = $this->request->query->get('id');
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];

        $fields = $this->entity['show']['fields'];

        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            unset($fields['created']);
        }

        $deleteForm = $this->createDeleteForm($this->entity['name'], $id);

        return $this->render($this->entity['templates']['show'], array(
            'entity' => $entity,
            'fields' => $fields,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * when edit user action
     *
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editUserAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_EDIT);
        $id = $this->request->query->get('id');
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];

        if ($this->request->isXmlHttpRequest() && $property = $this->request->query->get('property')) {
            $newValue = 'true' === strtolower($this->request->query->get('newValue'));
            $fieldsMetadata = $this->entity['list']['fields'];

            if (!isset($fieldsMetadata[$property]) || 'toggle' !== $fieldsMetadata[$property]['dataType']) {
                throw new \RuntimeException(sprintf('The type of the "%s" property is not "toggle".', $property));
            }

            $this->updateEntityProperty($entity, $property, $newValue);

            return new Response((string)$newValue);
        }

        $fields = $this->entity['edit']['fields'];

        $editForm = $this->createEditForm($entity, $fields);
        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            $editForm->remove('enabled');
            $editForm->remove('roles');
            $editForm->remove('locked');
        }

        $deleteForm = $this->createDeleteForm($this->entity['name'], $id);

        $editForm->handleRequest($this->request);
        if ($editForm->isValid()) {
            $this->preUpdateUserEntity($entity);
            $this->em->flush();

            $refererUrl = $this->request->query->get('referer', '');

            return !empty($refererUrl)
                ? $this->redirect(urldecode($refererUrl))
                : $this->redirect($this->generateUrl('easyadmin', array('action' => 'show', 'entity' => $this->entity['name'], 'id' => $id)));
        }

        return $this->render($this->entity['templates']['edit'], array(
            'form' => $editForm->createView(),
            'entity_fields' => $fields,
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function prePersistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    public function preUpdateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    /**
     * Show Page List page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listPageAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_LIST);

        $rootMenuItems = $this->getDoctrine()->getRepository('AppBundle\Entity\Page')->findParent();

        return $this->render('@EasyAdmin/Page/list.html.twig', array(
            'tree' => $rootMenuItems,
        ));
    }

    /**
     * save page meta
     *
     * @param PageMeta $pageMeta
     */
    public function prePersistPageMetaEntity(PageMeta $pageMeta)
    {
        if ($this->em->getRepository('AppBundle\Entity\PageMeta')->findPageMetaByLocale($pageMeta->getPage(), $pageMeta->getLocale())) {
            throw new \RuntimeException($this->get('translator')->trans('one_locale_per_pagemeta_only', array(), 'BpehNestablePageBundle'));
        }
    }

    /**
     * edit page meta
     *
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editPageMetaAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_EDIT);

        $id = $this->request->query->get('id');
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];

        // get id before submission
        $pageMeta = $this->em->getRepository('AppBundle\Entity\PageMeta')->find($id);
        $origId = $pageMeta->getPage()->getId();
        $origLocale = $pageMeta->getLocale();

        if ($this->request->isXmlHttpRequest() && $property = $this->request->query->get('property')) {
            $newValue = 'true' === strtolower($this->request->query->get('newValue'));
            $fieldsMetadata = $this->entity['list']['fields'];

            if (!isset($fieldsMetadata[$property]) || 'toggle' !== $fieldsMetadata[$property]['dataType']) {
                throw new \RuntimeException(sprintf('The type of the "%s" property is not "toggle".', $property));
            }

            $this->updateEntityProperty($entity, $property, $newValue);

            return new Response((string) $newValue);
        }

        $fields = $this->entity['edit']['fields'];

        $editForm = $this->createEditForm($entity, $fields);
        $deleteForm = $this->createDeleteForm($this->entity['name'], $id);

        $editForm->handleRequest($this->request);
        if ($editForm->isValid()) {
            $this->dispatch(EasyAdminEvents::PRE_UPDATE, array('entity' => $entity));

            // if page and local is the same, dont need to check locale count
            if ($origLocale == $entity->getLocale() && $origId == $entity->getPage()->getId()) {
                // all good
            } elseif ($this->em->getRepository('AppBundle\Entity\PageMeta')->findPageMetaByLocale($pageMeta->getPage(), $pageMeta->getLocale(), true)) {
                throw new \RuntimeException($this->get('translator')->trans('one_locale_per_pagemeta_only', array(), 'BpehNestablePageBundle'));
            }

            $this->em->flush();

            $this->dispatch(EasyAdminEvents::POST_UPDATE, array('entity' => $entity));

            $refererUrl = $this->request->query->get('referer', '');

            return !empty($refererUrl)
                ? $this->redirect(urldecode($refererUrl))
                : $this->redirect($this->generateUrl('easyadmin', array('action' => 'list', 'entity' => $this->entity['name'])));
        }

        $this->dispatch(EasyAdminEvents::POST_EDIT);

        return $this->render($this->entity['templates']['edit'], array(
            'form' => $editForm->createView(),
            'entity_fields' => $fields,
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
