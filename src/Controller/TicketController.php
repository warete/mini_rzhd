<?php

namespace App\Controller;

use App\Entity\Station;
use App\Entity\Train;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
	/**
	 * @Route("/")
	 * @return Response
	 */
	public function main(ManagerRegistry $managerRegistry, Request $request): Response
	{
		$entityManager = $managerRegistry->getManager();

		$stations = $entityManager->getRepository(Station::class)
			->findAll();

		$routes = [];
		if ($request->get('station_from') && $request->get('station_to'))
		{
			$routes = $entityManager->getRepository(\App\Entity\Route::class)
				->findByStationsInDates(
					intval($request->get('station_from')),
					intval($request->get('station_to')),
					$request->get('date_start'),
					$request->get('date_end')
				);
		}

		return $this->render('main.html.twig', [
			'stations' => $stations,
			'routes' => $routes,
			'searchValues' => [
				'station_from' => $request->get('station_from'),
				'station_to' => $request->get('station_to'),
				'date_start' => $request->get('date_start'),
				'date_end' => $request->get('date_end'),
			],
			'isSearchStart' => $request->get('q') == 'y'
		]);
	}
}