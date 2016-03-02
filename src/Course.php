<?php
    class Course
    {
        private $course_name;
        private $course_num;
        private $id;

        function __construct($course_name, $course_num, $id = null)
        {
            $this->course_name = $course_name;
            $this->course_num = $course_num;
            $this->id = $id;
        }

        function getCourseName()
        {
            return $this->course_name;
        }

        function setCourseName($new_course_name)
        {
            $this->course_name = $new_course_name;
        }

        function getCourseNum()
        {
            return $this->course_num;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (course_name, course_num) VALUES ('{$this->getCourseName()}', '{$this->getCourseNum()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
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

        static function find($search_id)
        {
            $found_course = null;
            $courses = Course::getAll();
            foreach($courses as $course) {
                $course_id = $course->getId();
                if ($course_id == $search_id) {
                    $found_course = $course;
                }
            }
            return $found_course;
        }

        function update($new_course_name)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses SET course_name = '{$new_course_name}';");
            $this->setCourseName($new_course_name);
        }

        function addStudent($student)
        {
            $GLOBALS['DB']->exec("INSERT INTO enrollment (course_id, student_id) VALUES ({$this->getId()}, {$student->getId()});");
        }

        function getStudents()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT students.* FROM courses
                JOIN enrollment ON (courses.id = enrollment.course_id)
                JOIN students ON (enrollment.student_id = students.id)
                WHERE courses.id = {$this->getId()};");

            $students = array();
            foreach($returned_students as $student) {

                $name = $student['name'];
                $date = $student['date'];
                $id = $student['id'];
                $new_student = new Student($name, $date, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        function addDepartment($department)
        {
            $GLOBALS['DB']->exec("INSERT INTO department_courses (department_id, course_id) VALUES ({$department->getId()}, {$this->getId()});");
        }

        function getDepartments()
        {
            $returned_departments = $GLOBALS['DB']->query("SELECT departments.* FROM courses
                JOIN department_courses ON (courses.id = department_courses.course_id)
                JOIN departments ON (department_courses.department_id = departments.id)
                WHERE courses.id = {$this->getId()};");

            $departments = array();
            foreach($returned_departments as $department) {

                $department_name = $department['department_name'];
                $id = $department['id'];
                $new_department = new Department($department_name, $id);
                array_push($departments, $new_department);
            }
            return $departments;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        function deleteOneCourse()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM enrollment WHERE course_id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM department_courses WHERE course_id = {$this->getId()};");
        }




    }
?>
