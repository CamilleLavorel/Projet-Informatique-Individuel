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
use ProjetInformatiqueIndividuel\Domain\User;
use ProjetInformatiqueIndividuel\Form\Type\UserType;
use ProjetInformatiqueIndividuel\Form\Type\StageType;
use ProjetInformatiqueIndividuel\Form\Type\SemestreType;
use ProjetInformatiqueIndividuel\Form\Type\UniversiteType;
use ProjetInformatiqueIndividuel\Form\Type\EntrepriseType;

class AdminController
{

    /**
     * Admin home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $semestres = $app['dao.semestre']->findAll();
        $stages=$app['dao.stage']->findAll();
        $universites=$app['dao.universite']->findAll();
        $entreprises=$app['dao.entreprise']->findAll();
        $commentaires_stage = $app['dao.commentstage']->findAll();
        $commentaires_semestre = $app['dao.commentsemestre']->findAll();
        $users = $app['dao.user']->findAll();
        return $app['twig']->render('admin.html.twig', array(
            'entreprises'=>$entreprises,
            'universites'=>$universites,
            'semestres' => $semestres,
            'stages'=>$stages,
            'commentairesstages' => $commentaires_stage,
            'commentairessemestres' => $commentaires_semestre,
            'users' => $users));
    }

    /**
     * Edit user controller.
     *
     * @param integer $id User id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editUserAction($id, Request $request, Application $app) {
        $user = $app['dao.user']->find($id);
        $file = $user->getPhoto();
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $role=$user->getRole();

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
            $user->setRole($role);

            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'Les modifications ont bien été effectuées');
            return $app->redirect($app['url_generator']->generate('admin'));

        }
        return $app['twig']->render('modification_utilisateur.html.twig', array(
            'photo'=>$file,
            'userForm' => $userForm->createView()));

    }

    /**
     * Delete user controller.
     *
     * @param integer $id User id
     * @param Application $app Silex application
     */
    public function deleteUserAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.commentstage']->deleteAllByUser($id);
        $app['dao.commentsemestre']->deleteAllByUser($id);

        $stages = $app['dao.stage']->findByUser($id);
        $semestres = $app['dao.semestre']->findByUser($id);
        foreach($stages as $stage)
        {
            $logementId=$stage->getLogement()->getId();
            $stageId=$stage->getId();
            $app['dao.logement']->delete($logementId);
            // Supprime les commentaires associés au stage
            $app['dao.commentstage']->deleteAllByStage($stageId);

        }
        foreach ($semestres as $semestre)
        {
            $logementId=$semestre->getLogement()->getId();
            $semestreId=$semestre->getId();
            $app['dao.logement']->delete($logementId);
            // Supprime les commentaires associés au semestre
            $app['dao.commentsemestre']->deleteAllBySemestre($semestreId);

        }
        $app['dao.stage']->deleteAllByUser($id);
        $app['dao.semestre']->deleteAllByUser($id);
        // Delete the user
        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('success', "L'utilisateur a bien été supprimé.");
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Add entreprise controller.
     *
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * */
    public function addEntrepriseAction(Request $request, Application $app) {

        $entreprise = new Entreprise();
        $entrepriseForm = $app['form.factory']->create(EntrepriseType::class, $entreprise);
        $entrepriseForm->handleRequest($request);
        if ($entrepriseForm->isSubmitted() && $entrepriseForm->isValid()) {

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
            $app['dao.entreprise']->save($entreprise);
            $app['session']->getFlashBag()->add('success', "L'entreprise a bien été rajoutée !");
            return $app->redirect($app['url_generator']->generate('admin'));
        }
        return $app['twig']->render('ajout_entreprise.html.twig', array(
            'entrepriseForm' => $entrepriseForm->createView()
        ));

    }

    /**
     * Edit entreprise controller.
     *
     * @param integer $id Entreprise id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * */
    public function editEntrepriseAction($id,Request $request, Application $app) {
        $entreprise = $app['dao.entreprise']->find($id);
        $file = $entreprise->getLogo();
        $entrepriseForm = $app['form.factory']->create(EntrepriseType::class, $entreprise);
        $entrepriseForm->handleRequest($request);
        if ($entrepriseForm->isSubmitted() && $entrepriseForm->isValid()) {

            if($entrepriseForm['logo']->getData()==null)
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
            $app['dao.entreprise']->save($entreprise);
            $app['session']->getFlashBag()->add('success', "L'entreprise a bien été modifiée !");
            return $app->redirect($app['url_generator']->generate('admin'));
        }
        return $app['twig']->render('modification_entreprise.html.twig', array(
            'photo_entreprise'=>$file,
            'entrepriseForm' => $entrepriseForm->createView()
        ));
    }

    /**
     * Delete entreprise controller.
     *
     * @param integer $id Entreprise id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * */
    public function deleteEntrepriseAction($id, Application $app) {
        $app['dao.entreprise']->delete($id);
        $app['session']->getFlashBag()->add('success', "L'entreprise a bien été supprimé");
        return $app->redirect($app['url_generator']->generate('admin'));
    }



    /**
     * Add universite controller.
     *
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * */

    public function addUniversiteAction(Request $request, Application $app) {
        $universite = new Universite();
        $universiteForm = $app['form.factory']->create(UniversiteType::class, $universite);
        $universiteForm->handleRequest($request);
        if ($universiteForm->isSubmitted() && $universiteForm->isValid()) {

            $path = __DIR__.'/../../web/images/photo-universite/';
            $file = $universite->getLogo();
            if($file)
            {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $path,
                    $fileName
                );
                $universite->setLogo($fileName);
            }
            else
            {
                $universite->setLogo("");
            }
            $app['dao.universite']->save($universite);
            $app['session']->getFlashBag()->add('success', "L'université a bien été rajoutée !");
            return $app->redirect($app['url_generator']->generate('admin'));
        }
        return $app['twig']->render('ajout_universite.html.twig', array(
            'universiteForm' => $universiteForm->createView()
        ));
    }

    /**
     * Edit universite controller.
     *
     * @param integer $id Universite id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * */

    public function editUniversiteAction($id, Request $request, Application $app) {

        $universite = $app['dao.universite']->find($id);
        $file = $universite->getLogo();
        $universiteForm = $app['form.factory']->create(UniversiteType::class, $universite);
        $universiteForm->handleRequest($request);
        if ($universiteForm->isSubmitted() && $universiteForm->isValid()) {

            if($universiteForm['logo']->getData()==null)
            {
                $universite->setLogo($file);
            }
            else
            {
                $path =__DIR__.'/../../web/images/photo-universite/';
                $file = $universite->getLogo();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $path,
                    $fileName
                );
                $universite->setLogo($fileName);
            }
            $app['dao.universite']->save($universite);
            $app['session']->getFlashBag()->add('success', "L'université a bien été modifiée !");
            return $app->redirect($app['url_generator']->generate('admin'));
        }
        return $app['twig']->render('modification_universite.html.twig', array(
            'photo_universite'=>$file,
            'universiteForm' => $universiteForm->createView()
        ));
    }


    /**
     * Delete universite controller.
     *
     * @param integer $id Universite id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * */

    public function deleteUniversiteAction($id, Application $app) {
        $app['dao.universite']->delete($id);
        $app['session']->getFlashBag()->add('success', "L'université a bien été supprimé");
        return $app->redirect($app['url_generator']->generate('admin'));
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
            $app['dao.logement']->save($logement);
            $app['dao.entreprise']->save($entreprise);
            $app['dao.stage']->save($stage);
            $app['session']->getFlashBag()->add('success', 'Les modifications ont bien été effectuées');

            return $app->redirect($app['url_generator']->generate('admin'));
        }
        return $app['twig']->render('modification_stage.html.twig', array(
            'photo_entreprise'=>$file,
            'stageForm' => $stageForm->createView()));

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

        $universite=$semestre->getUniversite();

        $photo_semestre = $semestre->getPhoto();
        $logo_universite =$universite->getLogo();

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

            $courssemestre = $semestre->getCours();
            foreach ($originalCours as $cours) {
                if (false === $courssemestre->contains($cours)) {
                    $app['dao.cours']->delete($cours->getId());
                }
            }
            $path_universite = __DIR__ . '/../../web/images/photo-universite/';
            $path_semestre = __DIR__ . '/../../web/images/photo-semestre/';
            $file_semestre = $semestre->getPhoto();
            $file_universite = $universite->getLogo();

            if ($semestreForm['photo']->getData() == null && $semestreForm['universite']['logo']->getData() == null) {
                $semestre->setPhoto($photo_semestre);
                $semestre->getUniversite()->setLogo($logo_universite);
            }
            elseif ($semestreForm['photo']->getData() == null || $semestreForm['universite']['logo']->getData() == null) {
                if ($semestreForm['photo']->getData() != null && $semestreForm['universite']['logo']->getData() == null) {
                    $fileNameSemestre = md5(uniqid()) . '.' . $file_semestre->guessExtension();
                    $file_semestre->move(
                        $path_semestre,
                        $fileNameSemestre
                    );
                    $semestre->setPhoto($fileNameSemestre);
                    $semestre->getUniversite()->setLogo($logo_universite);
                }
                elseif ($semestreForm['photo']->getData() == null && $semestreForm['universite']['logo']->getData() != null) {
                    $fileNameUniversite = md5(uniqid()) . '.' . $file_universite->guessExtension();
                    $file_universite->move(
                        $path_universite,
                        $fileNameUniversite
                    );
                    $universite->setLogo($fileNameUniversite);
                    $semestre->setPhoto($photo_semestre);
                }
            } else {
                $fileNameUniversite = md5(uniqid()) . '.' . $file_universite->guessExtension();
                $file_universite->move(
                    $path_universite,
                    $fileNameUniversite
                );
                $universite->setLogo($fileNameUniversite);
                $fileNameSemestre = md5(uniqid()) . '.' . $file_semestre->guessExtension();
                $file_semestre->move(
                    $path_semestre,
                    $fileNameSemestre
                );
                $semestre->setPhoto($fileNameSemestre);

            }

            $universite = $semestre->getUniversite();
            $logement=$semestre->getLogement();
            $app['dao.logement']->save($logement);
            $app['dao.universite']->save($universite);
            $app['dao.semestre']->save($semestre);
            foreach ($courssemestre as $cour) {
                $app['dao.cours']->save($cour);
            }
            $app['session']->getFlashBag()->add('success', 'Le semestre a bien été modifié.');

            return $app->redirect($app['url_generator']->generate('admin'));
        }
        return $app['twig']->render('modification_semestre.html.twig', array(
            'photo_semestre'=>$photo_semestre,
            'photo_universite'=>$logo_universite,
            'semestreForm' => $semestreForm->createView()));
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
        // Supprime les commentaires associés au stage
        $app['dao.commentstage']->deleteAllByStage($id);
        // Supprime le stage
        $app['dao.stage']->delete($id);
        //Supprime le logement associé au stage
        $app['dao.logement']->delete($logementId);
        $app['session']->getFlashBag()->add('success', 'Le stage a bien été supprimé');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));

    }

    /**
     * Delete semestre controller.
     *
     * @param integer $id Semestre id
     * @param Application $app Silex application
     */
    public function deleteSemestreAction($id, Application $app)
    {
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

        return $app->redirect($app['url_generator']->generate('admin'));

    }

    /**
     * Delete comment controller.
     *
     * @param integer $id Comment id
     * @param Application $app Silex application
     */
    public function deleteCommentStageAction($id, Application $app) {
        $app['dao.commentstage']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a été supprimé avec succès.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Delete comment controller.
     *
     * @param integer $id Comment id
     * @param Application $app Silex application
     */
    public function deleteCommentSemestreAction($id, Application $app) {
        $app['dao.commentsemestre']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a été supprimé à succès.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }






}