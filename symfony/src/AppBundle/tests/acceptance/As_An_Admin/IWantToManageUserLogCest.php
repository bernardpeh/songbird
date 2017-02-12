<?php
namespace As_An_Admin;
use \AcceptanceTester;
use \Common;

/**
 * AS an admin user
 * I WANT to manage user logs
 * SO THAT I can check on user activity anytime.
 *
 * Class IWantToManageUserLogCest
 * @package As_An_Admin
 */
class IWantToManageUserLogCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    protected function login(AcceptanceTester $I)
    {
        Common::login($I, ADMIN_USERNAME, ADMIN_PASSWORD);
    }

    /**
     * GIVEN List user log
     * WHEN I click on user log on the left menu|
     * I should see more than 1 row in the table
     *
     * Scenario 15.1.1
     * @before login
     */
    public function listUserLogs(AcceptanceTester $I)
    {
        $I->click('User Log');
        $tr = $I->grabMultiple('//tr');
        $I->assertGreaterThan(1, count($tr));
    }

    /**
     * GIVEN Show user log 1
     * WHEN I go to the first log entry
     * I should see the text "/admin/dashboard"
     *
     * Scenario 15.1.2
     * @before login
     */
    public function showFirstEntry(AcceptanceTester $I)
    {
        // go to user listing page
        $I->amOnPage('/admin/?entity=UserLog&action=show&id=1');
        $I->canSee('/admin/dashboard');
    }

}
