<?php

namespace ProjetInformatiqueIndividuel\Domain;

class Logement  implements \JsonSerializable
{
    /**
     * Logement id.
     *
     * @var integer
     */
    private $id;

    /**
     * Associated personne.
     *
     * @var \ProjetInformatiqueIndividuel\Domain\User
     */
    private $personne;


    /**
     * Associated internship.
     *
     * @var \ProjetInformatiqueIndividuel\Domain\Stage
     */
    private $stage;

    /**
     * Associated semestre.
     *
     * @var \ProjetInformatiqueIndividuel\Domain\Semestre
     */
    private $semestre;


    /**
     * Logement adresse.
     *
     * @var string
     */
    private $adresse;

    /**
     * Logement pays.
     *
     * @var string
     */
    private $pays;

    /**
     * Logement ville.
     *
     * @var string
     */
    private $ville;

    /**
     * Logement contact.
     *
     * @var string
     */
    private $contact;

    /**
     * Logement description.
     *
     * @var string
     */
    private $description;

    /**
     * Logement ressenti.
     *
     * @var string
     */
    private $ressenti;

    /**
     * Logement budget.
     *
     * @var string
     */
    private $budget;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getPersonne() {
        return $this->personne;
    }

    public function setPersonne(User $personne) {
        $this->personne = $personne;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
        return $this;
    }

    public function getRessenti() {
        return $this->ressenti;
    }

        public function setRessenti($ressenti) {
        $this->ressenti = $ressenti;
        return $this;
    }

    public function getStage() {
        return $this->stage;
    }

    public function setStage(Stage $stage) {
        $this->stage = $stage;
        return $this;
    }

    public function getSemestre() {
        return $this->semestre;
    }

    public function setSemestre(Semestre $semestre) {
        $this->semestre = $semestre;
        return $this;
    }

    public function getBudget() {
        return $this->budget;
    }

    public function setBudget($budget) {
        $this->budget = $budget;
        return $this;
    }

    public function getPays() {
        return $this->pays;
    }

    public function setPays($pays) {
        $this->pays = $pays;
        return $this;
    }

    public function getVille() {
        return $this->ville;
    }

    public function setVille($ville) {
        $this->ville = $ville;
        return $this;
    }

    public function getContact() {
        return $this->contact;
    }

    public function setContact($contact) {
        $this->contact = $contact;
        return $this;
    }

    public function  jsonSerialize(){
        $vars=get_object_vars($this);
        return $vars;
    }
}