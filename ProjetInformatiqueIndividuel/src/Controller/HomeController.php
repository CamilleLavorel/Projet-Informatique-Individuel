<?php

namespace ProjetInformatiqueIndividuel\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use ProjetInformatiqueIndividuel\Domain\CommentStage;
use ProjetInformatiqueIndividuel\Domain\User;
use ProjetInformatiqueIndividuel\Domain\Semestre;
use ProjetInformatiqueIndividuel\Domain\CommentSemestre;
use ProjetInformatiqueIndividuel\Form\Type\CommentType;
use ProjetInformatiqueIndividuel\Form\Type\UserType;
use ProjetInformatiqueIndividuel\Form\Type\RecherchePaysVilleType;

class HomeController
{

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app)
    {
        return $app['twig']->render('index.html.twig', array());
    }

    public function partenariatAction(Application $app)
    {
        return $app['twig']->render('partenariat.html.twig', array());
    }

    public function infosPratiquesAction(Application $app)
    {
        return $app['twig']->render('informations_pratiques.html.twig', array());
    }

    public function rechercheStageAction(Request $request, Application $app)
    {
        $stages = $app['dao.stage']->findAll();
        $nbstages = count($stages);
        $recherchePaysVilleForm = $app['form.factory']->create(RecherchePaysVilleType::class);
        $recherchePaysVilleForm->handleRequest($request);
        $adresse = '';
        $ville = '';
        $pays = '';
        if ($recherchePaysVilleForm->isSubmitted()&&$recherchePaysVilleForm->isValid()) {
            $data = $recherchePaysVilleForm->getData();

            $adresse=$data['adresse'];
            $ville = $data['ville'];
            $pays = $data['pays'];


            if (empty($adresse) == true) {
                $stages = $app['dao.stage']->findAll();
            }
            else if (empty($ville) == false && empty($pays) == false) {
                $stages = $app['dao.stage']->findByPaysVille($pays, $ville);
                $adresse = $ville;

            } else if(empty($ville) == true && empty($pays) == false){
                $stages = $app['dao.stage']->findByPays($pays);
                $adresse = $pays;
            }

        }
        $recherchePaysVilleFormView = $recherchePaysVilleForm->createView();
        return $app['twig']->render('recherche_stage.html.twig', array(
            'ville' => $ville,
            'pays' => $pays,
            'adresse' => $adresse,
            'stages' => $stages,
            'nbstages' => $nbstages,
            'recherchePaysVilleForm' => $recherchePaysVilleFormView));
    }

    public function stageAction($id, Request $request, Application $app)
    {
        $stage = $app['dao.stage']->find($id);
        $commentFormView = null;
        if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
            // A user is fully authenticated : he can add comments
            $comment = new CommentStage();
            $comment->setStage($stage);
            $user = $app['user'];
            $comment->setAuteur($user);
            $commentForm = $app['form.factory']->create(CommentType::class, $comment);
            $commentForm->handleRequest($request);
            if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                $app['dao.commentstage']->save($comment);
                $app['session']->getFlashBag()->add('success', 'Votre commentaire a été ajouté avec succès.');
            }
            $commentFormView = $commentForm->createView();
        }
        $comments = $app['dao.commentstage']->findAllByStage($id);

        return $app['twig']->render('stage.html.twig', array(
            'stage' => $stage,
            'comments' => $comments,
            'commentForm' => $commentFormView));
    }


    public function rechercheSemestreAction(Request $request, Application $app)
    {
        $semestres = $app['dao.semestre']->findAll();
        $nbsemestres = count($semestres);
        $recherchePaysVilleForm = $app['form.factory']->create(RecherchePaysVilleType::class);
        $recherchePaysVilleForm->handleRequest($request);
        $adresse = '';
        $ville = '';
        $pays = '';
        if ($recherchePaysVilleForm->isSubmitted()&&$recherchePaysVilleForm->isValid()) {
            $data = $recherchePaysVilleForm->getData();

            $adresse=$data['adresse'];
            $ville = $data['ville'];
            $pays = $data['pays'];

            if(empty($adresse)==true)
            {
                $semestres = $app['dao.semestre']->findAll();
            }
            else if (empty($ville) == false && empty($pays) == false) {
                $semestres = $app['dao.semestre']->findByPaysVille($pays, $ville);
                $adresse = $ville;

            } else if (empty($ville) == true && empty($pays) == false) {

                $semestres = $app['dao.semestre']->findByPays($pays);
                $adresse = $pays;

            }

        }
        $recherchePaysVilleFormView = $recherchePaysVilleForm->createView();
        return $app['twig']->render('recherche_semestre.html.twig', array(
            'ville' => $ville,
            'pays' => $pays,
            'adresse' => $adresse,
            'semestres' => $semestres,
            'nbsemestres' => $nbsemestres,
            'recherchePaysVilleForm' => $recherchePaysVilleFormView));
    }


    public function semestreAction($id, Request $request, Application $app)
    {
        $semestre = $app['dao.semestre']->find($id);
        $commentFormView = null;
        if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
            // A user is fully authenticated : he can add comments
            $comment = new CommentSemestre();
            $comment->setSemestre($semestre);
            $user = $app['user'];
            $comment->setAuteur($user);
            $commentForm = $app['form.factory']->create(CommentType::class, $comment);
            $commentForm->handleRequest($request);
            if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                $app['dao.commentsemestre']->save($comment);
                $app['session']->getFlashBag()->add('success', 'Votre commentaire a été ajouté avec succès.');
            }
            $commentFormView = $commentForm->createView();
        }
        $comments = $app['dao.commentsemestre']->findAllBySemestre($id);
        $cours=$app['dao.cours']->findAllBySemestre($id);

        return $app['twig']->render('semestre.html.twig', array(
            'cours'=>$cours,
            'semestre' => $semestre,
            'comments' => $comments,
            'commentForm' => $commentFormView));
    }

    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app)
    {
        return $app['twig']->render('connexion.html.twig', array(
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }

    public function inscriptionAction(Request $request, Application $app){
        $user = new User();
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // generate a random salt value
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();
            // find the default encoder
            $encoder = $app['security.encoder.bcrypt'];
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password);
            $user->setRole("ROLE_USER");
            $path = __DIR__.'/../../web/images/photo-profil/';
            $file = $user->getPhoto();
            if($file)
            {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $path,
                    $fileName
                );
                $user->setPhoto($fileName);
            }
            else
            {
                $user->setPhoto("profil-standard.png");
            }
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'Vous avez bien été inscrit ! Partagez dès maintenant votre expérience ou postez des commentaires !');
            $app['user']=$user;
            return $app->redirect($app['url_generator']->generate('home'));
        }
        return $app['twig']->render('inscription.html.twig', array(
            'userForm' => $userForm->createView()));

    }


}

