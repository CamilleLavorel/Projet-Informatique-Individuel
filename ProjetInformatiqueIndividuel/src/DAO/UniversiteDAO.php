<?php

namespace ProjetInformatiqueIndividuel\DAO;

use ProjetInformatiqueIndividuel\Domain\Universite;

class UniversiteDAO extends DAO
{
    /**
     * Retourne l'université qui correspond à l'id donné
     *
     * @param integer $id
     *
     * @return \ProjetInformatiqueIndividuel\Domain\Universite| soulève une exception si aucune université ne correspond à l'id donné
     */
    public function find($id)
    {
        $sql = "select * from universite where id_universite=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucune université ne correspond à l'id : " . $id);
    }


    /**
     * Retourne la liste de toutes les universités
     *
     * @return array La liste de toutes les universités
     */
    public function findAll()
    {
        $sql = "select * from universite";
        $result = $this->getDb()->fetchAll($sql);

        // Convertit les résultats de la requête en tableau d'objet Universite
        $universites = array();
        foreach ($result as $row) {
            $universiteId = $row['id_universite'];
            $universites[$universiteId] = $this->buildDomainObject($row);
        }
        return $universites;
    }


    /**
     * Retourne la liste de toutes les universités par ville
     *
     * @return array La liste de toutes les universités par ville
     */
    public function findAllbyCity($ville)
    {
        $sql = "select * from universite where ville_universite=?";
        $result = $this->getDb()->fetchAll($sql, array($ville));

        $universites = array();
        if ($result) {
            foreach ($result as $row) {
                $universiteId = $row['id_universite'];
                $universites[$universiteId] = $this->buildDomainObject($row);
            }
            return $universites;
        } else {
            throw new \Exception("Aucune université trouvée pour la ville : " . $ville);
        }
    }


    /**
     * Retourne la liste de toutes les universités par pays
     *
     * @return array La liste de toutes les universités par pays
     */
    public function findAllbyCountry($pays)
    {
        $sql = "select * from universite where pays_universite=?";
        $result = $this->getDb()->fetchAll($sql, array($pays));

        $universites = array();
        if ($result) {
            foreach ($result as $row) {
                $universiteId = $row['id_universite'];
                $universites[$universiteId] = $this->buildDomainObject($row);
            }
            return $universites;
        } else {
            throw new \Exception("Aucune université trouvée pour le pays : " . $pays);
        }
    }


    /**
     * Sauvegarde une université dans la bdd
     *
     * @param \ProjetInformatiqueIndividuel\Domain\Universite $universite L'université à sauvegarder
     */
    public function save(Universite $universite)
    {
        $universiteData = array(
            'nom_universite' => $universite->getNom(),
            'adresse_universite' => $universite->getAdresse(),
            'mail_contact' => $universite->getMail(),
            'logo_universite' => $universite->getLogo(),
            'description_universite' => $universite->getDescription(),
            'ville_universite' => $universite->getVille(),
            'pays_universite' => $universite->getPays(),
            'partenariat' => $universite->getPartenariat()
        );

        if ($universite->getId()) {
            // L'université a déjà été sauvegardé : mise à jour
            $this->getDb()->update('universite', $universiteData, array('id_universite' => $universite->getId()));
        } else {
            // L'université n'a jamais été sauvegardé : insertion
            $this->getDb()->insert('universite', $universiteData);
            // Récupère l'id de la nouvelle université crée et l'affecte à l'objet Universite
            $id = $this->getDb()->lastInsertId();
            $universite->setId($id);
        }
    }

    /**
     * Supprime une université de la bdd.
     *
     * @param integer $id L'id de l'université
     */
    public function delete($id)
    {

        $this->getDb()->delete('universite', array('id_universite' => $id));
    }


    /**
     * Crée un objet Université basé sur les attributs de la table universite de la bdd.
     *
     * @param array $row The DB row containing University data.
     * @return \ProjetInformatiqueIndividuel\Domain\Universite
     */
    protected function buildDomainObject(array $row)
    {
        $universite = new Universite();
        $universite->setId($row['id_universite']);
        $universite->setNom($row['nom_universite']);
        $universite->setAdresse($row['adresse_universite']);
        $universite->setMail($row['mail_contact']);
        $universite->setPartenariat($row['partenariat']);
        $universite->setLogo($row['logo_universite']);
        $universite->setDescription($row['description_universite']);
        $universite->setVille($row['ville_universite']);
        $universite->setPays($row['pays_universite']);
        return $universite;
    }

}

