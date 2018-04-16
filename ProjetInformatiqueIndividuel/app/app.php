<?php
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;


// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers
$app->register(new Silex\Provider\DoctrineServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new ProjetInformatiqueIndividuel\DAO\UserDAO($app['db']);
            },
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));


// Register services
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app['dao.user'] = function ($app) {
    return new ProjetInformatiqueIndividuel\DAO\UserDAO($app['db']);
};

$app['dao.cours'] = function ($app) {
    $coursDAO=new ProjetInformatiqueIndividuel\DAO\CoursDAO($app['db']);
    $coursDAO->setSemestreDAO($app['dao.semestre']);
    return $coursDAO;
};

$app['dao.universite'] = function ($app) {
    return new ProjetInformatiqueIndividuel\DAO\UniversiteDAO($app['db']);
};

$app['dao.entreprise'] = function ($app) {
    return new ProjetInformatiqueIndividuel\DAO\EntrepriseDAO($app['db']);
};

$app['dao.logement'] = function ($app) {
    return new ProjetInformatiqueIndividuel\DAO\LogementDAO($app['db']);
};

$app['dao.semestre'] = function ($app) {
    $semestreDAO = new ProjetInformatiqueIndividuel\DAO\SemestreDAO($app['db']);
    $semestreDAO->setUniversiteDAO($app['dao.universite']);
    $semestreDAO->setUserDAO($app['dao.user']);
    $semestreDAO->setLogementDAO($app['dao.logement']);
    return $semestreDAO;
};

$app['dao.stage'] = function ($app) {
    $stageDAO = new ProjetInformatiqueIndividuel\DAO\StageDAO($app['db']);
    $stageDAO->setEntrepriseDAO($app['dao.entreprise']);
    $stageDAO->setUserDAO($app['dao.user']);
    $stageDAO->setLogementDAO($app['dao.logement']);
    return $stageDAO;
};

$app['dao.commentsemestre'] = function ($app){
    $commentsemestreDAO = new ProjetInformatiqueIndividuel\DAO\CommentSemestreDAO($app['db']);
    $commentsemestreDAO->setSemestreDAO($app['dao.semestre']);
    $commentsemestreDAO->setUserDAO($app['dao.user']);
    return $commentsemestreDAO;
};

$app['dao.commentstage'] = function ($app){
    $commentstageDAO = new ProjetInformatiqueIndividuel\DAO\CommentStageDAO($app['db']);
    $commentstageDAO->setStageDAO($app['dao.stage']);
    $commentstageDAO->setUserDAO($app['dao.user']);
    return $commentstageDAO;
};


// Register error handler
$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    switch ($code) {
        case 403:
            $message = 'Access denied.';
            break;
        case 404:
            $message = 'The requested resource could not be found.';
            break;
        default:
            $message = "Something went wrong.";
    }
    return $app['twig']->render('erreur.html.twig', array('message' => $message));
});