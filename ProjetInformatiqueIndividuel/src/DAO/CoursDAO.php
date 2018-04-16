<?php

namespace ProjetInformatiqueIndividuel\DAO;

use ProjetInformatiqueIndividuel\Domain\Cours;

class CoursDAO extends DAO
{
    /**
     * @var \ProjetInformatiqueIndividuel\DAO\SemestreDAO
     */
    private $semestreDAO;


    public function setSemestreDAO(SemestreDAO $semestreDAO) {
        $this->semestreDAO = $semestreDAO;
    }


    /**
     * Retourne la liste des cours triée par date
     *
     * @return array La liste de tous les cours
     */
    public function findAll() {
        $sql = "select * from cours order by id_cours desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convertit les résultats de la requête en tableau contenant des objets "Cours"
        $cours = array();
        foreach ($result as $row) {
            $coursId = $row['id_cours'];
            $cours[$coursId] = $this->buildDomainObject($row);
        }
        return $cours;
    }

    /**
     * Retourne la liste de tous les cours associés à un semestre Return a list of all cours for a semester, sorted by date (most recent last).
     *
     * @param integer $semestreId L'id du semestre.
     *
     * @return array La liste de tous les cours associés au semestre.
     */
    public function findAllBySemestre($semestreId) {

        $semestre = $this->semestreDAO->find($semestreId);

        $sql = "select id_cours, titre_cours, description_cours, ressenti_cours from cours where id_semestre=? order by id_cours";
        $result = $this->getDb()->fetchAll($sql, array($semestreId));

        // Convertit les résultats de la requête en tableau d'objet Cours.
        $cours = array();
        foreach ($result as $row) {
            $coursId = $row['id_cours'];
            $cour = $this->buildDomainObject($row);
            // Le semestre associé est défini pour le cours construit
            $cour->setSemestre($semestre);
            $cours[$coursId] = $cour;
        }
        return $cours;
    }


    /**
     * Supprimer un cours de la base de données.
     *
     * @param @param integer $id L'id du cours
     */
    public function delete($id) {
        // Supprime le cours
        $this->getDb()->delete('cours', array('id_cours' => $id));
    }

    /**
     * Sauvegarde un cours dans la base de données.
     *
     * @param \ProjetInformatiqueIndividuel\Domain\Cours $cours Le cours à sauvegarder
     */
    public function save(Cours $cours) {
        $coursData = array(
            'id_semestre' => $cours->getSemestre()->getId(),
            'titre_cours' => $cours->getTitre(),
            'description_cours' => $cours->getDescription(),
            'ressenti_cours' =>$cours->getRessenti()
        );

        if ($cours->getId()) {
            // Le cours a déjà été sauvegardé : Mise à jour dans la bdd
            $this->getDb()->update('cours', $coursData, array('id_cours' => $cours->getId()));
        } else {
            // Le cours n'a jamais été sauvegardé : Insertion dans la bdd
            $this->getDb()->insert('cours', $coursData);
            // Get the id of the newly created comment and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $cours->setId($id);
        }
    }

    /**
     * Supprimer tous les cours liés à un semestre
     *
     * @param $semestreId L'id du semestre
     */
    public function deleteAllBySemestre($semestreId) {
        $this->getDb()->delete('cours', array('id_semestre' => $semestreId));
    }

    /**
     * Crée un objet Cours basé sur les attributs de la base de données.
     *
     * @param array $row The DB row containing Cours data.
     * @return \ProjetInformatiqueIndividuel\Domain\Cours
     */
    protected function buildDomainObject(array $row) {
        $cours = new Cours();
        $cours->setId($row['id_cours']);
        $cours->setTitre($row['titre_cours']);
        $cours->setDescription($row['description_cours']);
        $cours->setRessenti($row['ressenti_cours']);

        if (array_key_exists('id_semestre', $row)) {
            // Find and set the associated article
            $semestreId = $row['id_semestre'];
            $semestre = $this->semestreDAO->find($semestreId);
            $cours->setSemestre($semestre);
        }

        return $cours;
    }
}