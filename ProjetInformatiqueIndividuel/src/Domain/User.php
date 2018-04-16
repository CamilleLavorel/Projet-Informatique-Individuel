<?php

namespace ProjetInformatiqueIndividuel\Domain;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * User id.
     *
     * @var integer
     */
    private $id;

    /**
     * User name.
     *
     * @var string
     */
    private $username;

    /**
     * User password.
     *
     * @var string
     */
    private $password;

    /**
     * Salt that was originally used to encode the password.
     *
     * @var string
     */
    private $salt;

    /**
     * Role.
     * Values : ROLE_USER or ROLE_ADMIN.
     *
     * @var string
     */
    private $role;

    /**
     * User name.
     *
     * @var string
     */
    private $nom;

    /**
     * User forename.
     *
     * @var string
     */
    private $prenom;

    /**
     * User promo.
     *
     * @var integer
     */
    private $promo;

    /**
     * User e-mail.
     *
     * @var string
     */
    private $email;

    /**
     * User description.
     *
     * @var string
     */
    private $description;

    /**
     * User photo.
     *
     * @var string
     */
    private $photo;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array($this->getRole());
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        // Nothing to do here
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }

    public function getPromo() {
        return $this->promo;
    }

    public function setPromo($promo) {
        $this->promo = $promo;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }
}