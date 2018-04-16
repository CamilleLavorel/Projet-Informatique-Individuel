<?php

namespace ProjetInformatiqueIndividuel\Domain;

use Symfony\Component\Validator\Constraints as Assert;

class Entreprise  implements \JsonSerializable
{
    /**
     * Entreprise id.
     *
     * @var integer
     */
    private $id;

    /**
     * Entreprise nom.
     *
     * @var string
     */
    private $nom;

    /**
     * Entreprise description.
     *
     * @var string
     */
    private $description;

    /**
     * Entreprise adresse.
     *
     * @var string
     */
    private $adresse;

    /**
     * Entreprise mail.
     *
     * @var string
     */
    private $mail;

    /**
     * Entreprise logo.
     *
     * @var string
     *
     */
    private $logo;

    /**
     *Entreprise ville.
     *
     * @var string
     */
    private $ville;

    /**
     *Entreprise pays.
     *
     * @var string
     */
    private $pays;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
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

    public function getLogo() {
        return $this->logo;
    }

    public function setLogo($logo) {
        $this->logo = $logo;
        return $this;
    }

    public function getVille() {
        return $this->ville;
    }

    public function setVille($ville) {
        $this->ville = $ville;
        return $this;
    }

    public function getPays() {
        return $this->pays;
    }

    public function setPays($pays) {
        $this->pays = $pays;
        return $this;
    }

    public function getMail(){
        return $this->mail;
    }

    public function setMail($mail) {
        $this->mail = $mail;
        return $this;
    }

    public function  jsonSerialize(){
        $vars=get_object_vars($this);
        return $vars;
    }
}
