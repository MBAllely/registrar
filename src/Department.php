<?php
    class Department
    {
        private $department_name;
        private $id;

        function __construct($department_name, $id = null)
        {
            $this->department_name = $department_name;
            $this->id = $id;
        }

        function getDepartmentName()
        {
            return $this->department_name;
        }

        function setDepartmentName($new_department_name)
        {
            $this->department_name = $new_department_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO departments (department_name) VALUES ('{$this->getDepartmentName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_departments = $GLOBALS['DB']->query("SELECT * FROM departments;");
            $departments = [];

            foreach($returned_departments as $department) {
                $department_name = $department['department_name'];
                $id = $department['id'];
                $new_department = new Department($department_name, $id);
                array_push($departments, $new_department);
            }
            return $departments;
        }

        static function find($search_id)
        {
            $found_department = null;
            $departments = Department::getAll();
            foreach($departments as $department) {
                $department_id = $department->getId();
                if ($department_id == $search_id)
                {
                    $found_department = $department;
                }
            }
            return $found_department;
        }

        function update($new_department_name)
        {
            $GLOBALS['DB']->exec("INSERT INTO departments SET department_name = '{$new_department_name}';");
            $this->setDepartmentName($new_department_name);
        }

        function addCourse($student)
        {
            $GLOBALS['DB']->exec("INSERT INTO department_courses (department_id, course_id) VALUES ({$this->getId()}, {$course->getId()});");
        }

        function getCourses()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT courses.* FROM departments
                JOIN department_courses ON (departments.id = department_courses.department_id)
                JOIN courses ON (department_courses.course_id = courses.id)
                WHERE departments.id = {$this->getId()};");

            $courses = array();
            foreach($returned_courses as $course) {

                $course_name = $course['course_name'];
                $course_num = $course['course_num'];
                $id = $course['id'];
                $new_course = new Course($course_name, $course_num, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        function getStudents()
        {
            $GLOBALS['DB']->query("SELECT * FROM students WHERE department_id = {$this->getId()};");
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM departments;");
        }

        function deleteOneDepartment()
        {
            $GLOBALS['DB']->exec("DELETE FROM departments WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM department_courses WHERE department_id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM students WHERE department_id = {$this->getId()};");
        }




    }
?>
