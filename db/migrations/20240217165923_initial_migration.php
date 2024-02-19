<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InitialMigration extends AbstractMigration
{
    public function change(): void
    {
        $cdl = $this->table('cdl');
        $cdl->addColumn('name', 'text')
            ->addColumn('description', 'text')
            ->create();

        $users = $this->table('users');
        $users->addColumn('first_name', 'text')
            ->addColumn('second_name', 'text')
            ->addColumn('email', 'text')
            ->addColumn('password', 'string', ['limit' => 256])
            ->create();

        $teachers = $this->table('teachers', ['id' => false, 'primary_key' => ['teacher_id']]);
        $teachers->addColumn('teacher_id', 'integer')
                 ->addForeignKey('teacher_id', 'users', ['id'], ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION', 'constraint' => 'teacher_id'])
                 ->create();

        $secretaries = $this->table('secretaries', ['id' => false, 'primary_key' => ['secretary_id']]);
        $secretaries->addColumn('secretary_id', 'integer')
                    ->addForeignKey('secretary_id', 'users', ['id'], ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION', 'constraint' => 'secretary_id'])
                    ->create();                 

        $students = $this->table('students', ['id' => false, 'primary_key' => ['student_id']]);
        $students->addColumn('student_id', 'integer')
                 ->addColumn('cdl', 'integer')
                 ->addColumn('enrollment_date', 'datetime')
                 ->addColumn('status', 'text')                 
                 ->addForeignKey('student_id', 'users', ['id'], ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION', 'constraint' => 'student_id'])
                 ->addForeignKey('cdl', 'cdl', ['id'], ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION', 'constraint' => 'cdl'])
                 ->create();

        $courses = $this->table('courses');
        $courses->addForeignKey('teacher', 'teachers', ['teacher_id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'teacher'])
                ->addForeignKey('cdl', 'cdl', ['id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'cdl'])
                ->addColumn('teacher', 'integer')
                ->addColumn('cdl', 'integer')
                ->addColumn('name', 'string')
                ->addColumn('description', 'text')
                ->addColumn('year', 'integer')
                ->create();

        $preparatories = $this->table('preparatories', ['id' => false, 'primary_key' => ['course', 'preparatory_course']]);
        $preparatories->addForeignKey('preparatory_course', 'courses', ['id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'preparatory_course'])
                      ->addForeignKey('course', 'courses', ['id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'course'])
                      ->addColumn('preparatory_course', 'integer')
                      ->addColumn('course', 'integer')
                      ->create();
    
        $exams = $this->table('exams', ['id' => false, 'primary_key' => ['course_id', 'name']]);
        $exams->addForeignKey('course_id', 'courses', ['id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'course_id'])
              ->addColumn('course_id', 'integer')
              ->addColumn('room', 'string')
              ->addColumn('name', 'string')
              ->addColumn('exam_date', 'datetime')
              ->create();

        $enrollment = $this->table('enrollment', ['id' => false, 'primary_key' => ['course_id', 'name']]);
        $enrollment->addForeignKey('student', 'students', ['student_id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'student'])
                   ->addForeignKey(['course_id', 'name'], 'exams', ['course_id', 'name'], 
                   ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION', 'constraint' => 'exam'])
                   ->addColumn('course_id', 'integer')
                   ->addColumn('name', 'string')
                //    ->addColumn('exam', 'integer')
                   ->addColumn('student', 'integer')
                   ->create();
    }
}
