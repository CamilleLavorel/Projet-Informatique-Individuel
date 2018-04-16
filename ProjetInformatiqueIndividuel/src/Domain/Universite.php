<?php

namespace ProjetInformatiqueIndividuel\Domain;

class Universite  implements \JsonSerializable
{
    /**
     * Universite id.
     *
     * @var integer
     */
    private $id;

    /**
     * Universite nom.
     *
     * @var string
     */
    private $nom;

    /**
     * Universite description.
     *
     * @var string
     */
    private $description;

    /**
     * Universite adresse.
     *
     * @var string
     */
    private $adresse;

    /**
     * Universite mail.
     *
     * @var string
     */
    private $mail;

    /**
     * Universite logo.
     *
     * @var string
     */
    private $logo;

    /**
     * Universite partenariat.
     *
     * @var string
     */
    private $partenariat;

    /**
     *Universite ville.
     *
     * @var string
     */
    private $ville;

    /**
     *Universite pays.
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

    public function getPartenariat() {
        return $this->partenariat;
    }

    public function setPartenariat($partenariat) {
        $this->partenariat = $partenariat;
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
