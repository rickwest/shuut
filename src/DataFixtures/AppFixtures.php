<?php

namespace App\DataFixtures;

use App\Entity\VehicleType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Add vehicle types
        $vt = (new VehicleType(VehicleType::SMALL_VAN))->setName('Small Van');
        $manager->persist($vt);
        $vt = (new VehicleType(VehicleType::SWB))->setName('SWB Panel');
        $manager->persist($vt);
        $vt = (new VehicleType(VehicleType::LWB))->setName('LWB Panel');
        $manager->persist($vt);
        $vt = (new VehicleType(VehicleType::LUTON))->setName('CS Luton');
        $manager->persist($vt);
        $vt = (new VehicleType(VehicleType::SEVEN_HALF_TONNE))->setName('7.5 Tonne');
        $manager->persist($vt);
        $vt = (new VehicleType(VehicleType::SPECIAL))->setName('Special');
        $manager->persist($vt);
        $manager->flush();
    }
}
