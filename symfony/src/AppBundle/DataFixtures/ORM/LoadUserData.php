<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $userManager = $this->container->get('fos_user.user_manager');

        // add admin user
        $admin = $userManager->createUser();
        $admin->setUsername('admin');
        $admin->setEmail('admin@songbird.app');
        $admin->setPlainPassword('admin');
        $userManager->updatePassword($admin);
        $admin->setEnabled(1);
        $admin->setFirstname('Admin Firstname');
        $admin->setLastname('Admin Lastname');
        $admin->setRoles(array('ROLE_SUPER_ADMIN'));
        $admin->setImage('test_profile.jpg');
        $userManager->updateUser($admin);

        // add test user 1
        $test1 = $userManager->createUser();
        $test1->setUsername('test1');
        $test1->setEmail('test1@songbird.app');
        $test1->setPlainPassword('test1');
        $userManager->updatePassword($test1);
        $test1->setEnabled(1);
        $test1->setFirstname('test1 Firstname');
        $test1->setLastname('test1 Lastname');
        $test1->setImage('test_profile.jpg');
        $userManager->updateUser($test1);

        // add test user 2
        $test2 = $userManager->createUser();
        $test2->setUsername('test2');
        $test2->setEmail('test2@songbird.app');
        $test2->setPlainPassword('test2');
        $userManager->updatePassword($test2);
        $test2->setEnabled(1);
        $test2->setFirstname('test2 Firstname');
        $test2->setLastname('test2 Lastname');
        $test2->setImage('test_profile.jpg');
        $userManager->updateUser($test2);

        // add test user 3
        $test3 = $userManager->createUser();
        $test3->setUsername('test3');
        $test3->setEmail('test3@songbird.app');
        $test3->setPlainPassword('test3');
        $userManager->updatePassword($test3);
        $test3->setEnabled(0);
        $test3->setFirstname('test3 Firstname');
        $test3->setLastname('test3 Lastname');
        $test3->setImage('test_profile.jpg');
        $userManager->updateUser($test3);

        // use this reference in data fixtures elsewhere
        $this->addReference('admin_user', $admin);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        // load user data
        return 1;
    }
}
