<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */


    require_once __DIR__ . '/../src/Student.php';

    $server = 'mysql:host=localhost;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
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
    }
 ?>
