<?php
// src/AppBundle/DataFixtures/ORM/Fixtures.php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        Fixtures::load(__DIR__.'/fixtures.yml',$manager);
    }
}