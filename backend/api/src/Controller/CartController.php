<?php

namespace App\Controller;

use App\Entity\Carts;
use App\Repository\CartsRepository;
use App\Repository\ProductsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
	#[Route('/api/carts/{userId}', name: 'app_list_cart', methods: ['GET'])]
	public function listCart(int $userId, CartsRepository $cartsRepository, ProductsRepository $productsRepository): JsonResponse
	{
		$carts = $cartsRepository->findBy(['user_id' => $userId]);

		if (empty($carts)) {
			return new JsonResponse(['message' => 'No items in the cart'], Response::HTTP_OK);
		}

		$cartData = [];

		foreach ($carts as $cart) {
			$product = $productsRepository->find($cart->getProductId()->getId());
			if ($product) {
				$cartData[] = [
					'product_id' => $cart->getProductId()->getId(),
					'product_name' => $product->getName(),
					'quantity' => $cart->getQuantity(),
					'created_at' => $cart->getCreatedAt()->format('Y-m-d H:i:s'),
				];
			}
		}
		return new JsonResponse($cartData, Response::HTTP_OK);
	}

	#[Route('/api/carts/{userId}/{productId}', name: 'app_add_to_cart', methods: ['POST'])]
	public function addToCart(
		int                $userId,
		int                $productId,
		Request            $request,
		CartsRepository    $cartsRepository,
		ProductsRepository $productsRepository,
		UsersRepository    $userRepository
	): JsonResponse
	{
		$user = $userRepository->find($userId);
		$product = $productsRepository->find($productId);

		if (!$user) {
			return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
		}

		if (!$product) {
			return new JsonResponse(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
		}

		$quantity = (int)$request->get('quantity', 1);

		$cartItem = $cartsRepository->findOneBy(['user_id' => $user, 'product_id' => $product]);

		if ($cartItem) {
			// Update quantity if product already in cart
			$cartItem->setQuantity($cartItem->getQuantity() + $quantity);
			$cartItem->setUpdatedAt(new \DateTimeImmutable());
		} else {
			// Create new cart item
			$cartItem = new Carts();
			$cartItem->setUserId($user)
				->setProductId($product)
				->setQuantity($quantity)
				->setCreatedAt(new \DateTimeImmutable());
		}

		$cartsRepository->save($cartItem, true);

		return new JsonResponse(['message' => 'Product added to cart'], Response::HTTP_CREATED);
	}

	#[Route('/api/carts/{userId}/{productId}', name: 'app_remove_from_cart', methods: ['DELETE'])]
	public function removeFromCart(
		int                $userId,
		int                $productId,
		CartsRepository    $cartsRepository,
		UsersRepository    $userRepository,
		ProductsRepository $productsRepository
	): JsonResponse
	{
		$user = $userRepository->find($userId);
		$product = $productsRepository->find($productId);

		if (!$user) {
			return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
		}

		if (!$product) {
			return new JsonResponse(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
		}

		$cartItem = $cartsRepository->findOneBy(['user_id' => $user, 'product_id' => $product]);

		if (!$cartItem) {
			return new JsonResponse(['message' => 'Product not in cart'], Response::HTTP_NOT_FOUND);
		}

		$cartsRepository->remove($cartItem, true);

		return new JsonResponse(['message' => 'Product removed from cart'], Response::HTTP_OK);
	}

}
