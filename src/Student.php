<?php
class Student
{
    private $name;
    private $date;
    private $department_id;
    private $id;

    function __construct($name, $date, $department_id, $id = null)
    {
        $this->name = $name;
        $this->date = $date;
        $this->department_id= $department_id;
        $this->id = $id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
        $this->name = $new_name;
    }

    function getDate()
    {
        return $this->date;
    }

    function setDate($new_date)
    {
        $this->date = $new_date;
    }

    function getDepartmentId()
    {
        return $this->department_id;
    }

    function setDepartmentId($new_department_id)
    {
        $this->department_id = $new_department_id;
    }

    function getId()
    {
        return $this->id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO students (name, date, department_id) VALUES ('{$this->getName()}', '{$this->getDate()}', {$this->getDepartmentId()});");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
        $students = [];

        foreach($returned_students as $student) {
            $name = $student['name'];
            $date = $student['date'];
            $department_id = $student['department_id'];
            $id = $student['id'];
            $new_student = new Student($name, $date, $department_id, $id);
            array_push($students, $new_student);
        }
        return $students;
    }

    function update($new_name, $new_department_id)
    {
        $GLOBALS['DB']->exec("INSERT INTO students SET name = '{$new_name}', department_id = {$new_department_id};");
        $this->setName($new_name);
        $this->setDepartmentId($new_department_id);
    }

    static function find($search_id)
    {
        $found_student = null;
        $students = Student::getAll();
        foreach($students as $student) {
            if ($student->getId() == $search_id)
            {
                $found_student = $student;
            }
        }
        return $found_student;
    }

    function addCourse($course)
    {
        $GLOBALS['DB']->exec("INSERT INTO enrollment (course_id, student_id) VALUES ({$course->getId()}, {$this->getId()});");
    }

    function getCourses()
    {
        $returned_courses = $GLOBALS['DB']->query("SELECT courses.* FROM students
            JOIN enrollment ON (students.id = enrollment.student_id)
            JOIN courses ON (enrollment.course_id = courses.id)
            WHERE students.id = {$this->getId()};");

        $courses = [];
        foreach($returned_courses as $course) {

            $course_name = $course['course_name'];
            $course_num = $course['course_num'];
            $id = $course['id'];
            $new_course = new Course($course_name, $course_num, $id);
            array_push($courses, $new_course);
        }
        return $courses;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM students;");
    }

    function deleteOneStudent()
    {
        $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM enrollment WHERE student_id = {$this->getId()};");
    }


}
?>
