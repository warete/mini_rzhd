<?php

namespace App\DataFixtures;

use App\Entity\Station;
use App\Entity\Ticket;
use App\Entity\Train;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
	protected $faker;

    public function load(ObjectManager $manager)
    {
    	$this->faker = Factory::create('ru_RU');

    	$users = [];
    	for ($i = 0; $i < $this->faker->numberBetween(5, 15); $i++)
		{
			[$firstName, $secondName, $lastName] = explode(' ', $this->faker->name);
			$user = (new User())
				->setName($firstName)
				->setLastName($lastName)
				->setSecondName($secondName);
			$manager->persist($user);
			$users[] = $user;
		}

		$stations = [];
		foreach ([
					 'Волгоград 1',
					 'Москва Павелецкая',
					 'Москва Киевская',
					 'Москва Курская',
					 'Санкт-Петербург Главный'
				 ] as $stationName)
		{
			$station = new Station();
			$station->setName($stationName);
			$manager->persist($station);
			$stations[] = $station;
		}

		$trains = [];
		for ($i = 0; $i < 20; $i++)
		{
			$train = (new Train())->setNumber(uniqid())
				->setMaxSeatsCnt($this->faker->numberBetween(30, 50));
			$manager->persist($train);
			$trains[] = $train;
		}

		foreach ($stations as $i => $stationFrom)
		{
			foreach ($stations as $j => $stationTo)
			{
				if ($i == $j)
				{
					continue;
				}
				for ($o = 0; $o < $this->faker->numberBetween(1, 5); $o++)
				{
					$route = (new \App\Entity\Route())
						->setStationFrom($stationFrom)
						->setStationTo($stationTo)
						->setPrice($this->faker->numberBetween(1000, 7000))
						->setDateStart((new \DateTime())->modify(sprintf('-% days', $this->faker->numberBetween(0, 10))))
						->setDateEnd((new \DateTime())->modify(sprintf('+% days', $this->faker->numberBetween(0, 10))));
					foreach ($this->faker->randomElements($trains, 5) as $train)
					{
						$route->addTrain($train);
					}
					$manager->persist($route);

					for ($l = 0; $l < $this->faker->numberBetween(0, 10); $l++)
					{
						$ticket = (new Ticket())
							->setIsPaid($this->faker->boolean())
							->setUser($this->faker->randomElement($users))
							->setRoute($route);
						$manager->persist($ticket);
					}
				}
			}
		}

		$manager->flush();
    }
}
