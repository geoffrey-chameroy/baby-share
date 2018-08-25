<?php

use App\Tests\FunctionalTester;
use Codeception\Util\HttpCode;

class loginCest
{
    public function tryLogin(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->seeCurrentUrlEquals('/sign-in');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Connecte toi pour voir les photos !', 'h4');
        $I->submitForm('form', ['_username' => 'user@test.fr', '_password' => 'user']);
        $I->seeCurrentUrlEquals('/');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function tryLoginFail(FunctionalTester $I)
    {
        $I->amOnPage('/sign-in');
        $I->submitForm('form', ['_username' => 'user@test.fr', '_password' => 'mauvais']);
        $I->seeCurrentUrlEquals('/sign-in');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Identifiants invalides.', 'p');
    }

    public function tryLoginHelper(FunctionalTester $I)
    {
        $I->amLoggedAsUser();
        $I->amOnPage('/');
        $I->seeCurrentUrlEquals('/');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function tryReLogin(FunctionalTester $I)
    {
        $I->amLoggedAsUser();
        $I->amOnPage('/sign-in');
        $I->seeCurrentUrlEquals('/');
    }

    public function tryLogout(FunctionalTester $I)
    {
        $I->amLoggedAsUser();
        $I->amOnPage('/');
        $I->see('Déconnexion', 'a');

        $I->click('Déconnexion', 'a');
        $I->seeCurrentUrlEquals('/sign-in');

        $I->amOnPage('/');
        $I->seeCurrentUrlEquals('/sign-in');
    }
}
