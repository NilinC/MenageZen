<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager) {}

    #[Route('/', name: 'homepage')]
    public function list(): Response
    {
        $tasks = $this->entityManager->getRepository(Task::class)->findAll();

        return $this->render(
            'task/list.html.twig',
            [ 'tasks' => $tasks ]
        );
    }
}
