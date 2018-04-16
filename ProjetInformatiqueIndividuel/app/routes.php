<?php
/* PAGES PRINCIPALES */

// Page d'accueil
$app->get('/', "ProjetInformatiqueIndividuel\Controller\HomeController::indexAction")
    ->bind('home');

// Page contenant les partenariats
$app->get('/partenariats', "ProjetInformatiqueIndividuel\Controller\HomeController::partenariatAction")
    ->bind('partenariat');

// Page contenant les partenariats
$app->get('/informations-pratiques', "ProjetInformatiqueIndividuel\Controller\HomeController::infosPratiquesAction")
    ->bind('informations-pratiques');

// Page de recherche de stage
$app->match('/recherche-stage',"ProjetInformatiqueIndividuel\Controller\HomeController::rechercheStageAction")
    ->bind('recherche-stage');

// Page d'un stage
$app->match('/stage/{id}',"ProjetInformatiqueIndividuel\Controller\HomeController::stageAction")
    ->bind('stage');

// Page de recherche de semestre
$app->match('/recherche-semestre',"ProjetInformatiqueIndividuel\Controller\HomeController::rechercheSemestreAction")
    ->bind('recherche-semestre');

// Page d'un semestre
$app->match('/semestre/{id}',"ProjetInformatiqueIndividuel\Controller\HomeController::semestreAction")
    ->bind('semestre');

// Page de connexion

$app->get('/login',"ProjetInformatiqueIndividuel\Controller\HomeController::loginAction")
    ->bind('login');

// Page d'inscription
$app->match('/inscription',"ProjetInformatiqueIndividuel\Controller\HomeController::inscriptionAction")
    ->bind('inscription');


/* UTILISATEURS CONNECTES */

// Page des expériences d'un utilisateur
$app->get('/mesexperiences',"ProjetInformatiqueIndividuel\Controller\UserController::experiencesAction")
    ->bind('mesexperiences');

// Page contenant les commentaires d'un utilisateur
$app->get('/mescommentaires',"ProjetInformatiqueIndividuel\Controller\UserController::commentairesAction")
    ->bind('mescommentaires');

// Profil
$app->get('/profil',"ProjetInformatiqueIndividuel\Controller\UserController::profilAction")
    ->bind('profil');

// Modification du profil
$app->match('/modification_profil',"ProjetInformatiqueIndividuel\Controller\UserController::editProfilAction")
    ->bind('modificationprofil');

// Ajout d'un stage par un utilisateur
$app->match('/ajout_stage',"ProjetInformatiqueIndividuel\Controller\UserController::addStageAction")
    ->bind('ajoutstage');

// Modification d'un stage par un utilisateur
$app->match('/modification_stage/{id}',"ProjetInformatiqueIndividuel\Controller\UserController::editStageAction")
    ->bind('modificationstage');

// Ajout d'un semestre par un utilisateur
$app->match('/ajout_semestre',"ProjetInformatiqueIndividuel\Controller\UserController::addSemestreAction")
    ->bind('ajoutsemestre');

// Mdification d'un semestre par un utilisateur
$app->match('/modification_semestre/{id}',"ProjetInformatiqueIndividuel\Controller\UserController::editSemestreAction")
    ->bind('modificationsemestre');

//  Suppression d'un stage par un utilisateur
$app->get('/mesexperiences/stage/{id}/suppression',"ProjetInformatiqueIndividuel\Controller\UserController::deleteStageAction")
    ->bind('mesexperiences_stage_suppression');

// Suppression d'un semestre par un utilisateur
$app->get('/mesexperiences/semestre/{id}/suppression',"ProjetInformatiqueIndividuel\Controller\UserController::deleteSemestreAction")
    ->bind('mesexperiences_semestre_suppression');

//  Suppression d'un commentaire sur stage par un utilisateur
$app->get('/mescommentaires/stage/{id}/suppression',"ProjetInformatiqueIndividuel\Controller\UserController::deleteCommentStageAction")
    ->bind('mescommentaires_stage_suppression');

// Suppression d'un commentaire sur un semestre par un utilisateur
$app->get('/mescommentaires/semestre/{id}/suppression',"ProjetInformatiqueIndividuel\Controller\UserController::deleteCommentSemestreAction")
    ->bind('mescommentaires_semestre_suppression');


/* ADMIN */

// Page admin
$app->get('/admin',"ProjetInformatiqueIndividuel\Controller\AdminController::indexAction")
    ->bind('admin');

// Ajout d'une entreprise
$app->match('/admin/ajout_entreprise',"ProjetInformatiqueIndividuel\Controller\AdminController::addEntrepriseAction")
    ->bind('admin_ajout_entreprise');

// Modification d'une entreprise
$app->match('/admin/modification_entreprise/{id}',"ProjetInformatiqueIndividuel\Controller\AdminController::editEntrepriseAction")
    ->bind('admin_modification_entreprise');

// Suppression d'une entreprise
$app->match('/admin/suppression_entreprise/{id}', "ProjetInformatiqueIndividuel\Controller\AdminController::deleteEntrepriseAction")
    ->bind('admin_suppression_entreprise');

// Ajout d'une université
$app->match('/admin/ajout_universite',"ProjetInformatiqueIndividuel\Controller\AdminController::addUniversiteAction")
    ->bind('admin_ajout_universite');

// Modification d'une université
$app->match('/admin/modification_universite/{id}', "ProjetInformatiqueIndividuel\Controller\AdminController::editUniversiteAction")
    ->bind('admin_modification_universite');

//Suppression d'une université
$app->match('/admin/suppression_universite/{id}',"ProjetInformatiqueIndividuel\Controller\AdminController::deleteUniversiteAction")
    ->bind('admin_suppression_universite');

// Modification d'un semestre
$app->match('/admin/modification_semestre/{id}',"ProjetInformatiqueIndividuel\Controller\AdminController::editSemestreAction")
    ->bind('admin_modification_semestre');

// Suppression d'un semestre
$app->match('/admin/suppression_semestre/{id}',"ProjetInformatiqueIndividuel\Controller\AdminController::deleteSemestreAction")
    ->bind('admin_suppression_semestre');

// Modification d'un stage
$app->match('/admin/modification_stage/{id}',"ProjetInformatiqueIndividuel\Controller\AdminController::editStageAction")
    ->bind('admin_modification_stage');

// Suppression d'un stage
$app->match('/admin/suppression_stage/{id}',"ProjetInformatiqueIndividuel\Controller\AdminController::deleteStageAction")
    ->bind('admin_suppression_stage');

// Suppression d'un commentaire sur un stage
$app->match('/admin/suppression_commentaire_stage/{id}',"ProjetInformatiqueIndividuel\Controller\AdminController::deleteCommentStageAction")
    ->bind('admin_suppression_commentaire_stage');

// Suppression d'un commentaire sur un semestre
$app->match('/admin/suppression_commentaire_semestre/{id}',"ProjetInformatiqueIndividuel\Controller\AdminController::deleteCommentSemestreAction")
    ->bind('admin_suppression_commentaire_semestre');

// Modification d'un profil d'utilisateur
$app->match('/admin/modification_utilisateur/{id}',"ProjetInformatiqueIndividuel\Controller\AdminController::editUserAction")
    ->bind('admin_modification_user');

// Suppression d'un profil d'utilisateur
$app->match('/admin/suppression_utilisateur/{id}',"ProjetInformatiqueIndividuel\Controller\AdminController::deleteUserAction")
    ->bind('admin_suppression_user');