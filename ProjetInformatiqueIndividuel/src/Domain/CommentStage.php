<?php

namespace ProjetInformatiqueIndividuel\Domain;

class CommentStage
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
     * @var \Datetime
     */
    private $date;

    /**
     * Associated stage.
     *
     * @var \ProjetInformatiqueIndividuel\Domain\Stage
     */
    private $stage;

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

    public function getStage() {
        return $this->stage;
    }

    public function setStage(Stage $stage) {
        $this->stage = $stage;
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