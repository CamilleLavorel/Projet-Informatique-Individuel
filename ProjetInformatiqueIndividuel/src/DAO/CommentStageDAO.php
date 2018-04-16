<?php

namespace ProjetInformatiqueIndividuel\DAO;

use ProjetInformatiqueIndividuel\Domain\CommentStage;

class CommentStageDAO extends DAO
{
    /**
     * @var \ProjetInformatiqueIndividuel\DAO\StageDAO
     */
    private $stageDAO;

    /**
     * @var \ProjetInformatiqueIndividuel\DAO\UserDAO
     */
    private $userDAO;

    public function setStageDAO(StageDAO $stageDAO) {
        $this->stageDAO = $stageDAO;
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
        $sql = "select * from commentaire_stage order by id_comment_stage desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convertit le résultat de la requête en tableau contenant des objets "CommentStage"
        $entities = array();
        foreach ($result as $row) {
            $id = $row['id_comment_stage'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }


    /**
     *Retourne la liste de tous les commentaires liés à un stage donné rangés par date.
     *
     * @param integer $semestreId L'id du stage.
     *
     * @return array La liste des commentaires pour le stage donné.
     */
    public function findAllByStage($stageId) {
        // Le stage associé est défini
        $stage = $this->stageDAO->find($stageId);

        $sql = "select id_comment_stage, description_comment_stage,date_comment_stage, id_utilisateur from commentaire_stage where id_stage=? order by id_comment_stage";
        $result = $this->getDb()->fetchAll($sql, array($stageId));

        // Convertit les résultats de la requête en tableau d'objets.
        $commentaires = array();
        foreach ($result as $row) {
            $comId = $row['id_comment_stage'];
            $comment = $this->buildDomainObject($row);
            // Le semestre associé est défini pour le commentaire construit
            $comment->setStage($stage);
            $commentaires[$comId] = $comment;
        }
        return $commentaires;
    }

    /**
     * Retourne le commentaire qui correspond à l'id en paramètre
     *
     * @param integer $id L'id du commentaire
     *
     * @return \ProjetInformatiqueIndividuel\Domain\CommentStage| soulève une exception si aucun commentaire ne correspond à l'id
     */
    public function find($id) {
        $sql = "select * from commentaire_stage where id_comment_stage=?";
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
    public function findByUser($user) {
        $sql = "select * from commentaire_stage where id_utilisateur=? ";
        $result = $this->getDb()->fetchAll($sql, array($user));
        $commentaires=array();
        foreach ($result as $row) {
            $commentaireId = $row['id_comment_stage'];
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

        $this->getDb()->delete('commentaire_stage', array('id_comment_stage' => $id));
    }


    /**
     * Supprime tous les commentaires d'un utilisateur
     *
     * @param $userId L'id de l'utilisateur
     */
    public function deleteAllByUser($userId) {
        $this->getDb()->delete('commentaire_stage', array('id_utilisateur' => $userId));
    }

    /**
     * Sauvegarde un commentaire dans la base de données.
     *
     * @param \ProjetInformatiqueIndividuel\Domain\CommentStage $comment Le commentaire à sauvegarder
     */
    public function save(CommentStage $comment) {
        $datetime = date("Y-m-d H:i:s");
        $commentData = array(
            'id_stage' => $comment->getStage()->getId(),
            'id_utilisateur' => $comment->getAuteur()->getId(),
            'description_comment_stage' => $comment->getContent(),
            'date_comment_stage' =>$datetime
        );

        if ($comment->getId()) {
            // Le commentaire a déjà été sauvegardé : mise à jour
            $this->getDb()->update('commentaire_stage', $commentData, array('id_comment_stage' => $comment->getId()));
        } else {
            // Le commentaire n'a jamais été sauvegardé : insertion
            $this->getDb()->insert('commentaire_stage', $commentData);
            // Récupère l'id du nouveau commentaire crée et le définit pour le nouvel objet "CommentStage"
            $id = $this->getDb()->lastInsertId();
            $comment->setId($id);
        }
    }

    /**
     * Supprime tous les commentaires associés à un stage
     *
     * @param $semestreId L'id du stage
     */
    public function deleteAllByStage($stageId) {
        $this->getDb()->delete('commentaire_stage', array('id_stage' => $stageId));
    }


    /**
     * Crée un objet CommentStage basé sur les attributs de la base de données.
     *
     * @param array $row The DB row containing CommentStage data.
     * @return \ProjetInformatiqueIndividuel\Domain\CommentStage
     */
    protected function buildDomainObject(array $row) {
        $comment = new CommentStage();
        $comment->setId($row['id_comment_stage']);
        $comment->setContent($row['description_comment_stage']);
        $comment->setDate($row['date_comment_stage']);

        if (array_key_exists('id_stage', $row)) {
            // Find and set the associated article
            $stageId = $row['id_stage'];
            $stage = $this->stageDAO->find($stageId);
            $comment->setStage($stage);
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