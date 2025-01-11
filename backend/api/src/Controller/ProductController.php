<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
	#[Route('/api/product', name: 'app_all_product', methods: ['GET'])]
	public function allProducts(
		ProductsRepository $productsRepository
	): JsonResponse
	{
		$products = $productsRepository->findAll();
		if (empty($products)) {
			return new JsonResponse([
				'message' => 'Products not found'
			], Response::HTTP_NOT_FOUND);
		} else {
			$productData = array_map(function ($product) {
				return [
					'id' => $product->getId(),
					'name' => $product->getName(),
					'description' => $product->getDescription(),
					'ean' => $product->getEan(),
					'format' => $product->getFormat(),
					'price' => $product->getPrice(),
					'quantity' => $product->getQuantity(),
				];
			}, $products);
			return new JsonResponse([
				'products' => $productData,
			], Response::HTTP_OK);
		}
	}


	#[Route('/api/product/{id}', name: 'app_product', methods: ['GET'])]
	public function product(
		Request            $request,
		ProductsRepository $productsRepository
	): Response
	{
		$id = $request->attributes->get('id');
		$products = $productsRepository->find($id);
		if ($products) {
			return new JsonResponse([
				"id" => $products->getId(),
				"name" => $products->getName(),
				"description" => $products->getDescription(),
				"ean" => $products->getEan(),
				"format" => $products->getFormat(),
				"price" => $products->getPrice(),
				"quantity" => $products->getQuantity(),
			], Response::HTTP_OK);
		} else {
			return new JsonResponse([
				"message" => "Product not found",
			], Response::HTTP_NOT_FOUND);
		}
	}

	#[Route('/api/product-home', name: 'app_productHome', methods: ['GET'])]
	public function ProductHomePage(
		ProductsRepository $productsRepository
	): Response
	{
		$products = $productsRepository->findLastAddedProducts();
		if (empty($products)) {
			return new JsonResponse([
				'message' => 'Products not found'
			], Response::HTTP_NOT_FOUND);
		} else {
			$productData = array_map(function ($product) {
				return [
					'id' => $product->getId(),
					'name' => $product->getName(),
					'description' => $product->getDescription(),
					'ean' => $product->getEan(),
					'format' => $product->getFormat(),
					'price' => $product->getPrice(),
					'quantity' => $product->getQuantity(),
				];
			}, $products);
			return new JsonResponse([
				'products' => $productData,
			], Response::HTTP_OK);
		}
	}
}
