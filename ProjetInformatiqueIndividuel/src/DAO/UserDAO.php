<?php

namespace ProjetInformatiqueIndividuel\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use ProjetInformatiqueIndividuel\Domain\User;

class UserDAO extends DAO implements UserProviderInterface
{
    /**
     * Returns a user matching the supplied id.
     *
     * @param integer $id The user id.
     *
     * @return \ProjetInformatiqueIndividuel\Domain\User|throws an exception if no matching user is found
     */
    public function find($id) {
        $sql = "select * from utilisateur where id_utilisateur=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucun utilisateur ne correspond à l'id :" . $id);
    }


    /**
     * Return a list of all users.
     *
     * @return array A list of all users.
     */
    public function findAll() {
        $sql = "select * from utilisateur";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $utilisateurs = array();
        foreach ($result as $row) {
            $utilisateurId = $row['id_utilisateur'];
            $utilisateurs[$utilisateurId] = $this->buildDomainObject($row);
        }
        return $utilisateurs;
    }

    /**
     * Saves a user into the database.
     *
     * @param \ProjetInformatiqueIndividuel\Domain\User $user The user to save
     */
    public function save(User $user) {
        $userData = array(
            'nom'=> $user->getNom(),
            'prenom' => $user->getPrenom(),
            'promo' => $user->getPromo(),
            'photo' => $user->getPhoto(),
            'email' => $user->getEmail(),
            'description_utilisateur' => $user->getDescription(),
            'mot_de_passe' => $user->getPassword(),
            'login' => $user->getUsername(),
            'salt_utilisateur' => $user->getSalt(),
            'role_utilisateur' => $user->getRole()
        );

        if ($user->getId()) {
            // The user has already been saved : update it
            $this->getDb()->update('utilisateur', $userData, array('id_utilisateur' => $user->getId()));
        } else {
            // The user has never been saved : insert it
            $this->getDb()->insert('utilisateur', $userData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $user->setId($id);
        }
    }

    /**
     * Removes a user from the database.
     *
     * @param @param integer $id The user id
     */
    public function delete($id) {
        // Delete the comment
        $this->getDb()->delete('utilisateur', array('id_utilisateur' => $id));
    }


    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $sql = "select * from utilisateur where login=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'ProjetInformatiqueIndividuel\Domain\User' === $class;
    }

    /**
     * Creates a User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * @return \ProjetInformatiqueIndividuel\Domain\User
     */
    protected function buildDomainObject(array $row) {
        $user = new User();
        $user->setId($row['id_utilisateur']);
        $user->setUsername($row['login']);
        $user->setPrenom($row['prenom']);
        $user->setNom($row['nom']);
        $user->setEmail($row['email']);
        $user->setDescription($row['description_utilisateur']);
        $user->setPromo($row['promo']);
        $user->setPassword($row['mot_de_passe']);
        $user->setSalt($row['salt_utilisateur']);
        $user->setRole($row['role_utilisateur']);
        $user->setPhoto($row['photo']);
        return $user;
    }
}