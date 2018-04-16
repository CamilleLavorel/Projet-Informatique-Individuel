<?php

namespace ProjetInformatiqueIndividuel\DAO;

use ProjetInformatiqueIndividuel\Domain\Stage;

class StageDAO extends DAO
{

    /**
     * @var \ProjetInformatiqueIndividuel\DAO\EntrepriseDAO
     */
    private $entrepriseDAO;

    /**
     * @var \ProjetInformatiqueIndividuel\DAO\UserDAO
     */
    private $userDAO;

    /**
     * @var \ProjetInformatiqueIndividuel\DAO\LogementDAO
     */
    private $logementDAO;

    public function setEntrepriseDAO(EntrepriseDAO $entrepriseDAO) {
        $this->entrepriseDAO = $entrepriseDAO;
    }

    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }

    public function setLogementDAO(LogementDAO $logementDAO) {
        $this->logementDAO = $logementDAO;
    }

    /**
     * Return a list of all internships, sorted by date (most recent first).
     *
     * @return array A list of all internship.
     */
    public function findAll() {
        $sql = "select * from stage order by id_stage desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $stages = array();
        foreach ($result as $row) {
            $stageId = $row['id_stage'];
            $stages[$stageId] = $this->buildDomainObject($row);
        }
        return $stages;
    }

    /**
     * Returns an internship matching the supplied id.
     *
     * @param integer $id
     *
     * @return \ProjetInformatiqueIndividuel\Domain\Stage|throws an exception if no matching internship is found
     */
    public function find($id) {
        $sql = "select * from stage where id_stage=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucun stage ne correspond à l'id : " . $id);
    }

    public function findByUser($user) {
        $sql = "select * from stage where id_utilisateur=? ";
        $result = $this->getDb()->fetchAll($sql, array($user));
        $stages=array();
        foreach ($result as $row) {
            $stageId = $row['id_stage'];
            $stage = $this->buildDomainObject($row);
            $stages[$stageId] = $stage;
        }
        return $stages;
    }

    public function findByPays($pays) {
        $sql = "select * from stage s inner join entreprise e on e.id_entreprise=s.id_entreprise where e.pays_entreprise=? ";
        $result = $this->getDb()->fetchAll($sql, array($pays));
        $stages=array();
        foreach ($result as $row) {
            $stageId = $row['id_stage'];
            $stage = $this->buildDomainObject($row);
            $stages[$stageId] = $stage;
        }
        return $stages;
    }


    public function findByPaysVille($pays,$ville) {
        $sql = "select * from stage s inner join entreprise e on e.id_entreprise=s.id_entreprise where (e.pays_entreprise=? and e.ville_entreprise=?)";
        $result = $this->getDb()->fetchAll($sql, array($pays,$ville));
        $stages=array();
        foreach ($result as $row) {
            $stageId = $row['id_stage'];
            $stage = $this->buildDomainObject($row);
            $stages[$stageId] = $stage;
        }
        return $stages;
    }

    /**
     * Saves an internship into the database.
     *
     * @param \ProjetInformatiqueIndividuel\Domain\Stage $stage The internship to save
     */
    public function save(Stage $stage) {
        $datetime = date("Y-m-d H:i:s");
        $datedebut = $stage->getDateDebut();
        $datedebut = $datedebut->format("Y-m-d");
        $datefin = $stage->getDateFin();
        $datefin = $datefin->format("Y-m-d");
        $stageData = array(
            'titre_stage' => $stage->getTitre(),
            'duree_stage' => $stage->getDuree(),
            'date_debut_stage' => $datedebut,
            'date_fin_stage' => $datefin,
            'description_stage' => $stage->getDescription(),
            'annee_ecole' => $stage->getAnnee(),
            'ressenti_stage' => $stage->getRessentiStage(),
            'ressenti_entreprise' => $stage->getRessentiEntreprise(),
            'sujet' => $stage->getSujet(),
            'date_publication_stage' => $datetime,
            'id_entreprise' => $stage->getEntreprise()->getId(),
            'id_logement' => $stage->getLogement()->getId(),
            'id_utilisateur' => $stage->getAuteur()->getId()
        );
        if ($stage->getId()) {
            // The internship has already been saved : update it
            $this->getDb()->update('stage', $stageData, array('id_stage' => $stage->getId()));
        } else {
            // The internship has never been saved : insert it
            $this->getDb()->insert('stage', $stageData);
            // Get the id of the newly created internship and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $stage->setId($id);
        }
    }

    /**
     * Removes an internship from the database.
     *
     * @param integer $id The internship id.
     */
    public function delete($id) {
        //Supprimer le stage
        $this->getDb()->delete('stage', array('id_stage' => $id));
    }

    /**
     * Removes an internship from the database.
     *
     * @param integer $id L'id de l'utilisateur.
     */
    public function deleteAllByUser($userId) {
        //Supprimer le stage
        $this->getDb()->delete('stage', array('id_utilisateur' => $userId));
    }


    /**
     * Creates an Intership object based on a DB row.
     *
     * @param array $row The DB row containing Stage data.
     * @return \ProjetInformatiqueIndividuel\Domain\Stage
     */
    protected function buildDomainObject(array $row) {
        $stage = new Stage();
        $datetime = date("Y-m-d H:i:s");
        $stage->setId($row['id_stage']);
        $stage->setTitre($row['titre_stage']);
        $stage->setDuree($row['duree_stage']);
        $stage->setAnnee($row['annee_ecole']);
        $stage->setDateDebut($row['date_debut_stage']);
        $stage->setDateFin($row['date_fin_stage']);
        $stage->setDescription($row['description_stage']);
        $stage->setRessentiStage($row['ressenti_stage']);
        $stage->setRessentiEntreprise($row['ressenti_entreprise']);
        $stage->setSujet($row['sujet']);
        $stage->setDatePublication($datetime);

        if (array_key_exists('id_entreprise', $row)) {
            $entrepriseId = $row['id_entreprise'];
            $entreprise = $this->entrepriseDAO->find($entrepriseId);
            $stage->setEntreprise($entreprise);
        }

        if (array_key_exists('id_logement', $row)) {
            $logementId = $row['id_logement'];
            $logement = $this->logementDAO->find($logementId);
            $stage->setLogement($logement);
        }


        if (array_key_exists('id_utilisateur', $row)) {
            $userId = $row['id_utilisateur'];
            $user = $this->userDAO->find($userId);
            $stage->setAuteur($user);
        }

        return $stage;
    }
}