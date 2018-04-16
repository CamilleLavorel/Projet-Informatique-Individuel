<?php

namespace ProjetInformatiqueIndividuel\DAO;

use ProjetInformatiqueIndividuel\Domain\Logement;

class LogementDAO extends DAO
{

    /**
     * Retourne la liste de tous les logements triés par date (le plus récent en premier).
     *
     * @return array La liste de tous les logements.
     */
    public function findAll() {
        $sql = "select * from logement order by id_logement desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convertit le résultat de la requête en tableau contenant des objets "Logement"
        $entities = array();
        foreach ($result as $row) {
            $id = $row['id_logement'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    /**
     * Retourne le logement correspondant à l'id entré en paramètre
     *
     * @param integer $id L'id du logement
     *
     * @return \ProjetInformatiqueIndividuel\Domain\Logement| soulève une exception si aucun logement ne correspond à l'id
     */
    public function find($id) {
        $sql = "select * from logement where id_logement=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucun logement ne correspond à l'id :  " . $id);
    }

    /**
     * Supprime un logement de la base de données.
     *
     * @param @param integer $id L'id du logement
     */
    public function delete($id) {
        // Supprime le logement
        $this->getDb()->delete('logement', array('id_logement' => $id));
    }

    /**
     * Sauvegarde un logement dans la base de données.
     *
     * @param \ProjetInformatiqueIndividuel\Domain\Logement $logement Le logement à sauvegarder(ajouter)
     */
    public function save(Logement $logement) {
        $logementData = array(
            'adresse_logement' => $logement->getAdresse(),
            'description_logement' => $logement->getDescription(),
            'ville_logement' => $logement->getVille(),
            'pays_logement' => $logement->getPays(),
            'ressenti_logement' => $logement->getRessenti(),
            'contact_logement' => $logement->getContact(),
            'budget_logement' => $logement->getBudget()
        );

        if ($logement->getId()) {
            // Le logement a déjà été ajouté : mise à jour
            $this->getDb()->update('logement', $logementData, array('id_logement' => $logement->getId()));
        } else {
            // Le logement n'a jamais été ajouté : insertion
            $this->getDb()->insert('logement', $logementData);
            // Récupère l'id du nouveau logement et ajoute le à l'entité Logement.
            $id = $this->getDb()->lastInsertId();
            $logement->setId($id);
        }
    }



    /**
     * Crée un objet Logement basé sur les attributs de la table logement de la base de données.
     *
     * @param array $row The DB row contenant les données sur Logement.
     * @return \ProjetInformatiqueIndividuel\Domain\Logement
     */
    protected function buildDomainObject(array $row) {
        $logement = new Logement();
        $logement->setId($row['id_logement']);
        $logement->setAdresse($row['adresse_logement']);
        $logement->setDescription($row['description_logement']);
        $logement->setVille($row['ville_logement']);
        $logement->setPays($row['pays_logement']);
        $logement->setRessenti($row['ressenti_logement']);
        $logement->setContact($row['contact_logement']);
        $logement->setBudget($row['budget_logement']);

        return $logement;
    }
}