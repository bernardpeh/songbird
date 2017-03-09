<?php
namespace As_Test1_User;

use \AcceptanceTester;
use \Common;

/**
 * AS a test1 user,
 * I DONT'T WANT to manage other profiles
 * SO THAT I don't breach security
 *
 * Class IShouldNotBeAbleToManageOtherProfilesCest
 * @package As_Test1_User
 */
class IShouldNotBeAbleToManageOtherProfilesCest
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
     * GIVEN List all profiles
     * WHEN I go to "/admin/?action=list&entity=User" url
     * THEN I should see a list of all users in a table with image fields and not see show, edit and delete button
     *
     * Scenario 10.5.1
     * @before login
     */
    public function listAllProfiles(AcceptanceTester $I)
    {
        $I->click('User Management');
        $I->canSeeNumberOfElements('//table/tbody/tr', 4);
        $I->seeNumberOfElements('//td[@data-label="Image"]', 4);
        $I->cantSee('Show');
        $I->cantSee('Edit');
        $I->cantSee('Delete');
    }

    /**
     * GIVEN Show test2 profile
     * WHEN I go to "/admin/?action=show&entity=User&id=3"
     * THEN I should see "test2 Firstname"
     *
     * Scenario 10.5.2
     * @before login
     */
    public function showTest2Profile(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/?action=show&entity=User&id=3');
        $I->canSee('403');
    }

    /**
     * Scenario 10.5.3
     * @before login
     */
    public function editTest2Profile(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/?action=edit&entity=User&id=3');
        $I->canSee('403');
    }
    /**
     * GIVEN Edit test2 user profile
     * WHEN I go to "/admin/?action=edit&entity=User&id=3"
     * THEN I should see "Dear test1"
     *
     * Scenario 10.5.4
     * @before login
     */
    public function seeAdminDashboardContent(AcceptanceTester $I)
    {
        $I->canSee('Dear test1');
    }
}
