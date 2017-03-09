<?php
namespace As_An_Admin;

use \AcceptanceTester;
use \Common;

/**
 * AS An Admin
 * I WANT TO manage pages
 * SO THAT I can update them anytime.
 *
 * Class IWantToManagePagesCest
 * @package As_An_Admin
 */
class IWantToManagePagesCest
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
        $I->click('Page Management');
    }

    /**
     * GIVEN List Pages
     * WHEN I go to page list url
     * THEN I can see 2 elements under the about slug
     *
     * scenario 19.11
     * @before login
     */
    public function listPages(AcceptanceTester $I)
    {
        // there should be 3 parent menus
        $I->canSeeNumberOfElements('//div[@id="nestable"]/ol/li', 3);
        // there should be 2 entries under the about menu
        $I->click('Expand All');
        $I->canSeeNumberOfElements('//li[@data-id="2"]/ol/li', 2);
    }

    /**
     * GIVEN Show Contact Us Page
     * WHEN I go to contact_us page
     * THEN I should see the word "contact_us" and the word "Created"
     *
     * scenario 19.12
     * @before login
     */
    public function showContactUsPage(AcceptanceTester $I)
    {
        $I->click('contact_us');
        // i should see "en: Contact_us"
        $I->canSee('en: Contact');
    }

    /**
     * GIVEN Reorder home
     * WHEN I drag and drop the home menu to under the about menu|
     * THEN I should see "reordered successfully message" in the response and see 3 items under the about menu
     *
     * scenario 19.13
     * @before login
     */
    public function reorderHomePage(AcceptanceTester $I)
    {
        $I->click('Expand All');
        $I->dragAndDrop('//li[@data-id="4"]/div', '//li[@data-id="1"]/div');
        $I->waitForText('menu has been reordered successfully');
        // we should now have 4 main li
        $I->canSeeNumberOfElements('//div[@id="nestable"]/ol/li', 4);
        // refresh page and reorder it back to original state
        // $I->click('Page Management');
        // $I->click('Expand All');
        // $I->dragAndDrop('//li[@data-id="4"]/div', '//li[@data-id="3"]/div');
        // $I->waitForText('menu has been reordered successfully');
        // $I->canSeeNumberOfElements('//div[@id="nestable"]/ol/li', 3);
        Common::resetDB();
    }

    /**
     * GIVEN edit home page meta
     * WHEN I go to edit homepage url and update the menu title of "Home" to "Home1" and click update
     * THEN I should see the menu updated to home1.
     * scenario 19.14
     * @before login
     */
    public function editHomePage(AcceptanceTester $I)
    {
        $I->click('home');
        $I->fillField('//input[@name="page[slug]"]', 'home1');
        // update
        $I->click('Save changes');
        // back at page management page, i should see home1
        $I->click('Page Management');
        $I->canSee('home1');
        // $I->click('home1');
        // $I->fillField('//input[@name="page[slug]"]', 'home');
        // update
        // $I->click('Save changes');
        // $I->click('Page Management');
        // $I->canSee('home');
        Common::resetDB();
    }

    /**
     * GIVEN Create and delete test page
     * WHEN I go to page list and click "Add new page" and fill in details and click "Create" button, go to newly created test page and create 2 new test meta. Delete one testmeta and then delete the whole test page
     * THEN I should see the first pagemeta being created and deleted. Then see the second testmeta being deleted when the page is being deleted.
     *
     * scenario 19.15
     * @before login
     */
    public function createDeleteTestPage(AcceptanceTester $I)
    {
        // add new page
        $I->click('New Page');
        $I->fillField('//input[@name="page[slug]"]', 'test_page');
        $I->fillField('//input[@name="page[sequence]"]', '1');
        $I->selectOption('#page_parent', 'about');
        $I->click('//input[@name="page[isPublished]"]');
        $I->click('Save changes');
        // add new page meta
        $I->click('Page Management');
        $I->click('New Pagemeta');
        $I->fillField('//input[@name="pagemeta[page_title]"]', 'test page title');
        $I->fillField('//input[@name="pagemeta[menu_title]"]', 'test menu title');
        $I->selectOption('#pagemeta_page', 'test_page');
        $I->click('Save changes');
        // now back to list page. we check that the page contains meta
        $I->click('Page Management');
        $I->click('Expand All');
        $I->click('test_page');
        $I->canSee('en: test menu title');
        $I->click('Delete');
        $I->waitForElementVisible('#modal-delete-button');
        $I->click('#modal-delete-button');
        // now back to list page.
        $I->click('Expand All');
        $I->cantSee('test_page');
    }

    /**
     * GIVEN Delete Contact Us Page|
     * WHEN I go to contact us page and click "delete"
     * THEN I should see that the contact us page and its associate meta being deleted
     *
     * scenario 19.16
     * @before login
     */
    public function deleteContactUsPage(AcceptanceTester $I)
    {
        $I->click('contact_us');
        $I->click('Delete');
        $I->waitForElementVisible('#modal-delete-button');
        $I->click('#modal-delete-button');
        // we now connect to do and make sure the page and pagemetas are updated.
        $I->cantSee('contact_us');
        // this page doesn't exists in page menu
        $I->amOnPage('/admin/?entity=PageMeta&action=list');
        $I->cantSee('Contact Us');
        Common::resetDB();
    }

    /**
     * GIVEN Create new page with existing locale|
     * WHEN I go to page list and click "Add new pagemeta" and fill in details, select locale as en, page as home and click "Create" button
     * THEN I should see an exception
     *
     * scenario 19.17
     * @before login
     */
    public function singleLocalePerPageMeta(AcceptanceTester $I)
    {
        $I->click('New Pagemeta');
        $I->fillField('//input[@name="pagemeta[page_title]"]', 'test page title');
        $I->fillField('//input[@name="pagemeta[menu_title]"]', 'test menu title');
        $I->click('Save changes');
        // we should get an error
        $I->canSee('500 Internal Server Error');
    }
}
