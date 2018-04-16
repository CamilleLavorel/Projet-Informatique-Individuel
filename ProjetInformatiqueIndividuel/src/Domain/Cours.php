<?php

namespace ProjetInformatiqueIndividuel\Domain;

class Cours
{
    /**
     * Cours id.
     *
     * @var integer
     */
    private $id;

    /**
     * Cours title.
     *
     * @var string
     */
    private $titre;


    /**
     * Associated  semestre.
     *
     * @ORM\ManyToOne(targetEntity="\ProjetInformatiqueIndividuel\Domain\Semestre", inversedBy="cours")
     *
     * @var \ProjetInformatiqueIndividuel\Domain\Semestre
     */
    private $semestre;

    /**
     * Cours description.
     *
     * @var string
     */
    private $description;

    /**
     * Cours ressenti.
     *
     * @var string
     */
    private $ressenti;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getSemestre() {
        return $this->semestre;
    }

    public function setSemestre(Semestre $semestre) {
        $this->semestre = $semestre;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
        return $this;
    }

    public function getRessenti() {
        return $this->ressenti;
    }

    public function setRessenti($ressenti) {
        $this->ressenti = $ressenti;
        return $this;
    }
}