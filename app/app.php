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
            'students' => $course->getStudents()
        ));
    });

    $app->get("/students", function() use ($app) {
        return $app['twig']->render('students.html.twig');
    });

    $app->post("/courses", function() use ($app) {
        $new_course = new Course($_POST['course_name'], $_POST['course_num']);
        $new_course->save();
        return $app['twig']->render('courses.html.twig', array(
            'courses' => Course::getAll()
        ));
    });

    return $app;
?>
