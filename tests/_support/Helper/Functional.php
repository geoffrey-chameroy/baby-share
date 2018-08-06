<?php
namespace App\Tests\Helper;

use Codeception\Module\Symfony;

class Functional extends \Codeception\Module
{
    public function amLoggedAsUser()
    {
        try {
            /** @var Symfony $I */
            $I = $this->getModule('Symfony');
            $I->amOnPage('/sign-in');
            $I->submitForm('form', ['_username' => 'user@test.fr', '_password' => 'user']);
        } catch (\Exception $e) {
            $this->debug($e->getMessage());
        }
    }
}
