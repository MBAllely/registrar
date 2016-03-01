<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */


    require_once __DIR__ . '/../src/Student.php';
    require_once __DIR__ . '/../src/Course.php';

    $server = 'mysql:host=localhost;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function test_getInfo()
        {
            // Arrange
            $name = "Marika";
            $id = null;
            $date = "1999-01-01";

            $test_student = new Student($name, $date, $id);
            // Act
            $result1 = $test_student->getName();
            $result2 = $test_student->getDate();
            $result3 = $test_student->getId();
            // Assert
            $this->assertEquals($name, $result1);
            $this->assertEquals($date, $result2);
            $this->assertEquals($id, $result3);
        }

        function test_save()
        {
            // Arrange
            $name = "Marika";
            $id = null;
            $date = "1999-01-01";
            $test_student = new Student($name, $date, $id);

            // Act
            $test_student->save();
            $result = Student::getAll();

            // Assert
            $this->assertEquals($test_student, $result[0]);
        }

        function test_getAll()
        {
            // Arrange
            $name = "Marika";
            $id = null;
            $date = "1999-01-01";
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $name2 = "Mary";
            $id2 = null;
            $date2 = "1969-01-01";
            $test_student2 = new Student($name2, $date2, $id2);
            $test_student2->save();

            // Act
            $result = Student::getAll();

            // Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function test_update()
        {
            // Arrange
            $name = "Marika";
            $id = null;
            $date = "1999-01-01";
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $new_name = "Mary";

            // Act
            $test_student->update($new_name);
            $result = $test_student->getName();

            // Assert
            $this->assertEquals($new_name, $result);
        }

        function test_find()
        {
            // Arrange
            $name = "Marika";
            $id = null;
            $date = "1999-01-01";
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $name2 = "Mary";
            $id2 = null;
            $date2 = "1969-01-01";
            $test_student2 = new Student($name2, $date2, $id2);
            $test_student2->save();

            // Act
            $result = Student::find($test_student->getId());

            // Assert
            $this->assertEquals($test_student, $result);
        }

        function test_addCourse()
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

            $test_student->addCourse($test_course);

            $this->assertEquals($test_student->getCourses(), [$test_course]);
        }

        function test_getCourses()
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

            $name = "Marika";
            $date = "1999-01-01";
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $test_student->addCourse($test_course);
            $test_student->addCourse($test_course2);

            $this->assertEquals($test_student->getCourses(), [$test_course, $test_course2]);
        }


        function test_deleteOneStudent()
        {
            // Arrange
            $name = "Marika";
            $id = null;
            $date = "1999-01-01";
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $name2 = "Mary";
            $id2 = null;
            $date2 = "1969-01-01";
            $test_student2 = new Student($name2, $date2, $id2);
            $test_student2->save();

            // Act
            $test_student->deleteOneStudent();
            $result = Student::getAll();

            // Assert
            $this->assertEquals([$test_student2], $result);
        }
    }
 ?>
