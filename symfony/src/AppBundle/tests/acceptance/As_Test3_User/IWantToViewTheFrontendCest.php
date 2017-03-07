<?php
namespace As_Test3_User;

use \AcceptanceTester;

/**
 * AS A test3 user
 * I WANT to browse the frontend
 * SO THAT I can get the information I want.
 *
 * Class IWantToViewTheFrontendCest
 * @package As_Test3_User
 */
class IWantToViewTheFrontendCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * GIVEN Home page is working
     * WHEN I go to the / or /home
     * THEN I can see the jumbotron class and the text "SongBird CMS Demo"
     *
     * scenario 20.11
     *
     * @param AcceptanceTester $I
     */
    public function homepageIsWorking(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->canSeeElement('.jumbotron');
        $I->canSee('SongBird CMS Demo');
    }

    /**
     * GIVEN Menus are working
     * WHEN I mouseover the about menu
     * THEN I should see 2 menus under the about menu
     *
     * scenario 20.12
     * @param AcceptanceTester $I
     */
    public function menusAreWorking(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        // should be able to use the movemouseover method but its not working on bootstrap
        $I->canSeeNumberOfElements('//ul[@id="top_menu"]/li', 6);
    }

    /**
     * GIVEN Subpages are working
     * WHEN I click on contact memu
     * THEN I should see the text "This project is hosted in"
     *
     * Scenario 20.13
     *
     * @param AcceptanceTester $I
     */
    public function subPagesAreWorking(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('Contact');
        $I->canSee('This project is hosted in');
    }

    /**
     * GIVEN Login menu is working
     * WHEN I click on login memu
     * THEN I should see 2 menu items only
     *
     * Scenario 20.14
     *
     * @param AcceptanceTester $I
     */
    public function loginMenuWorking(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('Log in');
        $I->canSeeNumberOfElements('//ul[@id="top_menu"]/li', 3);
    }
}
