<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;

class LoginTest extends WebTestCase
{

    public function testLoginPage()
    {
        $client = static::createClient();

        $client->request('GET', 'http://127.0.0.1:8000/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLoginForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/login');
        //$crawler = $client->followRedirect();
        $form = $crawler->filter('.form-signin')->form(array(
            '_username' => 'user@usermail.com',
            '_password' => 'password',
        ));

        $client->submit($form);
        $client->followRedirect();
        //test response
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

}