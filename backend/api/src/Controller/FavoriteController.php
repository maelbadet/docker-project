<?php

namespace App\Controller;

use App\Repository\FavoritesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FavoriteController extends AbstractController
{
    #[Route('/api/addFavorite', name: 'app_add_favorite', methods: ['POST'])]
    public function addFavorite(
		Request $request,
		FavoritesRepository $favoritesRepository,
	): Response
    {
        return $this->render('favorite/index.html.twig', [
            'controller_name' => 'FavoriteController',
        ]);
    }

	#[Route('/api/removeFavorite', name: 'app_remove_favorite', methods: ['POST'])]
	public function removeFavorite(): Response
	{
		return $this->render('favorite/index.html.twig', [
			'controller_name' => 'FavoriteController',
		]);
	}
}
