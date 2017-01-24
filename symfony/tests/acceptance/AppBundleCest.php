<?php


class AppBundleCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * check that homepage is not active
     *
     * @param AcceptanceTester $I
     */
    public function RemovalTest(AcceptanceTester $I)
    {
        $I->wantTo('Check if / is not active.');
        $I->amOnPage('/');
        $I->see('404 Not Found');
    }
}
