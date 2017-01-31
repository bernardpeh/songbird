<?php
namespace As_Test1_User;

use \AcceptanceTester;
use \Common;

/**
 * AS a test1 user
 * I WANT to login
 * SO THAT I can access admin functions
 *
 * Class IWantToLoginCest
 * @package As_Test1_User
 */
class IWantToLoginCest
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
     * GIVEN Wrong login credentials
     * WHEN I login with the wrong credentials
     * THEN I should see an error message
     *
     * Scenario 10.1.1
     */
    public function wrongLoginCredentials(AcceptanceTester $I) {
        Common::login($I, TEST1_USERNAME, '123');
        $I->canSee('Invalid credentials');
    }

    /**
     * GIVEN See my dashboard content
     * WHEN I login correctly
     * THEN I should see Access Denied
     *
     * Scenario 10.1.2
     * @before login
     */
    public function seeMyDashboardContent(AcceptanceTester $I) {
        $I->canSee('403');
    }

    /**
     * GIVEN Logout successfully
     * WHEN I go to the logout url
     * THEN I should be redirected to the home page
     *
     * Scenario 10.1.3
     * @before login
     */
    public function logoutSuccessfully(AcceptanceTester $I) {
        $I->amOnPage('/logout');
        // now user should be redirected to home page
        $I->canSeeInCurrentUrl('/');
    }

    /**
     * GIVEN Access admin url without logging in
     * WHEN go to admin url without logging in
     * THEN I should be redirected to the login page
     *
     * Scenario 10.1.4
     */
    public function AccessAdminWithoutLoggingIn(AcceptanceTester $I) {
        $I->amOnPage('/admin/?action=list&entity=User');
        // now user should be redirected to login page
        $I->canSeeInCurrentUrl('/login');
    }
}