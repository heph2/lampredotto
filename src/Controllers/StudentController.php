<?php
declare(strict_types=1);

namespace Lampredotto\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Lampredotto\Models\Student;

class StudentController
{
    protected $logger;
    protected $view;
    protected $response;
    private $student;

    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
        $this->view = $container->get('view');
        $this->student = new Student($container->get('pdo'));
        $this->response = $container->get(Response::class);
    }

    public function __invoke(Request $request): Response
    {
        $this->logger->info("Student page action dispatched");
        $user_id = $_SESSION['user'];
        $user_role = $_SESSION['role'];
        $studentData = $this->student->getStudentData($user_id);
        $studentCarrer = $this->student->getCarrer($user_id);
        $cdlInfo = $this->student->getCDLInfo($user_id);
        $html = $this->view->render('home_student.twig', [
            'student' => $studentData,
            'exams' => $studentCarrer,
            'cdl' => $cdlInfo,
            'role' => $user_role
        ]);
        $this->response->withStatus(200);
        $this->response->withHeader('Content-Type', 'text/html');
        $this->response->getBody()->write($html);
        return $this->response;
    }
}
