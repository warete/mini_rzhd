<?php

namespace App\DataFixtures;

use App\Entity\Station;
use App\Entity\Train;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
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
				->setMaxSeatsCnt(random_int(30, 50));
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
				for ($o = 0; $o < random_int(1, 5); $o++)
				{
					$route = (new \App\Entity\Route())
						->setStationFrom($stationFrom)
						->setStationTo($stationTo)
						->setPrice(random_int(1000, 7000))
						->setDateStart((new \DateTime())->modify(sprintf('-% days', random_int(0, 10))))
						->setDateEnd((new \DateTime())->modify(sprintf('+% days', random_int(0, 10))));
					$trainIndexStart = random_int(0, count($stations) - 1);
					for ($k = $trainIndexStart; $k < $trainIndexStart + 5; $k++)
					{
						$route->addTrain($trains[$k]);
					}
					$manager->persist($route);
				}
			}
		}

		$manager->flush();
    }
}
