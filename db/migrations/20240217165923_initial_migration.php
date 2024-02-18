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
            ->addColumn('password', 'string', ['limit' => 50])
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

        // $courses = $this->table('courses');
        // $courses->addForeignKey('id', 'teachers', ['id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'teacher'])
        //         ->addForeignKey('id', 'cdl', ['id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'cdl'])
        //         ->addColumn('name', 'string')
        //         ->addColumn('description', 'text')
        //         ->addColumn('year', 'integer')
        //         ->create();

        // $preparatories = $this->table('preparatories');
        // $preparatories->addForeignKey('id', 'courses', ['id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'preparatory'])
        //               ->addForeignKey('id', 'courses', ['id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'course'])
        //               ->create();
    
        // $exams = $this->table('exams');
        // $exams->addForeignKey('id', 'courses', ['id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'course'])
        //       ->addColumn('exam_data', 'datetime')
        //       ->create();

        // $enrollment = $this->table('enrollment');
        // $enrollment->addForeignKey('id', 'exams', ['id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'exam'])
        //            ->addForeignKey('id', 'students', ['id'], ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION', 'constraint' => 'student'])
        //            ->create();
    }
}
