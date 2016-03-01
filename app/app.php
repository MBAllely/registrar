<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Course.php";
    require_once __DIR__."/../src/Student.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $server = 'mysql:host=localhost;dbname=registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/courses", function() use ($app) {
        return $app['twig']->render('courses.html.twig', array(
        'courses' => Course::getAll()
        ));
    });

    $app->get("/courses/{id}", function($id) use ($app) {
        $course = Course::find($id);
        return $app['twig']->render('course.html.twig', array(
            'course' => $course,
            'course_students' => $course->getStudents(),
            'students' => Student::getAll()
        ));
    });

    $app->get("/students", function() use ($app) {
        return $app['twig']->render('students.html.twig', array(
            'students' => Student::getAll()
        ));
    });

    $app->post("/courses", function() use ($app) {
        $new_course = new Course($_POST['course_name'], $_POST['course_num']);
        $new_course->save();
        return $app['twig']->render('courses.html.twig', array(
            'courses' => Course::getAll()
        ));
    });

    $app->post("/students", function() use ($app) {
        $new_student = new Student($_POST['name'], $_POST['date']);
        $new_student->save();
        return $app['twig']->render('students.html.twig', array(
            'students' => Student::getAll()
        ));
    });

    $app->get("/students/{id}", function($id) use ($app) {
        $student = Student::find($id);
        return $app['twig']->render('student.html.twig', array(
            'student' => $student,
            'courses' => $student->getCourses()
        ));
    });

    $app->post("/{id}/add_student", function($id) use ($app) {
        $course = Course::find($id);
        $student = Student::find($_POST['id']);
        $course->addStudent($student);
        return $app['twig']->render('course.html.twig', array(
            'course' => $course,
            'course_students' => $course->getStudents(),
            'students' => Student::getAll()
        ));
    });

    $app->delete("/{id}/delete_student", function($id) use ($app) {
        $student = Student::find($id);
        $student->deleteOneStudent();
        return $app['twig']->render('students.html.twig', array(
            'students' => Student::getAll()
        ));
    });

    $app->delete("/{id}/delete_course", function($id) use ($app) {
        $course = Course::find($id);
        $course->deleteOneCourse();
        return $app['twig']->render('courses.html.twig', array(
            'courses' => Course::getAll()
        ));
    });

    return $app;
?>
