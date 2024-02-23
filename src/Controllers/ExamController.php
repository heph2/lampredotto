<?php
declare(strict_types=1);

namespace Lampredotto\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Lampredotto\Models\Student;

class ExamController
{
    protected $logger;
    protected $view;
    protected $student;
    protected $response;

    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
        $this->view = $container->get('view');
        $this->student = new Student($container->get('pdo'));
        $this->response = $container->get(Response::class);
    }

    public function __invoke(): Response
    {
        $this->logger->info("Exam page action dispatched");
        $user_id = $_SESSION['user'];
        $cdl = $this->student->getCdl($user_id);
        $this->logger->info("cdl: " . $cdl);
        $exams = $this->student->getAllExamsFromCDL($cdl);
        $enrolledExams = $this->student->getEnrolledExams($user_id);
        $html = $this->view->render('exams_student.twig', [
            'exams' => $exams,
            'enrolledExams' => $enrolledExams
        ]);
        $this->response->withStatus(200);
        $this->response->withHeader('Content-Type', 'text/html');
        $this->response->getBody()->write($html);
        return $this->response;
    }

    public function enroll(Request $request): Response
    {
        $this->logger->info("Enroll action dispatched");
        $body = $request->getParsedBody();
        $exam_name = $body['exam_name'];
        $exam_course_id = $body['course_id'];
        $student_id = $_SESSION['user'];

        $this->student->enroll($student_id, $exam_course_id, $exam_name);
        $this->logger->info("Enrolling " . $exam_name);
        return $this->response
            ->withHeader('Location', '/student/exams')
            ->withStatus(302);
    }

    public function unenroll(Request $request): Response
    {
        $this->logger->info("Unenroll action dispatched");
        $body = $request->getParsedBody();
        $exam_name = $body['exam_name'];
        $exam_course_id = $body['course_id'];
        $student_id = $_SESSION['user'];

        $this->student->unenroll($student_id, $exam_course_id, $exam_name);
        $this->logger->info("Deleting " . $exam_name);
        return $this->response
            ->withHeader('Location', '/student/exams')
            ->withStatus(302);
    }
}
