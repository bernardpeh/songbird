<?php

namespace As_Test1_User;
use \AcceptanceTester;
use \Common;

/**
 * AS test1 user
 * I WANT to reset my password without logging in
 * SO THAT have a way to access my account in case I forget or loses my password.
 *
 * Class IWantToResetPasswordWithoutLoggingInCest
 * @package As_Test1_User
 */
class IWantToResetPasswordWithoutLoggingInCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    protected function login(AcceptanceTester $I, $username=TEST1_USERNAME, $password=TEST1_PASSWORD)
    {
        Common::login($I, $username, $password);
    }

    /**
     * GIVEN Reset Password Successfully
     * WHEN I click on forget password in the login page and go through the whole resetting process
     * THEN I should be redirected to the dashboard.
     *
     * Scenario 11.1.1
     * @param AcceptanceTester $I
     */
    public function resetPasswordSuccessfully(AcceptanceTester $I)
    {
        // reset emails
        $I->resetEmails();
        $I->amOnPage('/login');
        $I->click('forget password');
        $I->fillField('//input[@id="username"]', 'test1');
        $I->click('_submit');
        $I->canSee('It contains a link');

        // Clear old emails from MailCatcher
        $I->seeInLastEmail("Hello test1");
        $link = $I->grabFromLastEmail('@http://(.*)@');
        $I->amOnUrl($link);

        // The password has been reset successfully
        $I->fillField('//input[@id="fos_user_resetting_form_plainPassword_first"]', '1111');
        $I->fillField('//input[@id="fos_user_resetting_form_plainPassword_second"]', '1111');
        $I->click('_submit');
        // at dashbpard, i should see access denied
        $I->canSee('403');
        // now at show page
        $I->amOnPage('/admin/?action=show&entity=User&id=2');
        $I->canSee('The password has been reset successfully');

        // now login with the new password
        $this->login($I, TEST1_USERNAME, '1111');

        // db has been changed. update it back
        $I->amOnPage('/admin/?action=edit&entity=User&id=2');
        $I->fillField('//input[contains(@id, "_plainPassword_first")]', TEST1_USERNAME);
        $I->fillField('//input[contains(@id, "_plainPassword_second")]', TEST1_PASSWORD);
        $I->click('//button[@type="submit"]');
        // i am on the show page
        $I->canSeeInCurrentUrl('/admin/?action=show&entity=User&id=2');

        // i not should be able to login with the old password
        $this->login($I);
        $I->canSee('403');
    }
}