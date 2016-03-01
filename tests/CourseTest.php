<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */


    require_once __DIR__ . '/../src/Course.php';
    require_once __DIR__ . '/../src/Student.php';

    $server = 'mysql:host=localhost;dbcourse_name=registrar_test';
    $usercourse_name = 'root';
    $password = 'root';
    $DB = new PDO($server, $usercourse_name, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
            Student::deleteAll();
        }

        function test_getInfo()
        {
            // Arrange
            $course_name = "Intro to Russian Lit";
            $id = null;
            $course_num = "LIT105";

            $test_course = new Course($course_name, $course_num, $id);
            // Act
            $result1 = $test_course->getCourseName();
            $result2 = $test_course->getCourseNum();
            $result3 = $test_course->getId();
            // Assert
            $this->assertEquals($course_name, $result1);
            $this->assertEquals($course_num, $result2);
            $this->assertEquals($id, $result3);
        }

        function test_save()
        {
            // Arrange
            $course_name = "Intro to Russian Lit";
            $id = null;
            $course_num = "LIT105";
            $test_course = new Course($course_name, $course_num, $id);

            // Act
            $test_course->save();
            $result = Course::getAll();

            // Assert
            $this->assertEquals($test_course, $result[0]);
        }

        function test_getAll()
        {
            // Arrange
            $course_name = "Intro to Russian Lit";
            $id = null;
            $course_num = "LIT105";
            $test_course = new Course($course_name, $course_num, $id);
            $test_course->save();

            $course_name2 = "Music Theory 205";
            $id2 = null;
            $course_num2 = "MUS205";
            $test_course2 = new Course($course_name2, $course_num2, $id2);
            $test_course2->save();

            // Act
            $result = Course::getAll();

            // Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function test_update()
        {
            // Arrange
            $course_name = "Intro to Russian Lit";
            $id = null;
            $course_num = "LIT105";
            $test_course = new Course($course_name, $course_num, $id);
            $test_course->save();

            $new_course_name = "Music Theory 205";

            // Act
            $test_course->update($new_course_name);
            $result = $test_course->getCourseName();

            // Assert
            $this->assertEquals($new_course_name, $result);
        }

        function test_deleteOneCourse()
        {
            // Arrange
            $course_name = "Intro to Russian Lit";
            $id = null;
            $course_num = "LIT105";
            $test_course = new Course($course_name, $course_num, $id);
            $test_course->save();

            $course_name2 = "Music Theory 205";
            $id2 = null;
            $course_num2 = "MUS205";
            $test_course2 = new Course($course_name2, $course_num2, $id2);
            $test_course2->save();

            // Act
            $test_course->deleteOneCourse();
            $result = Course::getAll();

            // Assert
            $this->assertEquals([$test_course2], $result);
        }

        function test_find()
        {
            $course_name = "Intro to Russian Lit";
            $id = null;
            $course_num = "LIT105";
            $test_course = new Course($course_name, $course_num, $id);
            $test_course->save();

            $course_name2 = "Music Theory 205";
            $id2 = null;
            $course_num2 = "MUS205";
            $test_course2 = new Course($course_name2, $course_num2, $id2);
            $test_course2->save();

            $result = Course::find($test_course->getId());

            $this->assertEquals($test_course, $result);
        }

        function test_addStudent()
        {
            $course_name = "Intro to Russian Lit";
            $id = null;
            $course_num = "LIT105";
            $test_course = new Course($course_name, $course_num, $id);
            $test_course->save();

            $name = "Marika";
            $date = "1999-01-01";
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $test_course->addStudent($test_student);

            $this->assertEquals($test_course->getStudents(), [$test_student]);
        }

        function test_getStudents()
        {
            $course_name = "Intro to Russian Lit";
            $id = null;
            $course_num = "LIT105";
            $test_course = new Course($course_name, $course_num, $id);
            $test_course->save();

            $name = "Marika";
            $date = "1999-01-01";
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $name2 = "Mary";
            $date2 = "1969-01-01";
            $test_student2 = new Student($name2, $date2, $id);
            $test_student2->save();

            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);

            $this->assertEquals($test_course->getStudents(), [$test_student, $test_student2]);
        }
    }
 ?>
