<?php

namespace ProjetInformatiqueIndividuel\DAO;

use ProjetInformatiqueIndividuel\Domain\CommentSemestre;

class CommentSemestreDAO extends DAO
{
    /**
     * @var \ProjetInformatiqueIndividuel\DAO\SemestreDAO
     */
    private $semestreDAO;

    /**
     * @var \ProjetInformatiqueIndividuel\DAO\UserDAO
     */
    private $userDAO;

    public function setSemestreDAO(SemestreDAO $semestreDAO) {
        $this->semestreDAO = $semestreDAO;
    }

    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }


    /**
     * Retourne la liste de tous les commentaires liés à des semestres rangés par date.
     *
     * @return array La liste de tous les commentaires.
     */
    public function findAll() {
        $sql = "select * from commentaire_semestre order by id_comment_semestre desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convertit le résultat de la requête en tableau contenant des objets "CommentSemestre"
        $entities = array();
        foreach ($result as $row) {
            $id = $row['id_comment_semestre'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }


    /**
     *Retourne la liste de tous les commentaires liés à un semestre donné rangés par date.
     *
     * @param integer $semestreId L'id du semestre.
     *
     * @return array La liste des commentaires pour le semestre donné.
     */
    public function findAllBySemestre($semestreId) {
        // Le semestre associé est récupéré
        $semestre = $this->semestreDAO->find($semestreId);

        $sql = "select id_comment_semestre, description_comment_semestre,date_comment_semestre, id_utilisateur from commentaire_semestre where id_semestre=? order by id_comment_semestre";
        $result = $this->getDb()->fetchAll($sql, array($semestreId));

        // Convertit les résultats de la requête en tableau d'objets
        $commentaires = array();
        foreach ($result as $row) {
            $comId = $row['id_comment_semestre'];
            $comment = $this->buildDomainObject($row);
            // Le semestre associé est défini pour le commentaire construit
            $comment->setSemestre($semestre);
            $commentaires[$comId] = $comment;
        }
        return $commentaires;
    }


    /**
     * Retourne le commentaire qui correspond à l'id en paramètre
     *
     * @param integer $id L'id du commentaire
     *
     * @return \ProjetInformatiqueIndividuel\Domain\CommentSemestre| soulève une exception si aucun commentaire ne correspond à l'id
     */
    public function find($id) {
        $sql = "select * from commentaire_semestre where id_comment_semestre=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucun commentaire ne correspond à l'id :  " . $id);
    }


    /**
     * Retourne une liste de commentaires écrits par un utilisateur
     *
     * @param integer $id L'id de l'utilisateur
     *
     * @return array La liste des commentaires pour l'utilisateur donné.
     */
    public function findByUser($userId) {
        $sql = "select * from commentaire_semestre where id_utilisateur=? ";
        $result = $this->getDb()->fetchAll($sql, array($userId));
        $commentaires=array();
        foreach ($result as $row) {
            $commentaireId = $row['id_comment_semestre'];
            $commentaire = $this->buildDomainObject($row);
            $commentaires[$commentaireId] = $commentaire;
        }
        return $commentaires;
    }

    /**
     * Supprime un commentaire de la base de données
     *
     * @param @param integer $id L'id du commentaire
     */
    public function delete($id) {

        $this->getDb()->delete('commentaire_semestre', array('id_comment_semestre' => $id));
    }


    /**
     * Sauvegarde un commentaire dans la base de données
     *
     * @param \ProjetInformatiqueIndividuel\Domain\CommentSemestre $comment Le commentaire à sauvegarder
     */
    public function save(CommentSemestre $comment) {
        $datetime = date("H:i d-m-Y");
        $commentData = array(
            'id_semestre' => $comment->getSemestre()->getId(),
            'id_utilisateur' => $comment->getAuteur()->getId(),
            'description_comment_semestre' => $comment->getContent(),
            'date_comment_semestre' =>$datetime
        );

        if ($comment->getId()) {
            // Le commentaire a déjà été sauvegardé : mise à jour
            $this->getDb()->update('commentaire_semestre', $commentData, array('id_comment_semestre' => $comment->getId()));
        } else {
            // Le commentaire n'a jamais été sauvegardé : insertion
            $this->getDb()->insert('commentaire_semestre', $commentData);
            // Récupère l'id du nouveau commentaire crée et le définit pour le nouvel objet "CommentSemestre"
            $id = $this->getDb()->lastInsertId();
            $comment->setId($id);
        }
    }


    /**
     * Supprime tous les commentaires associés à un semestre
     *
     * @param $semestreId L'id du semestre
     */
    public function deleteAllBySemestre($semestreId) {
        $this->getDb()->delete('commentaire_semestre', array('id_semestre' => $semestreId));
    }

    /**
     * Supprime tous les commentaires associés à un utilisateur
     *
     * @param $userId L'id de l'utilisateur
     */
    public function deleteAllByUser($userId) {
        $this->getDb()->delete('commentaire_semestre', array('id_utilisateur' => $userId));
    }

    /**
     * Crée un objet CommentSemestre basé sur une DB row.
     *
     * @param array $row The DB row contenant les données de CommentSemestre.
     * @return \ProjetInformatiqueIndividuel\Domain\CommentSemestre
     */
    protected function buildDomainObject(array $row) {
        $comment = new CommentSemestre();
        $comment->setId($row['id_comment_semestre']);
        $comment->setContent($row['description_comment_semestre']);
        $comment->setDate($row['date_comment_semestre']);

        if (array_key_exists('id_semestre', $row)) {
            // Find and set the associated article
            $semestreId = $row['id_semestre'];
            $semestre = $this->semestreDAO->find($semestreId);
            $comment->setSemestre($semestre);
        }
        if (array_key_exists('id_utilisateur', $row)) {
            // Find and set the associated author
            $userId = $row['id_utilisateur'];
            $user = $this->userDAO->find($userId);
            $comment->setAuteur($user);
        }
        return $comment;
    }
}