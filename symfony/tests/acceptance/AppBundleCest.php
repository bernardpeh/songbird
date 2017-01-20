<?php


class AppBundleCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function InstallationTest(AcceptanceTester $I)
    {
        $I->wantTo('Check if Symfony is installed successfully.');
        $I->amOnPage('/');
        $I->see('Welcome to');
    }
}
