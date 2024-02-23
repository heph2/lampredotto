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

    public function getTeachers() {
        $sql = $this->db->prepare("select * from users inner join teachers on users.id = teachers.teacher_id");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getStudents() {
        $sql = $this->db->prepare("select * from users inner join students on users.id = students.student_id");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getCDLs() {
        $sql = $this->db->prepare("select * from cdl");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function addStudent($data) {
        $sql = $this->db->prepare("insert into users (first_name, second_name, email, password) values (:first_name, :second_name, :email, :password)");
        $sql->bindParam(':first_name', $data['first_name']);
        $sql->bindParam(':second_name', $data['second_name']);
        $sql->bindParam(':email', $data['email']);
        $sql->bindParam(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $sql->execute();

        $student_id = $this->db->lastInsertId();
        $sql = $this->db->prepare("insert into students (student_id, cdl, enrollment_date, status) values (:student_id, :cdl, :enrollment_date, :status)");
        $sql->bindParam(':student_id', $student_id);
        $sql->bindParam(':cdl', $data['cdl']);
        $sql->bindParam(':enrollment_date', $data['enrollment_date']);
        $sql->bindParam(':status', $data['status']);
        $sql->execute();
    }
}