<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Customer;
use App\Entity\Driver;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Entity\VehicleType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DemoFixtures extends Fixture
{
    private $encoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = \Faker\Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        // Create an admin user
        $user = new User();
        $user
            ->setUsername('admin')
            ->setEmail('admin@test.com')
            ->setIsActive(true)
        ;
        $password = $this->encoder->encodePassword($user, '20E!xI&$Zx');
        $user->setPassword($password);

        $manager->persist($user);


        $user = new User();
        $user
            ->setUsername('pete')
            ->setEmail('P.C.Collingwood@shu.ac.uk')
            ->setIsActive(true)
        ;
        $password = $this->encoder->encodePassword($user, 'shuoop');
        $user->setPassword($password);

        $manager->persist($user);

        // Create some customers
        for ($i = 0; $i < 25; $i++) {
            $cust = new Customer();
            $cust
                ->setAccountRef('CUST000' . $i)
                ->setName($this->faker->company)
                ->setTelephone($this->faker->phoneNumber)
                ->setEmail($this->faker->companyEmail)
                ->setContactName($this->faker->name)
                ->setAddress($this->address())
            ;
            $manager->persist($cust);
        }

        // Create some vehicles
        for ($i = 0; $i < 15; $i++) {
            $vehicle = new Vehicle();
            $vehicle
                ->setRegistration(strtoupper($this->vehicleReg()))
                ->setModel(ucfirst($this->faker->word))
                ->setMake(ucfirst($this->faker->word))
                ->setVehicleType($manager->getReference(VehicleType::class, $this->vehicleTypes()[array_rand($this->vehicleTypes())]))
                ->setDepth($this->faker->randomFloat(2, 0, 100))
                ->setWidth($this->faker->randomFloat(2, 0, 100))
                ->setHeight($this->faker->randomFloat(2, 0, 100))
            ;
            $manager->persist($vehicle);
        }

        // Create some drivers
        for ($i = 0; $i < 15; $i++) {
            $driver = new Driver();
            $driver
                ->setName($this->faker->name)
                ->setTelephone($this->faker->phoneNumber)
                ->setEmail($this->faker->freeEmail)
                ->setTradingName($driver->getName())
                ->setAddress($this->address())
                ->setSubcontractor(false)
            ;
            $manager->persist($driver);
        }
        $manager->flush();
    }

    public function address()
    {
        return (new Address())
            ->setLine1($this->faker->streetAddress)
            ->setCity($this->faker->city)
            ->setCountry($this->faker->country)
            ->setPostcode($this->faker->postcode)
        ;
    }

    public function vehicleTypes()
    {
        return [
            VehicleType::SMALL_VAN,
            VehicleType::SWB,
            VehicleType::LWB,
            VehicleType::LUTON,
            VehicleType::SEVEN_HALF_TONNE,
            VehicleType::SPECIAL,
        ];
    }

    public function vehicleReg()
    {
        $reg  = $this->faker->randomLetter;
        $reg .= $this->faker->randomLetter;
        $reg .= $this->faker->randomNumber(2);
        $reg .= ' ';
        $reg .= $this->faker->randomLetter;
        $reg .= $this->faker->randomLetter;
        $reg .= $this->faker->randomLetter;
        return $reg;
    }
}
