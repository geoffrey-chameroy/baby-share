<?php

use App\Tests\FunctionalTester;
use Codeception\Util\HttpCode;

class HomeCest
{
    public function tryHome(FunctionalTester $I)
    {
        $I->amLoggedAsUser();
        $I->amOnPage('/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Accueil', 'h1');
        $I->seeNumberOfElements('.img-fluid', '12');
    }
}
