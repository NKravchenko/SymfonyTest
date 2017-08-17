<?php
/**
 * Created by PhpStorm.
 * User: jimm
 * Date: 16.08.17
 * Time: 19:21
 */

namespace Acme\AcmeNewsBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {

       $objects = Fixtures::load(__DIR__.'/fixtures.yml', $manager);
    }

}