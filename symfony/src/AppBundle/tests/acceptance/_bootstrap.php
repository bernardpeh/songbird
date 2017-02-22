<?php
// Here you can initialize variables that will be available to your tests
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin');
define('TEST1_USERNAME', 'test1');
define('TEST1_PASSWORD', 'test1');
define('TEST2_USERNAME', 'test2');
define('TEST2_PASSWORD', 'test2');
// test3 Account is disabled. See data fixtures to confirm.
define('TEST3_USERNAME', 'test3');
define('TEST3_PASSWORD', 'test3');

class Common
{
    public static function login(AcceptanceTester $I, $user, $pass)
    {
        $I->amOnPage('/login');
        $I->fillField('_username', $user);
        $I->fillField('_password', $pass);
        $I->click('_submit');
    }
}
