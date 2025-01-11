<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
	#[Route('/api/register', name: 'api_register', methods: ['POST'])]
	public function register(
		Request $request,
		EntityManagerInterface $entityManager,
		UserPasswordHasherInterface $passwordHasher
	): JsonResponse {
		$data = json_decode($request->getContent(), true);

		if (!$data || !isset($data['username'], $data['password'])) {
			return new JsonResponse(['status' => 'error', 'message' => 'Données invalides.'], 400);
		}

		$username = $data['username'];
		$password = $data['password'];

		$existingUser = $entityManager->getRepository(Users::class)->findOneBy(['username' => $username]);
		if ($existingUser) {
			return new JsonResponse(['status' => 'error', 'message' => 'Nom d\'utilisateur déjà pris.'], 400);
		}

		$user = new Users();
		$user->setUsername($username);
		$user->setPassword($passwordHasher->hashPassword($user, $password));
		$user->setFirstName($data['firstname']);
		$user->setLastName($data['lastname']);
		$user->setEmail($data['email']);
		$user->setCreatedAt(new \DateTimeImmutable());
		$user->setUpdatedAt(new \DateTimeImmutable());

		$entityManager->persist($user);
		$entityManager->flush();

		return new JsonResponse(['status' => 'success', 'message' => 'Inscription réussie.'], 201);
	}

	#[Route('/api/login', name: 'api_login', methods: ['POST'])]
	public function login(
		Request $request,
		EntityManagerInterface $entityManager,
		UserPasswordHasherInterface $passwordHasher
	): JsonResponse {
		$data = json_decode($request->getContent(), true);

		if (!$data || !isset($data['username'], $data['password'])) {
			return new JsonResponse(['status' => 'error', 'message' => 'Données invalides.'], 400);
		}

		$username = $data['username'];
		$password = $data['password'];

		$user = $entityManager->getRepository(Users::class)->findOneBy(['username' => $username]);
		if (!$user || !$passwordHasher->isPasswordValid($user, $password)) {
			return new JsonResponse(['status' => 'error', 'message' => 'Identifiants invalides.'], 401);
		}

		return new JsonResponse([
			'status' => 'success',
			'message' => 'Connexion réussie.',
			'userId' => $user->getId(),
		], 200);
	}

	#[Route('/api/getInfo/{id}', name: 'api_getInfo', methods: ['GET'])]
	public function getUserInfo(
		Request $request,
		EntityManagerInterface $entityManager,
		UsersRepository $usersRepository,
		UserPasswordHasherInterface $passwordHasher
	): JsonResponse {
		$id = $request->attributes->get('id');
		$user = $usersRepository->find($id);

		return new JsonResponse([
			'id' => $user->getId(),
			'username' => $user->getUsername(),
			'firstName' => $user->getFirstName(),
			'lastName' => $user->getLastName(),
			'email' => $user->getEmail(),
		], 200);
	}

	#[Route('/api/updateInfo', name: 'api_updateInfo', methods: ['POST'])]
	public function postUserInfo(
		Request $request,
		EntityManagerInterface $entityManager,
		UsersRepository $usersRepository
	): JsonResponse {
		$data = json_decode($request->getContent(), true);

		if (!$data || !isset($data['username'], $data['firstName'], $data['lastName'], $data['email'])) {
			return new JsonResponse(['status' => 'error', 'message' => 'Données invalides.'], 400);
		}

		$user = $usersRepository->find($data['userId']);
		if (!$user) {
			return new JsonResponse(['status' => 'error', 'message' => 'Utilisateur introuvable.'], 404);
		}

		$user->setUsername($data['username']);
		$user->setFirstName($data['firstName']);
		$user->setLastName($data['lastName']);
		$user->setEmail($data['email']);

		$entityManager->flush();

		return new JsonResponse([
			'status' => 'success',
			'message' => 'Informations mises à jour.',
			'user' => [
				'id' => $user->getId(),
				'username' => $user->getUsername(),
				'firstName' => $user->getFirstName(),
				'lastName' => $user->getLastName(),
				'email' => $user->getEmail(),
			]
		], 200);
	}
}
