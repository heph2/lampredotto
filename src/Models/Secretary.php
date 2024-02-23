<?php

namespace Lampredotto\Models;

class Secretary {
    private $table = "secretaries";
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getById($id) {
        $sql = $this->db->prepare("select * from users inner join $this->table on users.id = secretaries.secretary_id where users.id = :id");
        $sql->bindParam(':id', $id);
        $sql->execute();
        return $sql->fetch();
    }

    public function getRole($id) {
        $user_role = $this->db->prepare("SELECT 'teacher' AS role FROM teachers WHERE teacher_id = :id
        UNION ALL
        SELECT 'secretary' AS role FROM secretaries WHERE secretary_id = :id
        UNION ALL
        SELECT 'student' AS role FROM students WHERE student_id = :id");
        $user_role->bindParam(':id', $id);
        $user_role->execute();
        return $user_role->fetch();
    }

    public function getCourseInfo($id) {
        $course_info = $this->db->prepare("SELECT * FROM courses WHERE teacher = :id");
        $course_info->bindParam(':id', $id);
        $course_info->execute();
        return $course_info->fetch();
    }

    public function getByEmail($email) {
        $user_data = $this->db->prepare("select id, email, password from $this->table where email = :email");
        $user_data->bindParam(':email', $email);
        $user_data->execute();
        return $user_data->fetch();        
    }

    public function addExam($course_id, $room, $name, $exam_date) {
        $add_exam = $this->db->prepare("INSERT INTO exams (course_id, room, name, exam_date) VALUES (:course_id, :room, :name, :exam_date)");
        $add_exam->bindParam(':course_id', $course_id);
        $add_exam->bindParam(':room', $room);
        $add_exam->bindParam(':name', $name);
        $add_exam->bindParam(':exam_date', $exam_date);
        $add_exam->execute();
    }

    public function deleteExam($name, $course_id) {
        $delete_exam = $this->db->prepare("DELETE FROM exams WHERE name = :name AND course_id = :course_id");
        $delete_exam->bindParam(':name', $name);
        $delete_exam->bindParam(':course_id', $course_id);
        $delete_exam->execute();
    }

    public function getExams($id) {
        $exams = $this->db->prepare("SELECT exams.*
        FROM exams
        JOIN courses ON exams.course_id = courses.id
        WHERE courses.teacher = :id");
        $exams->bindParam(':id', $_SESSION['user']);
        $exams->execute();
        return $exams->fetchAll();
    }
}