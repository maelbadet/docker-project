<?php

namespace App\Controller;

use App\Entity\Favorites;
use App\Repository\FavoritesRepository;
use App\Repository\ProductsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
	#[Route('/api/addFavorite', name: 'app_add_favorite', methods: ['POST'])]
	public function addFavorite(
		Request                $request,
		EntityManagerInterface $entityManager,
		ProductsRepository     $productsRepository,
		UsersRepository        $userRepository,
		FavoritesRepository    $favoritesRepository
	): JsonResponse
	{
		$data = json_decode($request->getContent(), true);
		$userId = $data['user_id'] ?? null;
		$productId = $data['product_id'] ?? null;

		if (!$userId || !$productId) {
			return new JsonResponse(['error' => 'Missing user_id or product_id'], Response::HTTP_BAD_REQUEST);
		}

		$user = $userRepository->find($userId);
		$product = $productsRepository->find($productId);

		if (!$user || !$product) {
			return new JsonResponse(['error' => 'User or Product not found'], Response::HTTP_NOT_FOUND);
		}

		$existingFavorite = $favoritesRepository->findOneBy(['user' => $user, 'product' => $product]);

		if ($existingFavorite) {
			return new JsonResponse(['message' => 'Product already in favorites'], Response::HTTP_CONFLICT);
		}

		$favorite = new Favorites();
		$favorite->setUserId($user);
		$favorite->setProductId($product);
		$favorite->setCreatedAt(new \DateTimeImmutable());
		$favorite->setUpdatedAt(new \DateTimeImmutable());

		$entityManager->persist($favorite);
		$entityManager->flush();

		return new JsonResponse(['message' => 'Product added to favorites'], Response::HTTP_CREATED);
	}


	#[Route('/api/removeFavorite', name: 'app_remove_favorite', methods: ['POST'])]
	public function removeFavorite(
		Request                $request,
		EntityManagerInterface $entityManager,
		FavoritesRepository    $favoritesRepository
	): JsonResponse
	{
		$data = json_decode($request->getContent(), true);
		$userId = $data['user_id'] ?? null;
		$productId = $data['product_id'] ?? null;

		if (!$userId || !$productId) {
			return new JsonResponse(['error' => 'Missing user_id or product_id'], Response::HTTP_BAD_REQUEST);
		}

		$favorite = $favoritesRepository->findOneBy(['user' => $userId, 'product' => $productId]);

		if (!$favorite) {
			return new JsonResponse(['error' => 'Favorite not found'], Response::HTTP_NOT_FOUND);
		}

		$entityManager->remove($favorite);
		$entityManager->flush();

		return new JsonResponse(['message' => 'Product removed from favorites'], Response::HTTP_OK);
	}

	#[Route('/api/favorites/{userId}', name: 'app_list_favorites', methods: ['GET'])]
	public function listFavorites(
		int $userId,
		FavoritesRepository $favoritesRepository,
		ProductsRepository $productsRepository,
		UsersRepository $userRepository
	): JsonResponse {
		$user = $userRepository->find($userId);

		if (!$user) {
			return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
		}

		$favorites = $favoritesRepository->findBy(['user' => $userId, 'deleted_at' => null]);

		if (empty($favorites)) {
			return new JsonResponse(['message' => 'No favorites found'], Response::HTTP_OK);
		}

		$favoritesData = array_map(function ($favorite) use ($productsRepository) {
			$product = $productsRepository->find($favorite->getProductId());
			return [
				'id' => $favorite->getId(),
				'product_id' => $favorite->getProductId(),
				'product_name' => $product ? $product->getName() : null,
				'created_at' => $favorite->getCreatedAt()->format('Y-m-d H:i:s'),
			];
		}, $favorites);

		return new JsonResponse($favoritesData, Response::HTTP_OK);
	}

	#[Route('/api/checkFavorite', name: 'app_check_favorite', methods: ['POST'])]
	public function checkFavorite(
		Request                $request,
		EntityManagerInterface $entityManager,
		ProductsRepository     $productsRepository,
		UsersRepository        $userRepository,
		FavoritesRepository    $favoritesRepository
	): JsonResponse
	{
		try {
			$data = json_decode($request->getContent(), true);
			$userId = $data['user_id'] ?? null;
			$productId = $data['product_id'] ?? null;

			if (!$userId || !$productId) {
				return new JsonResponse(['error' => 'Missing user_id or product_id'], Response::HTTP_BAD_REQUEST);
			}

			$user = $userRepository->find($userId);
			$product = $productsRepository->find($productId);

			if (!$user || !$product) {
				return new JsonResponse(['error' => 'User or Product not found'], Response::HTTP_NOT_FOUND);
			}

			$existingFavorite = $favoritesRepository->findOneBy(['user' => $user, 'product' => $product]);

			return new JsonResponse([
				'isFavorite' => $existingFavorite ? true : false
			], Response::HTTP_OK);
		} catch (\Exception $e) {
			return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

}
