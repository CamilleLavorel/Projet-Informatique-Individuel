<?php

namespace ProjetInformatiqueIndividuel\DAO;

use ProjetInformatiqueIndividuel\Domain\Semestre;

class SemestreDAO extends DAO
{

    /**
     * @var \ProjetInformatiqueIndividuel\DAO\UniversiteDAO
     */
    private $universiteDAO;

    /**
     * @var \ProjetInformatiqueIndividuel\DAO\UserDAO
     */
    private $userDAO;

    /**
     * @var \ProjetInformatiqueIndividuel\DAO\LogementDAO
     */
    private $logementDAO;

    public function setUniversiteDAO(UniversiteDAO $universiteDAO) {
        $this->universiteDAO = $universiteDAO;
    }

    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }

    public function setLogementDAO(LogementDAO $logementDAO) {
        $this->logementDAO = $logementDAO;
    }

    /**
     * Return a list of all semester, sorted by date (most recent first).
     *
     * @return array A list of all semester.
     */
    public function findAll() {
        $sql = "select * from semestre order by id_semestre desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $semestres = array();
        foreach ($result as $row) {
            $semestreId = $row['id_semestre'];
            $semestres[$semestreId] = $this->buildDomainObject($row);
        }
        return $semestres;
    }

    /**
     * Returns a semester matching the supplied id.
     *
     * @param integer $id
     *
     * @return \ProjetInformatiqueIndividuel\Domain\Semestre|throws an exception if no matching semester is found
     */
    public function find($id) {
        $sql = "select * from semestre where id_semestre=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucun semestre ne correspond à l'id : " . $id);
    }


    public function findByUser($user) {
        $sql = "select * from semestre where id_utilisateur=? ";
        $result = $this->getDb()->fetchAll($sql, array($user));
        $semestres=array();
        foreach ($result as $row) {
            $semestreId = $row['id_semestre'];
            $semestre = $this->buildDomainObject($row);
            $semestres[$semestreId] = $semestre;
        }
        return $semestres;
    }


    public function findByPays($pays) {
        $sql = "select * from semestre s inner join universite u on u.id_universite=s.id_universite where u.pays_universite=? ";
        $result = $this->getDb()->fetchAll($sql, array($pays));
        $semestres=array();
        foreach ($result as $row) {
            $semestreId = $row['id_semestre'];
            $semestre= $this->buildDomainObject($row);
            $semestres[$semestreId] = $semestre;
        }
        return $semestres;
    }


    public function findByPaysVille($pays,$ville) {
        $sql = "select * from semestre s inner join universite u on u.id_universite=s.id_universite where (u.pays_universite=? and u.ville_universite=?)";
        $result = $this->getDb()->fetchAll($sql, array($pays,$ville));
        $semestres=array();
        foreach ($result as $row) {
            $semestreId = $row['id_semestre'];
            $semestre = $this->buildDomainObject($row);
            $semestres[$semestreId] = $semestre;
        }
        return $semestres;
    }



    /**
     * Sauvegarde un Semestre dans la base de données.
     *
     * @param \ProjetInformatiqueIndividuel\Domain\Semestre $semestre Le semestre à sauvegarder
     */
    public function save(Semestre $semestre) {
        $datetime = date("Y-m-d H:i:s");
        $datedebut = $semestre->getDateDebut();
        $datedebut = $datedebut->format("Y-m-d");
        $datefin = $semestre->getDateFin();
        $datefin = $datefin->format("Y-m-d");
        $semestreData = array(
            'titre_semestre' => $semestre->getTitre(),
            'duree_semestre' => $semestre->getDuree(),
            'date_debut_semestre' => $datedebut,
            'date_fin_semestre' => $datefin,
            'description_semestre' => $semestre->getDescription(),
            'ressenti_semestre' => $semestre->getRessentiSemestre(),
            'ressenti_universite' => $semestre->getRessentiUniversite(),
            'annee_ecole' => $semestre->getAnnee(),
            'photo_semestre' => $semestre->getPhoto(),
            'date_publication_semestre' => $datetime,
            'id_universite' => $semestre->getUniversite()->getId(),
            'id_logement' => $semestre->getLogement()->getId(),
            'id_utilisateur' => $semestre->getAuteur()->getId()
        );

        if ($semestre->getId()) {
            // Le semestre a déjà été sauvegardé : mise à jour
            $this->getDb()->update('semestre', $semestreData, array('id_semestre' => $semestre->getId()));
        } else {
            // Le semestre n'a jamais été sauvegardé: insertion
            $this->getDb()->insert('semestre', $semestreData);
            // Get the id of the newly created semester and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $semestre->setId($id);
        }
    }

    /**
     * Supprime un semestre de la base de données
     *
     * @param integer $id L'id du semestre.
     */
    public function delete($id) {

        $this->getDb()->delete('semestre', array('id_semestre' => $id));
    }


    /**
     * Supprime tous les semestres associés à un utilisateur
     *
     * @param integer $id L'id de l'utilisateur.
     */
    public function deleteAllByUser($userId) {
        //Supprimer le semestre
        $this->getDb()->delete('semestre', array('id_utilisateur' => $userId));
    }

    /**
     * Crée un objet Semestre basé sur les attributs de la table semestre de la bdd.
     *
     * @param array $row The DB row containing Semestre data.
     * @return \ProjetInformatiqueIndividuel\Domain\Semestre
     */
    protected function buildDomainObject(array $row) {
        $semestre = new Semestre();
        $semestre->setId($row['id_semestre']);
        $semestre->setTitre($row['titre_semestre']);
        $semestre->setDuree($row['duree_semestre']);
        $semestre->setDateDebut($row['date_debut_semestre']);
        $semestre->setDateFin($row['date_fin_semestre']);
        $semestre->setAnnee($row['annee_ecole']);
        $semestre->setDescription($row['description_semestre']);
        $semestre->setRessentiSemestre($row['ressenti_semestre']);
        $semestre->setRessentiUniversite($row['ressenti_universite']);
        $semestre->setPhoto($row['photo_semestre']);
        $semestre->setDatePublication($row['date_publication_semestre']);

        if (array_key_exists('id_universite', $row)) {
            $universiteId = $row['id_universite'];
            $universite = $this->universiteDAO->find($universiteId);
            $semestre->setUniversite($universite);
        }
        if (array_key_exists('id_logement', $row)) {
            $logementId = $row['id_logement'];
            $logement = $this->logementDAO->find($logementId);
            $semestre->setLogement($logement);
        }

        if (array_key_exists('id_utilisateur', $row)) {
            $userId = $row['id_utilisateur'];
            $user = $this->userDAO->find($userId);
            $semestre->setAuteur($user);
        }

        return $semestre;
    }
}