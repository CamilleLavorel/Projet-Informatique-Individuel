<?php

namespace ProjetInformatiqueIndividuel\Domain;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Semestre implements \JsonSerializable
{
    /**
     * Semestre id.
     *
     * @var integer
     */
    private $id;

    /**
     * Semestre title.
     *
     * @var string
     */
    private $titre;

    /**
     * Semestre description.
     *
     * @var string
     */
    private $description;

    /**
     * Semestre ressenti.
     *
     * @var string
     */
    private $ressentisemestre;

    /**
     * Universite ressenti.
     *
     * @var string
     */
    private $ressentiuniversite;


    /**
     * Semestre photo.
     *
     * @var string
     */
    private $photo;

    /**
     * Semestre duree.
     *
     * @var  int
     */
    private $duree;

    /**
     * Semestre date de début.
     *
     * @var string
     */
    private $datedebut;

    /**
     * Semestre date de fin.
     *
     * @var string
     */
    private $datefin;

    /**
     * Semestre date de publication.
     *
     * @var string
     */
    private $datepublication;

    /**
     * Semestre annee.
     *
     * @var string
     */
    private $annee;

    /**
     * Associated personne.
     *
     * @var \ProjetInformatiqueIndividuel\Domain\User
     */
    private $auteur;

    /**
     * Associated universite.
     *
     * @var \ProjetInformatiqueIndividuel\Domain\Universite
     */
    private $universite;

    /**
     * Associated logement.
     *
     * @var \ProjetInformatiqueIndividuel\Domain\Logement
     */
    private $logement;


    /**
     *
     *Associated cours
     *@ORM\OneToMany(targetEntity="\ProjetInformatiqueIndividuel\Domain\Cours", mappedBy="user", cascade={"persist"}, orphanRemoval=true)
     * @var \ProjetInformatiqueIndividuel\Domain\Cours
     */
    private $cours;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cours = new ArrayCollection();
    }

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

    public function getRessentiSemestre() {
        return $this->ressentisemestre;
    }

    public function setRessentiSemestre($ressentisemestre) {
        $this->ressentisemestre = $ressentisemestre;
        return $this;
    }

    public function getRessentiUniversite() {
        return $this->ressentiuniversite;
    }

    public function setRessentiUniversite($ressentiuniversite) {
        $this->ressentiuniversite = $ressentiuniversite;
        return $this;
    }

    public function getDuree() {
        return $this->duree;
    }

    public function setDuree($duree) {
        $this->duree = $duree;
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

    public function getAnnee() {
        return $this->annee;
    }

    public function setAnnee($annee) {
        $this->annee = $annee;
        return $this;
    }

    public function getAuteur(){
        return $this->auteur;
    }

    public function setAuteur(User $auteur) {
        $this->auteur = $auteur;
        return $this;
    }

    public function getUniversite(){
        return $this->universite;
    }

    public function setUniversite(Universite $universite) {
        $this->universite = $universite;
        return $this;
    }

    public function getLogement(){
        return $this->logement;
    }

    public function setLogement(Logement $logement) {
        $this->logement = $logement;
        return $this;
    }

    public function getPhoto(){
        return $this->photo;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
        return $this;
    }

    /**
     * Add cours
     *
     * @param \ProjetInformatiqueIndividuel\Domain\Cours $cours
     * @return Semestre
     */
    public function addCour(Cours $cours)
    {
        $this->cours[] = $cours;
        $cours->setSemestre($this);
        return $this;
    }

    /**
     * Remove cours
     *
     * @param \ProjetInformatiqueIndividuel\Domain\Cours $cours
     */
    public function removeCour(Cours $cours)
    {
        $this->cours->removeElement($cours);
    }

    /**
     * Get cours
     *
     * @return Collection
     */

    public function getCours(){
        return $this->cours;
    }


    public function  jsonSerialize(){
        $vars=get_object_vars($this);
        return $vars;
    }
}
