<?php

namespace Songbird\NestablePageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Songbird\NestablePageBundle\Entity\Page;
use Songbird\NestablePageBundle\Entity\PageMeta;

class LoadPageData extends AbstractFixture implements ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $homepage = new Page();
        $homepage->setSlug('home');
        $homepage->setIsPublished(1);
        $homepage->setSequence(0);
        // there is no relationship with the user entity atm
        // $homepage->setUser($this->getReference('admin_user'));
        $manager->persist($homepage);

        $homemetaEN = new PageMeta();
        $homemetaEN->setPage($homepage);
        $homemetaEN->setMenuTitle('Home');
        $homemetaEN->setPageTitle('Welcome to SongBird CMS Demo');
        $homemetaEN->setShortDescription('Welcome to SongBird CMS Demo');
        $homemetaEN->setContent('<p>SongBird is a simple CMS built with popular bundles like FOSUserBundle and SonataAdminBundle.
            The CMS is meant to showcase Rapid Application Development with Symfony.</p>');
        $manager->persist($homemetaEN);

        $homemetaFR = new PageMeta();
        $homemetaFR->setPage($homepage);
        $homemetaFR->setMenuTitle('Accueil');
        $homemetaFR->setPageTitle('Bienvenue a SongBird CMS Démo');
        $homemetaFR->setShortDescription('Bienvenue a SongBird CMS Démo');
        $homemetaFR->setLocale('fr');
        $homemetaFR->setContent('<p>SongBird est un simple CMS construit avec des faisceaux populaires comme FOSUserBundle et SonataAdminBundle.
            Le CMS est destinée à mettre en valeur Rapid Application Development avec Symfony .</p>');
        $manager->persist($homemetaFR);

        $aboutpage = new Page();
        $aboutpage->setSlug('about');
        $aboutpage->setIsPublished(1);
        $aboutpage->setSequence(1);
        $manager->persist($aboutpage);

        $aboutmetaEN = new PageMeta();
        $aboutmetaEN->setPage($aboutpage);
        $aboutmetaEN->setMenuTitle('About');
        $aboutmetaEN->setPageTitle('About SongBird');
        $aboutmetaEN->setShortDescription('What is Songbird?');
        $aboutmetaEN->setContent('<p>SongBird is a simple CMS (Content Management System) consisting the following features:</p>
        <ul>
        <li>Admin Panel and Dashboard – A password protected administration area for administrators and users.</li>
        <li>User Management System – For administrators to manage the users of the site.</li>
        <li>Multi-lingual Capability – No CMS is complete without this.</li>
        <li>Page Management System – For managing the front-end pages of the site.</li>
        <li>Media Management System – For administrators and users to manage files and images.</li>
        <li>Frontend – The frontend of the website.</li>
        </ul>');
        $manager->persist($aboutmetaEN);

        $aboutmetaFR = new PageMeta();
        $aboutmetaFR->setPage($aboutpage);
        $aboutmetaFR->setLocale('fr');
        $aboutmetaFR->setMenuTitle('Sur');
        $aboutmetaFR->setPageTitle('Sur SongBird');
        $aboutmetaFR->setShortDescription('Qu\'est-ce que SongBird?');
        $aboutmetaFR->setContent('<p>SongBird est un simple CMS ( Content Management System ) comprenant les caractéristiques suivantes:</p>
        <ul>
        <li>Panneau d\'administration et Dashboard - Un mot de passe protégé espace d\'administration pour les administrateurs et les utilisateurs.</li>
        <li>Système de gestion de l\'utilisateur - Pour les administrateurs de gérer les utilisateurs du site.</li>
        <li>Capacité multilingue - Pas de CMS est complète sans cela.</li>
        <li>Système de Management de la page - Pour gérer les pages du site frontaux.</li>
        <li>Système de Gestion des médias - Pour les administrateurs et les utilisateurs de gérer des fichiers et des images.</li>
        <li>Frontend - L\'interface du site.</li>
        </ul>');
        $manager->persist($aboutmetaFR);


        $whypage = new Page();
        $whypage->setSlug('why_songbird');
        $whypage->setIsPublished(1);
        $whypage->setSequence(0);
        $whypage->setParent($aboutpage);
        $manager->persist($whypage);

        $whymetaEN = new PageMeta();
        $whymetaEN->setPage($whypage);
        $whymetaEN->setMenuTitle('Why Songbird');
        $whymetaEN->setPageTitle('Why Songbird?');
        $whymetaEN->setShortDescription('Why Another CMS?');
        $whymetaEN->setContent('<p>Learning a modern day framework is not an easy task. Songbird CMS does not aim to replace any existing CMS out there.
        To put it simply, it is a play ground for people who wants to learn Symfony by building a CMS from scratch.
        Creating a semi-complex application like a CMS will give the coder insights in building bigger
        things with a RAD framework like Symfony.</p>');
        $manager->persist($whymetaEN);

        $whymetaFR = new PageMeta();
        $whymetaFR->setPage($whypage);
        $whymetaFR->setMenuTitle('pourquoi SongBird');
        $whymetaFR->setPageTitle('pourquoi SongBird?');
        $whymetaFR->setShortDescription('Pourquoi un autre CMS');
        $whymetaFR->setContent('<p>Apprendre un cadre moderne est pas une tâche facile . Songbird CMS ne vise pas à remplacer tout CMS existant là-bas.
        Pour dire les choses simplement , il est un terrain de jeu pour les gens qui veulent apprendre symfony en construisant un CMS à partir de zéro.
        Création d\'une application semi- complexe comme un CMS donnera les idées de codeur dans la construction de plus
        les choses avec un cadre RAD comme Symfony</p>');
        $whymetaFR->setLocale('fr');
        $manager->persist($whymetaFR);

        $planpage = new Page();
        $planpage->setSlug('documentation');
        $planpage->setIsPublished(1);
        $planpage->setSequence(1);
        $planpage->setParent($aboutpage);
        $manager->persist($planpage);

        $planmetaEn = new PageMeta();
        $planmetaEn->setPage($planpage);
        $planmetaEn->setMenuTitle('Where do I start');
        $planmetaEn->setPageTitle('Where do I start?');
        $planmetaEn->setShortDescription('Where Do I Start?');
        $planmetaEn->setContent('<p>I recommend reading the online documentation at <a href="https://leanpub.com/practicalsymfony3">leanpub</a></p>
            <p>git clone the repo. Read and Code at the same time. I believe that is the most effective way to learn.</p>');
        $manager->persist($planmetaEn);

        $planmetaFR = new PageMeta();
        $planmetaFR->setPage($planpage);
        $planmetaFR->setLocale('fr');
        $planmetaFR->setMenuTitle('Où est-ce que je commence');
        $planmetaFR->setPageTitle('Où est-ce que je commence?');
        $planmetaFR->setShortDescription('Où est-ce que je commence?');
        $planmetaFR->setContent('<p>Je recommande la lecture de la documentation en ligne à <a href="https://leanpub.com/practicalsymfony3">leanpub</a></p>
            <p>git clone the repo. Lire et code en même temps . Je crois que la façon la plus efficace d\'apprendre.</p>');
        $manager->persist($planmetaFR);

        $contactpage = new Page();
        $contactpage->setSlug('contact_us');
        $contactpage->setIsPublished(1);
        $contactpage->setSequence(2);
        $manager->persist($contactpage);

        $contactmetaEN = new PageMeta();
        $contactmetaEN->setPage($contactpage);
        $contactmetaEN->setPageTitle('Contact Us');
        $contactmetaEN->setMenuTitle('Contact');
        $contactmetaEN->setShortDescription('Contact');
        $contactmetaEN->setContent('<p>I hope Songbird can be beneficial to anyone who aspires to learn Symfony.</p>
            <p>This project is hosted in <a href="https://github.com/bernardpeh/songbird" target="_blank">github</a>.</p>
            <p>To make this CMS a better learning platform for everyone, feel free to update the code and create a pull request in github.</p>');
        $manager->persist($contactmetaEN);

        $contactmetaFR = new PageMeta();
        $contactmetaFR->setPage($contactpage);
        $contactmetaFR->setLocale('fr');
        $contactmetaFR->setPageTitle('Contactez nous');
        $contactmetaFR->setMenuTitle('Contact');
        $contactmetaFR->setShortDescription('Contact');
        $contactmetaFR->setContent('<p>Je l\'espère Songbird peut être bénéfique pour toute personne qui aspire à apprendre symfony.</p>
            <p>Ce projet est hébergé dans <a href="https://github.com/bernardpeh/songbird" target="_blank">github</a>.</p>
            <p>Pour faire ce CMS une meilleure plateforme d\'apprentissage pour tout le monde , vous pouvez mettre à jour le code et créer une demande de traction dans github.</p>');
        $manager->persist($contactmetaFR);

        // now save all
        $manager->flush();
    }

}
