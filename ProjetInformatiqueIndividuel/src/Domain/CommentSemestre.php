<?php

namespace ProjetInformatiqueIndividuel\Domain;

class CommentSemestre
{
    /**
     * Comment id.
     *
     * @var integer
     */
    private $id;

    /**
     * Associated personne.
     *
     * @var \ProjetInformatiqueIndividuel\Domain\User
     */
    private $auteur;

    /**
     * Comment content.
     *
     * @var integer
     */
    private $content;

    /**
     * Comment date.
     *
     * @var datetime
     */
    private $date;

    /**
     * Associated semestre.
     *
     * @var \ProjetInformatiqueIndividuel\Domain\Semestre
     */
    private $semestre;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getAuteur() {
        return $this->auteur;
    }

    public function setAuteur(User $auteur) {
        $this->auteur = $auteur;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getSemestre() {
        return $this->semestre;
    }

    public function setSemestre(Semestre $semestre) {
        $this->semestre = $semestre;
        return $this;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

}