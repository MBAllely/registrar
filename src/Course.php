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

        function update($new_course_name)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses SET course_name = '{$new_course_name}';");
            $this->setCourseName($new_course_name);
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        function deleteOneCourse()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM enrollment WHERE course_id = {$this->getId()};");
        }




    }
?>
