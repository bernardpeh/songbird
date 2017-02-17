<?php
namespace As_Test1_User;

use \AcceptanceTester;
use \Common;

/**
 * AS a test1 user
 * I WANT to manage my profile
 * SO THAT I can update it any time
 *
 * Class IWantToManageMyOwnProfileCest
 * @package As_Test1_User
 */
class IWantToManageMyOwnProfileCest
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
     * GIVEN Show my profile
     * WHEN I go to "/admin/?action=show&entity=User&id=2"
     * THEN I should see test1@songbird.app and an Image field
     *
     * Scenario 10.4.1
     * @before login
     */
    public function showMyProfile(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/?action=show&entity=User&id=2');
        $I->canSee('test1@songbird.app');
        $I->canSee('Email');
        // get original image
        $imagePath = $I->grabFromDatabase('user', 'image', array('username' => 'test1'));
        // can see new image
        $I->waitForElement('//img[contains(@src, "'.$imagePath.'")]');
        $I->canSeeFileFound($imagePath, '../../web/uploads/profiles');
    }

    /**
     * GIVEN Hid uneditable fields
     * WHEN I go to "/admin/?action=edit&entity=User&id=2"
     * THEN I should not see enabled and roles fields
     *
     * Scenario 10.4.2
     * @before login
     */
    public function hidUneditableFields(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/?action=edit&entity=User&id=2');
        $I->cantSee('Enabled');
        $I->cantSee('Roles');
    }

    /**
     * GIVEN Update Firstname Only
     * WHEN I go to "/admin/?action=edit&entity=User&id=2" And update firstname only And Submit
     * THEN I should see content updated
     *
     * Scenario 10.4.3
     * @before login
     */
    public function updateFirstnameOnly(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/?action=edit&entity=User&id=2');
        $I->fillField('//input[@value="test1 Lastname"]', 'lastname1 updated');
        // submit form
        $I->click('//button[@type="submit"]');
        // i am on the show page
        $I->canSeeInCurrentUrl('/admin/?action=show&entity=User&id=2');
        $I->canSee('lastname1 updated');
        // now revert changes
        $I->amOnPage('/admin/?action=edit&entity=User&id=2');
        $I->fillField('//input[@value="lastname1 updated"]', 'test1 Lastname');
        // update
        $I->click('//button[@type="submit"]');
    }

    /**
     * GIVEN Update Password Only
     * WHEN I go to "/admin/?action=edit&entity=User&id=2" And update password And Submit And Logout And Login Again
     * THEN I should see content updated And be able to login with the new password
     *
     * Scenario 10.4.4
     * @before login
     */
    public function updatePasswordOnly(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/?action=edit&entity=User&id=2');
        $I->fillField('//input[contains(@id, "_plainPassword_first")]', '123');
        $I->fillField('//input[contains(@id, "_plainPassword_second")]', '123');
        // update
        $I->click('//button[@type="submit"]');
        // // I should be able to login with the new password
        $I->amOnPage('/logout');
        Common::login($I, TEST1_USERNAME, '123');
        // i can login and at dashboard now
        $I->canSee('Dear test1');
        // reset everything back
        $I->amOnPage('/admin/?action=edit&entity=User&id=2');
        $I->fillField('//input[contains(@id, "_plainPassword_first")]', TEST1_PASSWORD);
        $I->fillField('//input[contains(@id, "_plainPassword_second")]', TEST1_PASSWORD);
        $I->click('//button[@type="submit"]');
        // i am on the show page
        $I->canSeeInCurrentUrl('/admin/?action=show&entity=User&id=2');
        // i should be able to login with the old password
        $this->login($I);
        $I->canSee('Dear test1');
    }

    /**
     * GIVEN Delete and Add profile image
     * WHEN I go to edit profile page And delete profile image and add a new image
     * THEN I should see an empty profile, previous profile image gone and then a new one appearing in the file system
     *
     * Scenario 10.4.5
     * @before login
     */
    public function deleteAndAddProfileImage(AcceptanceTester $I)
    {
        // FIle upload doesn't work for phantomjs, will relook this at a later stage
        return;

        // get original image
        $imagePath = $I->grabFromDatabase('user', 'image', array('username' => 'test1'));
        // check image available
        $I->canSeeFileFound($imagePath, getcwd().'/web/uploads/profiles');
        $I->click('test1');
        $I->click('Edit');
        $I->click('//input[@id="user_imageFile_delete"]');
        // submit form
        $I->click('//button[@type="submit"]');
        // i am on the show page
        $I->waitForText('NULL');
        // check that image is not there
        $I->cantSeeFileFound($imagePath, getcwd().'/web/uploads/profiles');
        // now revert changes
        $I->click('Edit');
        $I->waitForElementVisible('//input[@type="file"]');
        $I->attachFile('//input[@id="user_imageFile_file"]', 'test_profile.jpg');
        // update
        $I->click('//button[@type="submit"]');
        // get image from db
        $imagePath = $I->grabFromDatabase('user', 'image', array('username' => 'test1'));
        // check image available
        $I->canSeeFileFound($imagePath, getcwd().'/web/uploads/profiles');
    }

    /**
     * GIVEN Update profile image Only
     * WHEN I go to edit profile page And update profile image and submit
     * THEN I should see user profile updated and previous profile image gone from file system
     *
     * Scenario 10.4.6
     * @before login
     */
    public function updateProfileImageOnly(AcceptanceTester $I)
    {
        // FIle upload doesn't work for phantomjs, will relook this at a later stage
        return;

        // get original image
        $imagePath = $I->grabFromDatabase('user', 'image', array('username' => 'test1'));
        // check image available
        $I->canSeeFileFound($imagePath, getcwd().'/web/uploads/profiles');
        $I->click('test1');
        $I->click('Edit');
        $I->attachFile('//input[@type="file"]', 'test_profile.jpg');
        // submit form
        $I->click('//button[@type="submit"]');
        // get new id
        $imagePath = $I->grabFromDatabase('user', 'image', array('username' => 'test1'));
        // i am on the show page
        $I->canSeeInCurrentUrl('/admin/?action=show&entity=User&id=2');
        // can see new image
        $I->waitForElement('//img[contains(@src, "'.$imagePath.'")]');
        $I->canSeeFileFound($imagePath, getcwd().'/web/uploads/profiles');
    }
}
