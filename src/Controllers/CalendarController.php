<?php
declare(strict_types=1);

namespace Lampredotto\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Lampredotto\Models\Teacher;

class CalendarController
{
    protected $logger;
    protected $view;
    protected $teacher;
    protected $response;

    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
        $this->view = $container->get('view');
        $this->teacher = new Teacher($container->get('pdo'));
        $this->response = $container->get(Response::class);
    }

    public function __invoke(): Response
    {
        $this->logger->info("Calendar page action dispatched");
        $user_id = $_SESSION['user'];
        $user_role = $_SESSION['role'];
        $exams = $this->teacher->getExams($user_id);
        $html = $this->view->render('calendar_teacher.twig', [
            'role' => $user_role,
            'exams' => $exams,
        ]);
        $this->response->withStatus(200);
        $this->response->withHeader('Content-Type', 'text/html');
        $this->response->getBody()->write($html);
        return $this->response;
    }

    public function addExam(Request $request): Response
    {
        $this->logger->info("Add exam action dispatched");
        $body = $request->getParsedBody();
        $exam_name = $body['name'];
        $exam_room = $body['room'];
        $exam_course_id = $body['course_id'];
        $exam_date = $body['exam_date'];

        $this->teacher->addExam($exam_name, $exam_room, $exam_course_id, $exam_date);
        $this->logger->info("Adding " . $exam_name);
        return $this->response
            ->withHeader('Location', '/teacher/exams')
            ->withStatus(302);
    }

    public function deleteExam(Request $request): Response
    {
        $this->logger->info("Delete exam action dispatched");
        $body = $request->getParsedBody();
        $exam_name = $body['exam_name'];
        $exam_course_id = $body['course_id'];
        $student_id = $_SESSION['user'];

        $this->teacher->deleteExam($exam_name, $exam_course_id);
        $this->logger->info("Deleting " . $exam_name);
        return $this->response
            ->withHeader('Location', '/teacher/exams')
            ->withStatus(302);
    }
}
