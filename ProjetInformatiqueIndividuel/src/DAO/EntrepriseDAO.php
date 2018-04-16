<?php

namespace ProjetInformatiqueIndividuel\DAO;

use ProjetInformatiqueIndividuel\Domain\Entreprise;

class EntrepriseDAO extends DAO
{
    /**
     * Retourne la liste de toutes les entreprises de la base de données.
     *
     * @return array La liste de toutes les entreprises
     */
    public function findAll() {
        $sql = "select * from entreprise";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entreprises = array();
        foreach ($result as $row) {
            $entrepriseId = $row['id_entreprise'];
            $entreprises[$entrepriseId] = $this->buildDomainObject($row);
        }
        return $entreprises;
    }

    /**
     * Retourne l'entreprise qui correspond à l'id donné.
     *
     * @param integer $id
     *
     * @return \ProjetInformatiqueIndividuel\Domain\Entreprise| soulève une exception si aucune entreprise ne correspond à l'id donné
     */
    public function find($id) {
        $sql = "select * from entreprise where id_entreprise=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucune entreprise ne correspond à l'id : " . $id);
    }


    /**
     * Retourne la liste de toutes les entreprises par ville
     *
     * @return array La liste de toutes les entreprises par ville
     */
    public function findAllbyCity($ville) {
        $sql = "select * from entreprise where ville_entreprise=?";
        $result = $this->getDb()->fetchAll($sql,array($ville));

        // Convertit les résultats de la requête en tableau d'objet Entreprise
        $entreprises = array();
        if ($result) {
            foreach ($result as $row) {
                $entrepriseId = $row['id_entreprise'];
                $entreprises[$entrepriseId] = $this->buildDomainObject($row);
            }
            return $entreprises;
        }
        else{
            throw new \Exception("Aucune entreprise trouvée pour la ville : " . $ville);
        }
    }


    /**
     * Retourne la liste de toutes les entreprises par pays
     *
     * @return array La liste de toutes les entreprises par pays
     */
    public function findAllbyCountry($pays) {
        $sql = "select * from universite where pays_universite=?";
        $result = $this->getDb()->fetchAll($sql,array($pays));

        // Convertit les résultats de la requête en tableau d'objet Entreprise
        $entreprises = array();
        if ($result) {
            foreach ($result as $row) {
                $entrepriseId = $row['id_entreprise'];
                $entreprises[$entrepriseId] = $this->buildDomainObject($row);
            }
            return $entreprises;
        }
        else{
            throw new \Exception("Aucune entreprise trouvée pour le pays : " . $pays);
        }
    }


    /**
     * Sauvegarde une entreprise dans la base de données
     *
     * @param \ProjetInformatiqueIndividuel\Domain\Entreprise $entreprise L'entreprise à sauvegarder.
     */
    public function save(Entreprise $entreprise) {
        $entrepriseData = array(
            'nom_entreprise' => $entreprise->getNom(),
            'adresse_entreprise' => $entreprise->getAdresse(),
            'mail_contact' => $entreprise->getMail(),
            'logo_entreprise' => $entreprise->getLogo(),
            'description_entreprise' => $entreprise->getDescription(),
            'ville_entreprise' => $entreprise->getVille(),
            'pays_entreprise' => $entreprise->getPays()
        );

        if ($entreprise->getId()) {
            // L'entreprise a déjà été sauvegardé : mise à jour
            $this->getDb()->update('entreprise', $entrepriseData, array('id_entreprise' => $entreprise->getId()));
        } else {
            // L'entreprise n'a jamais été sauvegardé : insertion
            $this->getDb()->insert('entreprise', $entrepriseData);
            // Récupère l'id de la nouvelle entreprise crée et l'affecte à l'objet Entreprise
            $id = $this->getDb()->lastInsertId();
            $entreprise->setId($id);
        }
    }

    /**
     * Supprime une entreprise de la base de données
     *
     * @param integer $id L'id de l'entreprise
     */
    public function delete($id) {

        $this->getDb()->delete('entreprise', array('id_entreprise' => $id));
    }



    /**
     * Crée un objet Entreprise basé sur les attributs de la table entreprise de la base de données.
     *
     * @param array $row The DB row containing company data.
     * @return \ProjetInformatiqueIndividuel\Domain\Entreprise
     */
    protected function buildDomainObject(array $row) {
        $entreprise = new Entreprise();
        $entreprise->setId($row['id_entreprise']);
        $entreprise->setNom($row['nom_entreprise']);
        $entreprise->setAdresse($row['adresse_entreprise']);
        $entreprise->setMail($row['mail_contact']);
        $entreprise->setLogo($row['logo_entreprise']);
        $entreprise->setDescription($row['description_entreprise']);
        $entreprise->setVille($row['ville_entreprise']);
        $entreprise->setPays($row['pays_entreprise']);
        return $entreprise;
    }

}

