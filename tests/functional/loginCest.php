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
        $I->see('Hey, connecte toi pour voir mes photos !', 'p');
        $I->submitForm('form', ['_username' => 'user@test.fr', '_password' => 'user']);
        $I->seeCurrentUrlEquals('/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Accueil', 'h1');
    }

    public function tryLoginFail(FunctionalTester $I)
    {
        $I->amOnPage('/sign-in');
        $I->submitForm('form', ['_username' => 'user@test.fr', '_password' => 'mauvais']);
        $I->seeCurrentUrlEquals('/sign-in');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Invalid credentials', 'p');
    }

    public function tryLoginHelper(FunctionalTester $I)
    {
        $I->amLoggedAsUser();
        $I->amOnPage('/');
        $I->seeCurrentUrlEquals('/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->see('Accueil', 'h1');
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