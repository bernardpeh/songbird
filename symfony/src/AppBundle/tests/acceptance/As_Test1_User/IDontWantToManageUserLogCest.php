<?php

namespace As_Test1_User;

use \AcceptanceTester;
use \Common;

/**
 * AS test1 user
 * I DONT want to manage user logs
 * SO THAT I don't breach security
 *
 * Class IDontWantToManageUserLogCest
 * @package As_Test1_User
 */
class IDontWantToManageUserLogCest
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
     * GIVEN List user log|
     * WHEN I go to the user log url
     * THEN I should get an access denied message
     *
     * Scenario 15.2.1
     * @before login
     */
    public function listUserLogs(AcceptanceTester $I)
    {
        $I->cantSee('User Log');
        $I->amOnPage('/admin/?entity=UserLog&action=list');
        $I->canSee('403');
    }

    /**
     * GIVEN Show log 1
     * WHEN I go to the show log id 1 url
     * THEN I should get an access denied message
     *
     * Scenario 15.2.2
     * @before login
     */
    public function showFirstEntry(AcceptanceTester $I)
    {
        // go to user listing page
        $I->amOnPage('/admin/?entity=UserLog&action=show&id=1');
        $I->canSee('403');
    }

    /**
     * GIVEN Edit log 1
     * WHEN I go to the edit log id 1 url|
     * THEN I should get an access denied message
     *
     * Scenario 15.2.3
     * @before login
     */
    public function editFirstEntry(AcceptanceTester $I)
    {
        // go to user listing page
        $I->amOnPage('/admin/?entity=UserLog&action=edit&id=1');
        $I->canSee('403');
    }
}
