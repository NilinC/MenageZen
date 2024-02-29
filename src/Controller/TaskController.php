<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\Type\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager) {}

    #[Route('/', name: 'homepage')]
    public function list(): Response
    {
        $tasks = $this->entityManager->getRepository(Task::class)->findAll();
        $users = $this->entityManager->getRepository(User::class)->findAll();

        return $this->render(
            'task/list.html.twig',
            [
                'tasks' => $tasks,
                'users' => $users
            ]
        );
    }

    #[Route('/list/?room', name: 'list_by_room')]
    public function listByRoom(Request $request): Response
    {
        $roomFilter = $request->query->get('roomFilter');

        $tasks = $this->entityManager->getRepository(Task::class)->findAllByRoom($roomFilter);

        return $this->render(
            'task/list.html.twig',
            [ 'tasks' => $tasks ]
        );
    }

    #[Route('/update/?task_id', name: 'update_task', methods: [ "GET", "POST" ])]
    public function update(Request $request): Response
    {
        $taskId = $request->query->get('task_id');
        if ($taskId) {
            $task = $this->entityManager->getRepository(Task::class)->findOneBy([ 'id' => $taskId ]);
        } else {
            $task = new Task();
        }

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $task->calculateNextDone();

            $user = $task->getLastDoneBy();
            if ($user) {
                $user->setPoints($task->getDifficulty());
                $this->entityManager->persist($user);
            }

            $this->entityManager->persist($task);
            $this->entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'task/form.html.twig',
            [ 'form' => $form ]
        );
    }

    #[Route('/remove/?task_id', 'remove_task', methods: [ "GET", "DELETE" ])]
    public function remove(Request $request): Response
    {
        $task = $this->entityManager->getRepository(Task::class)->findOneBy([ 'id' => $request->query->get('task_id') ]);

        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return $this->redirectToRoute('homepage');
    }

    #[Route('/schedule', 'chores_schedule', methods: [ "GET" ])]
    public function schedule(): Response
    {
        return $this->render('task/schedule.html.twig');
    }
}
