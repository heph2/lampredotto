<?php
declare(strict_types=1);

namespace Lampredotto\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Lampredotto\Models\Teacher;

class TeacherController
{
    protected $logger;
    protected $view;
    protected $response;
    private $teacher;

    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
        $this->view = $container->get('view');
        $this->teacher = new Teacher($container->get('pdo'));
        $this->response = $container->get(Response::class);
    }

    public function __invoke(Request $request): Response
    {
        $this->logger->info("Teacher page action dispatched");
        $user_id = $_SESSION['user'];
        $user_role = $_SESSION['role'];
        $teacherData = $this->teacher->getById($user_id);
        $courseInfo = $this->teacher->getCourseInfo($user_id);
        $this->logger->info("Course data: " . json_encode($courseInfo['year']));
        $html = $this->view->render('home_teacher.twig', [
            'teacher' => $teacherData,
            'course' => $courseInfo,
            'role' => $user_role
        ]);
        $this->response->withStatus(200);
        $this->response->withHeader('Content-Type', 'text/html');
        $this->response->getBody()->write($html);
        return $this->response;
    }
}
