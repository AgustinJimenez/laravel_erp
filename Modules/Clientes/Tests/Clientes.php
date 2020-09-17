<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Clientes extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }


    use DatabaseTransactions;

    public function testNewUserRegistration()
    {
        $this->visit('auth/register')
            ->type('bob', 'name')
            ->type('hello1@in.com', 'email')
            ->type('hello1', 'password')
            ->type('hello1', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/');
    }
}
