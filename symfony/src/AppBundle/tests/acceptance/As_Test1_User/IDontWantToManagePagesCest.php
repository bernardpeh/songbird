<?php

namespace As_Test1_User;
use \AcceptanceTester;
use \Common;

/**
 * AsS test1 user
 * I DONT't WANT to manage pages
 * SO THAT I don't breach security
 *
 * Class IDontWantToManagePagesCest
 * @package As_Test1_User
 */
class IDontWantToManagePagesCest
{
    public function _before(AcceptanceTester $I)
    {
    }
    public function _after(AcceptanceTester $I)
    {
    }
    protected function login(AcceptanceTester $I)
    {
        Common::login($I, TEST1_USERNAME, TEST1_PASSWORD);
    }

    /**
     * GIVEN List pages
     * WHEN I go to the page management url
     * THEN I should get a access denied message
     *
     * Scenario 19.21
     * @before login
     */
    public function listPages(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/?entity=Page&action=list');
        $I->canSee('403');
    }

    /**
     * GIVEN show about us page
     * WHEN I go to show about us url
     * THEN I should get a access denied message
     *
     * Scenario 19.22
     * @before login
     */
    public function showAboutUsPage(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/?entity=Page&action=show&id=2');
        $I->canSee('403');
    }

    /**
     * GIVEN edit about us page
     * WHEN I go to edit about us url
     * THEN I should get a access denied message
     *
     * Scenario 19.23
     * @before login
     */
    public function editAboutUsPage(AcceptanceTester $I) {
        $I->amOnPage('/admin/?entity=Page&action=edit&id=2');
        $I->canSee('403');
    }

    /**
     * GIVEN List pagemeta
     * WHEN I go to list pagemeta url
     * THEN I should get a access denied message
     *
     * Scenario 19.234
     * @before login
     */
    public function listPageMeta(AcceptanceTester $I) {
        $I->amOnPage('/admin/?entity=PageMeta&action=list');
        $I->canSee('403');
    }
}
