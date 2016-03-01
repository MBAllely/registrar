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




    }
?>
