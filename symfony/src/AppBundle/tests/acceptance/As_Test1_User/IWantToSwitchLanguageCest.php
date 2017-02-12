<?php
namespace As_Test1_User;
use \AcceptanceTester;
use \Common;

/**
 * AS test1 user
 * I want to be able to switch language
 * SO THAT I can choose my preferred language anytime.
 *
 * Class IWantToSwitchLanguageCest
 * @package As_Test1_User
 */
class IWantToSwitchLanguageCest
{
    public function _before(AcceptanceTester $I)
    {
        Common::login($I, TEST1_USERNAME, TEST1_PASSWORD);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * GIVEN Locale in french
     * WHEN I login and switch language to french
     * THEN I should be able to see the dashboard in french till I switched back to english
     *
     * Scenario 13.1.1
     */
    public function localeInFrench(AcceptanceTester $I)
    {
        // switch to french
        $I->selectOption('//select[@id="lang"]', 'fr');
        // I should be able to see "my profile" in french
        $I->waitForText('Déconnexion');
        $I->canSee('Déconnexion');
        $I->click('test1');
        // now in show profile page
        $I->waitForText('Éditer');
        $I->canSee('Éditer');
        // now switch back to english
        $I->selectOption('//select[@id="lang"]', 'en');
        $I->waitForText('Edit');
        $I->canSee('Edit');
    }
}
