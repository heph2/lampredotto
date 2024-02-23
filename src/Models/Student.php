<?php

namespace Lampredotto\Models;

class Student {
    private $table = "students";
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getStudentData($id): array
    {
        $sql = $this->db->prepare("select * from users inner join students on users.id = students.student_id where users.id = :id");
        $sql->bindParam(':id', $id);
        $sql->execute();
        return $sql->fetch();
    }

    public function getCDLInfo($id): array {
        $sql = $this->db->prepare("SELECT cdl.name, cdl.description FROM students LEFT JOIN cdl ON students.cdl = cdl.id WHERE student_id = :id");
        $sql->bindParam(':id', $id);
        $sql->execute();
        return $sql->fetch();
    }

    public function getCarrer($id): array
    {
        $sql = $this->db->prepare("select * from exams left join enrollment on exams.course_id = enrollment.course_id where enrollment.course_id = :id and score is not null");
        $sql->bindParam(':id', $id);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getCdl($id): int
    {
        $sql = $this->db->prepare("select cdl from students where student_id = :id");
        $sql->bindParam(':id', $id);
        $sql->execute();
        return $sql->fetch()['cdl'];
    }

    public function getAllExamsFromCDL($cdl): array 
    {
        $sql = $this->db->prepare("SELECT exams.name, exams.exam_date, exams.room, exams.course_id
        FROM exams
        JOIN courses ON exams.course_id = courses.id
        JOIN students ON courses.cdl = students.cdl
        LEFT JOIN enrollment ON exams.course_id = enrollment.course_id AND exams.name = enrollment.name AND students.student_id = enrollment.student
        WHERE students.cdl = :cdl AND enrollment.course_id IS NULL;
        ");
        $sql->bindParam(':cdl', $cdl);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getEnrolledExams($id): array
    {
        $sql = $this->db->prepare("select exams.name, exams.exam_date, exams.room, exams.course_id from exams left join enrollment on exams.course_id = enrollment.course_id where enrollment.student = :id and score is null");
        $sql->bindParam(':id', $id);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function enroll($student_id, $course_id, $exam_name): void
    {
        $sql = $this->db->prepare("insert into enrollment (student, course_id, name) values (:student_id, :course_id, :exam_name)");
        $sql->bindParam(':student_id', $student_id);
        $sql->bindParam(':course_id', $course_id);
        $sql->bindParam(':exam_name', $exam_name);
        $sql->execute();
    }

    public function unenroll($student_id, $course_id, $exam_name): void
    {
        $sql = $this->db->prepare("delete from enrollment where name = :exam_name and course_id = :course_id and student = :student_id");
        $sql->bindParam(':student_id', $student_id);
        $sql->bindParam(':course_id', $course_id);
        $sql->bindParam(':exam_name', $exam_name);
        $sql->execute();        
    }
}