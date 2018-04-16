<?php

namespace ProjetInformatiqueIndividuel\Controller;

use Silex\Application;

use \DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use ProjetInformatiqueIndividuel\Domain\Semestre;
use ProjetInformatiqueIndividuel\Domain\Stage;
use ProjetInformatiqueIndividuel\Domain\Entreprise;
use ProjetInformatiqueIndividuel\Domain\Universite;
use ProjetInformatiqueIndividuel\Domain\Logement;
use ProjetInformatiqueIndividuel\Form\Type\UserType;
use ProjetInformatiqueIndividuel\Form\Type\StageType;
use ProjetInformatiqueIndividuel\Form\Type\SemestreType;

class UserController
{
    /**
     * Admin home page controller.
     *
     * @param Application $app Silex application
     */
    public function experiencesAction(Application $app) {
        $user = $app['user'];
        if($user)
        {
            $userId = $user->getId();
            $semestres=$app['dao.semestre']->findByUser($userId);
            $stages=$app['dao.stage']->findByUser($userId);
            return $app['twig']->render('mes_experiences.html.twig',array(
                'semestres'=>$semestres,
                'stages'=>$stages));
        }
        else
        {
            $message="Vous ne pouvez pas acccéder à cette page";
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException ($message);
        }
    }



    public function commentairesAction(Application $app)
    {
        $user = $app['user'];
        if($user) {
            $userId = $user->getId();
            $mycommentsemestres = $app['dao.commentsemestre']->findByUser($userId);
            $mycommentstages = $app['dao.commentstage']->findByUser($userId);
            return $app['twig']->render('mes_commentaires.html.twig', array(
                'commentairessemestres' => $mycommentsemestres,
                'commentairesstages' => $mycommentstages));
        }
        else
        {
            $message="Vous ne pouvez pas acccéder à cette page";
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException ($message);
        }
    }

    public function profilAction(Application $app)
    {
        return $app['twig']->render('mon_profil.html.twig',array());
    }

    public function editProfilAction(Request $request,Application $app)
    {
        $user = $app['user'];
        $file = $user->getPhoto();
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {

            if($userForm['photo']->getData()==null)
            {
                $user->setPhoto($file);
            }
            else
            {
                $path = __DIR__.'/../../web/images/photo-profil/';
                $file = $user->getPhoto();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $path,
                    $fileName
                );
                $user->setPhoto($fileName);
            }
            $plainPassword = $user->getPassword();
            // find the encoder for the user
            $encoder = $app['security.encoder_factory']->getEncoder($user);
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password);
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'Les modifications ont bien été effectuées');
            return $app->redirect($app['url_generator']->generate('profil'));

        }
        return $app['twig']->render('modification_profil.html.twig', array(
            'photo'=>$file,
            'userForm' => $userForm->createView()));
    }

    /**
     * Add stage controller.
     *
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * */
    public function addStageAction(Request $request, Application $app) {

        $stage = new Stage();
        $entreprise=new Entreprise();
        $logement =new Logement();
        $entreprises=$app['dao.entreprise']->findAll();
        $nbentreprises=count($entreprises);
        $stage->setEntreprise($entreprise);
        $stage->setLogement($logement);
        $stageForm = $app['form.factory']->create(StageType::class, $stage);
        $stageForm->handleRequest($request);
        if ($stageForm->isSubmitted() && $stageForm->isValid()) {
            $user = $app['user'];
            $logement=$stage->getLogement();
            $entreprise = $stage ->getEntreprise();
            $stage->setAuteur($user);
            $path = __DIR__.'/../../web/images/photo-entreprise/';
            $file = $entreprise->getLogo();
            if($file)
            {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $path,
                    $fileName
                );
                $entreprise->setLogo($fileName);
            }
            else
            {
                $entreprise->setLogo("");
            }
            $app['dao.logement']->save($logement);
            $app['dao.entreprise']->save($entreprise);
            $app['dao.stage']->save($stage);
            $app['session']->getFlashBag()->add('success', 'Votre expérience a bien été rajoutée !');
            return $app->redirect($app['url_generator']->generate('mesexperiences'));
        }
        return $app['twig']->render('ajout_stage.html.twig', array(
            'nb_entreprises' =>$nbentreprises,
            'entreprises' => $entreprises,
            'stageForm' => $stageForm->createView()));

    }

    /**
     * Edit stage controller.
     *
     * @param integer $id Stage id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * */
    public function editStageAction($id,Request $request, Application $app) {

        $stage = $app['dao.stage']->find($id);
        $entreprise=$stage->getEntreprise();
        $file =$entreprise ->getLogo();

        $datedebut = $stage -> getDateDebut();
        $dateD = new DateTime($datedebut);
        $stage->setDateDebut($dateD);

        $datefin = $stage -> getDateFin();
        $dateF = new DateTime($datefin);
        $stage->setDateFin($dateF);

        $stageForm = $app['form.factory']->create(StageType::class, $stage);
        $stageForm->handleRequest($request);
        if ($stageForm->isSubmitted() && $stageForm->isValid()) {
            $user = $app['user'];
            $userId=$user->getId();
            $entreprise = $stage ->getEntreprise();
            $logement=$stage->getLogement();

            if($stageForm['entreprise']['logo']->getData()==null)
            {
                $entreprise->setLogo($file);
            }
            else
            {
                $path =__DIR__.'/../../web/images/photo-entreprise/';
                $file = $entreprise->getLogo();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $path,
                    $fileName
                );
                $entreprise->setLogo($fileName);
            }
            $stage->setAuteur($user);
            $app['dao.entreprise']->save($entreprise);
            $app['dao.stage']->save($stage);
            $app['dao.logement']->save($logement);
            $app['session']->getFlashBag()->add('success', 'Les modifications ont bien été effectuées');

            return $app->redirect($app['url_generator']->generate('mesexperiences', array( 'id' => $userId )));
        }
        return $app['twig']->render('modification_stage.html.twig', array(
            'photo_entreprise'=>$file,
            'stageForm' => $stageForm->createView()));

    }

    /**
     * Delete stage controller.
     *
     * @param integer $id Stage id
     * @param Application $app Silex application
     */
    public function deleteStageAction($id, Application $app) {

        $stage=$app['dao.stage']->find($id);
        $logementId=$stage->getLogement()->getId();
        //Supprime le logement associé au stage
        $app['dao.logement']->delete($logementId);
        // Supprime les commentaires associés au stage
        $app['dao.commentstage']->deleteAllByStage($id);
        // Supprime le stage
        $app['dao.stage']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le stage a bien été supprimé');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('mesexperiences'));
    }

    /**
     * Add semestre controller.
     *
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * */

    public function addSemestreAction(Request $request, Application $app) {

        $semestre = new Semestre();
        $universite=new Universite();
        $logement =new Logement();
        $universites=$app['dao.universite']->findAll();
        $nbuniversites=count($universites);
        $semestre->setLogement($logement);
        $semestre->setUniversite($universite);
        $semestreForm = $app['form.factory']->create(SemestreType::class, $semestre);
        $semestreForm->handleRequest($request);
        if ($semestreForm->isSubmitted() && $semestreForm->isValid()) {
            $user = $app['user'];
            $userId=$user->getId();
            $logement=$semestre->getLogement();
            $universite = $semestre ->getUniversite();
            $cours=$semestre->getCours();

            $semestre->setAuteur($user);
            $path_universite = __DIR__.'/../../web/images/photo-universite/';
            $path_semestre = __DIR__.'/../../web/images/photo-semestre/';
            $file_semestre = $semestre->getPhoto();
            $file_universite = $universite->getLogo();
            if($file_universite&&$file_semestre)
            {
                $fileNameUniversite = md5(uniqid()).'.'.$file_universite->guessExtension();
                $file_universite->move(
                    $path_universite,
                    $fileNameUniversite
                );
                $universite->setLogo($fileNameUniversite);
                $fileNameSemestre = md5(uniqid()).'.'.$file_semestre->guessExtension();
                $file_semestre->move(
                    $path_semestre,
                    $fileNameSemestre
                );
                $semestre->setPhoto($fileNameSemestre);
            }
            elseif ($file_universite||$file_semestre)
            {
                if ($file_semestre)
                {
                    $fileNameSemestre = md5(uniqid()).'.'.$file_semestre->guessExtension();
                    $file_semestre->move(
                        $path_semestre,
                        $fileNameSemestre
                    );
                    $semestre->setPhoto($fileNameSemestre);
                    $universite->setLogo("");
                }
                elseif($file_universite)
                {
                    $fileNameUniversite = md5(uniqid()).'.'.$file_universite->guessExtension();
                    $file_universite->move(
                        $path_universite,
                        $fileNameUniversite
                    );
                    $universite->setLogo($fileNameUniversite);
                    $semestre->setPhoto("");
                }
            }
            else
            {
                $universite->setLogo("");
                $semestre->setPhoto("");
            }
            $app['dao.logement']->save($logement);
            $app['dao.universite']->save($universite);
            $app['dao.semestre']->save($semestre);
            foreach($cours as $cour)
            {
                $app['dao.cours']->save($cour);
            }
            $app['session']->getFlashBag()->add('success', 'Votre expérience a bien été rajoutée !');

            return $app->redirect($app['url_generator']->generate('mesexperiences', array( 'id' => $userId )));

        }
        return $app['twig']->render('ajout_semestre.html.twig', array(
            'nb_universites' =>$nbuniversites,
            'universites' => $universites,
            'semestreForm' => $semestreForm->createView()));
    }


    /**
     * Edit semestre controller.
     *
     * @param integer $id Semestre id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * */

    public function editSemestreAction($id, Request $request, Application $app) {

        $semestre = $app['dao.semestre']->find($id);
        $universites=$app['dao.universite']->findAll();
        $nbuniversites=count($universites);

        $universite=$semestre->getUniversite();

        $photo_semestre = $semestre->getPhoto();
        $logo_universite =$semestre->getUniversite()->getLogo();

        $datedebut = $semestre -> getDateDebut();
        $dateD = new DateTime($datedebut);
        $semestre->setDateDebut($dateD);

        $datefin = $semestre -> getDateFin();
        $dateF = new DateTime($datefin);
        $semestre->setDateFin($dateF);

        $originalCours = new ArrayCollection();

        $cours=$app['dao.cours']->findAllBySemestre($id);
        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($cours as $cour) {
            $semestre->addCour($cour);
            $originalCours->add($cour);
        }
        $semestreForm = $app['form.factory']->create(SemestreType::class, $semestre);
        $semestreForm->handleRequest($request);
        if ($semestreForm->isSubmitted() && $semestreForm->isValid()) {

            $courssemestre=$semestre->getCours();
            $logement=$semestre->getLogement();
            foreach ($originalCours as $cours) {
                if (false === $courssemestre->contains($cours)) {
                    $app['dao.cours']->delete($cours->getId());
                }
            }
            $path_universite = __DIR__.'/../../web/images/photo-universite/';
            $path_semestre = __DIR__.'/../../web/images/photo-semestre/';
            $file_semestre = $semestre->getPhoto();
            $file_universite = $universite->getLogo();

            if($semestreForm['photo']->getData()==null&&$semestreForm['universite']['logo']->getData()==null)
            {
                $semestre->setPhoto($photo_semestre);
                $semestre->getUniversite()->setLogo($logo_universite);
            }
            elseif ($semestreForm['photo']->getData()==null||$semestreForm['universite']['logo']->getData()==null)
            {
                if ($semestreForm['photo']->getData()!=null&&$semestreForm['universite']['logo']->getData()==null)
                {
                    $fileNameSemestre = md5(uniqid()).'.'.$file_semestre->guessExtension();
                    $file_semestre->move(
                        $path_semestre,
                        $fileNameSemestre
                    );
                    $semestre->setPhoto($fileNameSemestre);
                    $semestre->getUniversite()->setLogo($logo_universite);
                }
                elseif($semestreForm['photo']->getData()==null&&$semestreForm['universite']['logo']->getData()!=null)
                {
                    $fileNameUniversite = md5(uniqid()).'.'.$file_universite->guessExtension();
                    $file_universite->move(
                        $path_universite,
                        $fileNameUniversite
                    );
                    $universite->setLogo($fileNameUniversite);
                    $semestre->setPhoto($photo_semestre);
                }
            }
            else
            {
                $fileNameUniversite = md5(uniqid()).'.'.$file_universite->guessExtension();
                $file_universite->move(
                    $path_universite,
                    $fileNameUniversite
                );
                $universite->setLogo($fileNameUniversite);
                $fileNameSemestre = md5(uniqid()).'.'.$file_semestre->guessExtension();
                $file_semestre->move(
                    $path_semestre,
                    $fileNameSemestre
                );
                $semestre->setPhoto($fileNameSemestre);

            }

            $user = $semestre->getAuteur();
            $userId=$user->getId();
            $universite = $semestre ->getUniversite();
            $semestre->setAuteur($user);
            $app['dao.universite']->save($universite);
            $app['dao.semestre']->save($semestre);
            $app['dao.logement']->save($logement);
            foreach($courssemestre as $cour)
            {
                $app['dao.cours']->save($cour);
            }
            $app['session']->getFlashBag()->add('success', 'Les modifications ont bien été effectuées');

            return $app->redirect($app['url_generator']->generate('mesexperiences', array( 'id' => $userId )));
        }

        return $app['twig']->render('modification_semestre.html.twig', array(
            'photo_semestre'=>$photo_semestre,
            'photo_universite'=>$logo_universite,
            'nb_universites' =>$nbuniversites,
            'universites' => $universites,
            'semestreForm' => $semestreForm->createView()));
    }

    /**
     * Delete semestre controller.
     *
     * @param integer $id Semestre id
     * @param Application $app Silex application
     */
    public function deleteSemestreAction($id, Application $app) {
        $semestre=$app['dao.semestre']->find($id);
        $logementId=$semestre->getLogement()->getId();

        // Supprime les cours associés au semestre
        $app['dao.cours']->deleteAllBySemestre($id);
        // Supprime les commentaires associés au semestre
        $app['dao.commentsemestre']->deleteAllBySemestre($id);
        //Supprime le semestre
        $app['dao.semestre']->delete($id);
        //Supprime le logement associé au semestre
        $app['dao.logement']->delete($logementId);
        $app['session']->getFlashBag()->add('success', 'Le semestre a bien été supprimé');

        return $app->redirect($app['url_generator']->generate('mesexperiences'));

    }

    /**
     * Delete comment controller.
     *
     * @param integer $id Comment id
     * @param Application $app Silex application
     */
    public function deleteCommentStageAction($id, Application $app) {
        $app['dao.commentstage']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a été effacé avec succès.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('mescommentaires'));
    }

    /**
     * Delete comment controller.
     *
     * @param integer $id Comment id
     * @param Application $app Silex application
     */
    public function deleteCommentSemestreAction($id, Application $app) {
        $app['dao.commentsemestre']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a été effacé avec succès.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('mescommentaires'));
    }


}