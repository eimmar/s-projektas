<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;

class RegisterTest extends WebTestCase
{

    public function testRegisterPage()
    {
        $client = static::createClient();

        $client->request('GET', 'http://127.0.0.1:8000/register');
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRegisterForm()
    {
        $client = static::createClient();
        $client->request('GET', 'http://127.0.0.1:8000/register');
        $crawler = $client->followRedirect();
        $form = $crawler->filter('.fos_user_registration_register')->form(array(
            'fos_user_registration_form[email]' => 'test@test.com',
            'fos_user_registration_form[plainPassword][first]' => 'testpss',
            'fos_user_registration_form[plainPassword][second]' => 'testpss',
            'fos_user_registration_form[firstName]' => 'test',
            'fos_user_registration_form[lastName]' => 'test',
        ));
        $client->submit($form);

        //test response
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

}