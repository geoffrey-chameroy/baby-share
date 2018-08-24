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
        $I->see('Les dernières photos partagées', 'h2');
        $I->seeNumberOfElements('.img-fluid', '4');
    }
}
