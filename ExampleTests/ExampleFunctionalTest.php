<?php

/*
 * This file is part of the Liip/FunctionalTestBundle
 *
 * (c) Lukas Kahwe Smith <smith@pooteeweet.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\FooBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\Console\Output\Output;

/**
 * @author Lukas Smith
 * @author Daniel Barsotti
 * @author Albert Jessurum
 */
class ExampleFunctionalTest extends WebTestCase
{
    /**
     * Example using LiipFunctionalBundle the fixture loader
     */
    public function testUserFooIndex()
    {
        $this->loadFixtures(array('Liip\FooBundle\Tests\Fixtures\LoadUserData'));

        $client = $this->createClient();
        $crawler = $client->request('GET', '/users/foo');

        $this->assertTrue($crawler->filter('html:contains("Email: foo@bar.com")')->count() > 0);
    }

   /**
    * Example using LiipFunctionalBundle WebTestCase helpers and with authentication
    */
    public function testBasicAuthentication()
    {
        $this->loadFixtures(array('Liip\FooBundle\Tests\Fixtures\LoadUserData'));

        $content = $this->fetchContent('/users/foo', 'GET', true);
        $this->assertEquals('Hello foo!', $content);

        // check if the logout button is shown
        $this->assertContains('logout', $content);
    }

    public function test404Page()
    {
        $this->fetchContent('/asdasdas', 'GET', false, false);
    }

    public function testLoginPage()
    {
        $content = $this->fetchContent('/', 'GET', false);
        $this->assertContains('login', $content);
    }
}
