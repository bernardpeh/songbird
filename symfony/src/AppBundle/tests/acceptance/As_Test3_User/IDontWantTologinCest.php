<?php
namespace As_test3_user;

use \AcceptanceTester;
use \Common;

/**
 * AS a test3 user
 * I DONT WANT to login successfully
 * SO THAT I can prove that this account is disabled
 *
 * Class IDontWantTologinCest
 * @package As_test3_user
 */
class IDontWantTologinCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * GIVEN Account disabled
     * WHEN I login with the right credentials
     * THEN I should see an "account disabled" message
     *
     * Scenario 10.3.1
     */
    public function AccountDisabled(AcceptanceTester $I) {
        Common::login($I, TEST3_USERNAME, TEST3_PASSWORD);
        // i can login and at dashboard now
        $I->canSee('Account is disabled.');
    }
}