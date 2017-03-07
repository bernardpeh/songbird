<?php

namespace AppBundle\Twig\Extension;

/**
 * Twig Extension to get Menu title based on locale
 */
class MenuLocaleTitle extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    private $em;

	/**
	 * @var $request
	 */
	private $request;

	/**
	 * MenuLocaleTitle constructor.
	 *
	 * @param $em
	 * @param $request
	 */
    public function __construct($em, $request)
    {
        $this->em = $em;
        $this->request = $request->getCurrentRequest();
    }

	/**
	 * @return string
	 */
    public function getName()
    {
        return 'menu_locale_title_extension';
    }

	/**
	 * @return array
	 */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getMenuLocaleTitle', array($this, 'getMenuLocaleTitle'))
        );
    }

	/**
	 * @param string $slug
	 *
	 * @return mixed
	 */
    public function getMenuLocaleTitle($slug = 'home')
    {
	    $locale = ($this->request) ? $this->request->getLocale() : 'en';
    	$page = $this->em->getRepository('AppBundle:Page')->findOneBySlug($slug);
	    $pagemeta = $this->em->getRepository('AppBundle:PageMeta')->findPageMetaByLocale($page, $locale);

    	return $pagemeta->getMenuTitle();
    }
}
