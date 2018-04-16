<?php

namespace ProjetInformatiqueIndividuel\Domain;

class Stage implements \JsonSerializable
{
    /**
     * Stage id.
     *
     * @var integer
     */
    private $id;

    /**
     * Stage title.
     *
     * @var string
     */
    private $titre;

    /**
     * Stage description.
     *
     * @var string
     */
    private $description;

    /**
     * Stage ressenti.
     *
     * @var string
     */
    private $ressentistage;

    /**
     * Entreprise ressenti.
     *
     * @var string
     */
    private $ressentientreprise;


    /**
     * Stage sujet.
     *
     * @var string
     */
    private $sujet;

    /**
     * Stage duree.
     *
     * @var string
     */
    private $duree;

    /**
     * Stage annee.
     *
     * @var string
     */
    private $annee;

    /**
     * Stage date de début.
     *
     * @var \Datetime
     */
    private $datedebut;

    /**
     * Stage date de fin.
     *
     * @var \DateTime
     */
    private $datefin;

    /**
     * Stage date de publication.
     *
     * @var \Datetime
     */
    private $datepublication;

    /**
     * Associated personne.
     *
     * @var \ProjetInformatiqueIndividuel\Domain\User
     */
    private $auteur;

    /**
     * Associated entreprise.
     *
     * @var \ProjetInformatiqueIndividuel\Domain\Entreprise
     */
    private $entreprise;

    /**
     * Associated logement.
     *
     * @var \ProjetInformatiqueIndividuel\Domain\Logement
     */
    private $logement;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getRessentiStage() {
        return $this->ressentistage;
    }

    public function setRessentiStage($ressentistage) {
        $this->ressentistage = $ressentistage;
        return $this;
    }

    public function getRessentiEntreprise() {
        return $this->ressentientreprise;
    }

    public function setRessentiEntreprise($ressentientreprise) {
        $this->ressentientreprise = $ressentientreprise;
        return $this;
    }

    public function getSujet() {
        return $this->sujet;
    }

    public function setSujet($sujet) {
        $this->sujet = $sujet;
        return $this;
    }

    public function getDuree() {
        return $this->duree;
    }

    public function setDuree($duree) {
        $this->duree = $duree;
        return $this;
    }

    public function getAnnee() {
        return $this->annee;
    }

    public function setAnnee($annee) {
        $this->annee = $annee;
        return $this;
    }

    public function getDateDebut() {
        return $this->datedebut;
    }

    public function setDateDebut($datedebut) {
        $this->datedebut = $datedebut;
        return $this;
    }

    public function getDateFin() {
        return $this->datefin;
    }

    public function setDateFin($datefin) {
        $this->datefin = $datefin;
        return $this;
    }

    public function getDatePublication() {
        return $this->datepublication;
    }

    public function setDatePublication($datepublication) {
        $this->datepublication = $datepublication;
        return $this;
    }

    public function getAuteur(){
        return $this->auteur;
    }

    public function setAuteur(User $auteur) {
        $this->auteur = $auteur;
        return $this;
    }

    public function getEntreprise(){
        return $this->entreprise;
    }

    public function setEntreprise(Entreprise $entreprise) {
        $this->entreprise = $entreprise;
        return $this;
    }


    public function getLogement(){
        return $this->logement;
    }

    public function setLogement(Logement $logement) {
        $this->logement = $logement;
        return $this;
    }

    public function  jsonSerialize(){
        $vars=get_object_vars($this);
        return $vars;
    }
}
