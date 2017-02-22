<?php

namespace As_An_Admin;

use \AcceptanceTester;
use \Common;

/**
 * AS AN admin user
 * I WANT TO login
 * SO THAT I can access admin functions
 *
 * Class IWantToLoginCest
 * @package As_An_Admin
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
        Common::login($I, ADMIN_USERNAME, ADMIN_PASSWORD);
    }
    /**
     * GIVEN Wrong login credentials
     * WHEN I login with the wrong credentials
     * THEN I should see an error message
     *
     * Scenario 10.2.1
     */
    public function wrongLoginCredentials(AcceptanceTester $I)
    {
        Common::login($I, ADMIN_USERNAME, '123');
        $I->canSee('Invalid credentials');
    }
    /**
     * GIVEN See my dashboard content
     * WHEN I login correctly
     * THEN I should see the text "User Management" and "Dear Admin"
     *
     * Scenario 10.2.2
     * @before login
     */
    public function seeMyDashboardContent(AcceptanceTester $I)
    {
        $I->canSeeInCurrentUrl('/admin/dashboard');
        $I->canSee('Dear Admin');
        $I->canSee('User Management');
    }

    /**
     * GIVEN Logout successfully
     * WHEN I go to the logout url
     * THEN I should be redirected to the home page
     *
     * Scenario 10.2.3
     * @before login
     */
    public function logoutSuccessfully(AcceptanceTester $I)
    {
        $I->amOnPage('/logout');
        // now user should be redirected to home page and it should be access denied for now.
        $I->canSeeInCurrentUrl('/');
    }
    /**
     * GIVEN Access admin url without logging in
     * WHEN I go to admin url without logging in
     * THEN I should be redirected to the login page
     *
     * Scenario 10.2.4
     */
    public function AccessAdminWithoutLoggingIn(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/?action=list&entity=User');
        // now user should be redirected to login page
        $I->canSeeInCurrentUrl('/login');
    }
}
