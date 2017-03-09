<?php

namespace As_An_Admin;

use \AcceptanceTester;
use \Common;

/**
 * AS AN Admin User
 * I WANT TO manage all users
 * So THAT I can control user access of the system
 *
 * Class IWantToManageAllUsersCest
 * @package As_An_Admin
 */
class IWantToManageAllUsersCest
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
     * GIVEN List all profiles
     * WHEN I go to "/admin/?action=list&entity=User" url
     * THEN I should see a list of all users in a table with image fields
     *
     * Scenario 10.6.1
     * @before login
     */
    public function listAllProfiles(AcceptanceTester $I)
    {
        $I->click('User Management');
        $I->canSeeNumberOfElements('//table/tbody/tr', 4);
        $I->seeNumberOfElements('//td[@data-label="Image"]', 4);
    }

    /**
     * GIVEN Show test3 user
     * WHEN I go to "/admin/?action=show&entity=User&id=4" url
     * THEN I should see test3 user details
     *
     * Scenario 10.6.2
     * @before login
     */
    public function showTest3User(AcceptanceTester $I)
    {
        // go to user listing page
        $I->click('User Management');
        // click on show button
        $I->click('Show');
        $I->waitForText('test3@songbird.app');
        $I->canSee('test3@songbird.app');
    }

    /**
     * GIVEN Edit test3 user
     * WHEN I go to "/admin/?action=edit&entity=User&id=4" url And update lastname
     * THEN I should see test3 lastname updated on the "List all users" page
     *
     * Scenario 10.6.3
     * @before login
     */
    public function editTest3User(AcceptanceTester $I)
    {
        // go to user listing page
        $I->click('User Management');
        // click on edit button
        $I->click('Edit');
        // check we are on the right url
        $I->canSeeInCurrentUrl('/admin/?action=edit&entity=User');
        $I->fillField('//input[@value="test3 Lastname"]', 'lastname3 updated');
        // update
        $I->click('//button[@type="submit"]');
        // go back to listing page
        $I->click('User Management');
        $I->canSee('lastname3 updated');
        // now revert username
        // $I->amOnPage('/admin/?action=edit&entity=User&id=4');
        // $I->fillField('//input[@value="lastname3 updated"]', 'test3 Lastname');
        // $I->click('//button[@type="submit"]');
        // $I->click('User Management');
        // $I->canSee('test3 Lastname');
        Common::resetDB();
    }

    /**
     * GIVEN Create and Delete new user
     * WHEN I go to "/admin/?action=new&entity=User" And fill in the required fields And Submit And Delete the new user
     * THEN I should see the new user created and deleted again in the listing page.
     *
     * Scenario 10.6.4
     * @before login
     */
    public function createAndDeleteNewUser(AcceptanceTester $I)
    {
        // go to create page and fill in form
        $I->amOnPage('/admin/?action=new&entity=User');
        $I->fillField('//input[contains(@id, "_username")]', 'test4');
        $I->fillField('//input[contains(@id, "_email")]', 'test4@songbird.app');
        $I->fillField('//input[contains(@id, "_plainPassword_first")]', 'test4');
        $I->fillField('//input[contains(@id, "_plainPassword_second")]', 'test4');
        // submit form
        $I->click('//button[@type="submit"]');
        // go back to user list
        $I->amOnPage('/admin/?entity=User&action=list');
        // i should see new test4 user created
        $I->canSee('test4@songbird.app');

        // now delete user
        // click on edit button
        $I->click('Delete');
        // wait for model box and then click on delete button
        $I->waitForElementVisible('//button[@id="modal-delete-button"]');
        $I->click('//button[@id="modal-delete-button"]');
        // I can no longer see test4 user
        $I->cantSee('test4@songbird.app');
        Common::resetDB();
    }
}
