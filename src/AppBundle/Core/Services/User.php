<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Entity\Users;
use AppBundle\Core\Manager\Manager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

/**
 * Class User
 * @package AppBundle\Core\Services
 */
class User extends Manager
{
    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * User constructor.
     * @param EntityManager       $entityManager
     * @param UserPasswordEncoder $passwordEncoder
     */
    public function __construct(EntityManager $entityManager, UserPasswordEncoder $passwordEncoder)
    {
        parent::__construct($entityManager);
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Disabled or enabled an user
     * @param Users $user
     */
    public function disabledEnabled(Users $user)
    {
        if ($user->isEnabled()) {
            $user->setEnabled(false);
        } else {
            $user->setEnabled(true);
        }

        $this->getEntityManager()->flush($user);
    }

    /**
     * @param Users $user
     */
    public function depersonalized(Users $user)
    {
        $user->setFirstName(null);
        $user->setLastName(null);
        $user->setEmail(null);
        $user->setPassword(null);
        $user->setAddress1(null);
        $user->setAddress2(null);
        $user->setCity(null);
        $user->setCivility(null);
        $user->setZipCode(null);
        $user->setPhoneNumber(null);

        $this->getEntityManager()->flush($user);
    }

    /**
     * Check if a user exist by his username and if he's register to the newsletter
     *
     * @param string $mail
     * @return bool
     */
    public function existUserNewsletter(string $mail)
    {
        return !empty(
            $this->getEntityManager()->getRepository('AppBundle:Users')
                ->findBy(
                    [
                        'username' => $mail,
                        'enabled' => false,
                        'enableNewsletter' => true,
                    ]
                )
        );
    }

    /**
     * Check if a user exist by his username
     *
     * @param string $mail
     * @return bool
     */
    public function existUser(string $mail)
    {
        return !empty(
        $this->getEntityManager()->getRepository('AppBundle:Users')
            ->findBy(
                [
                    'username' => $mail,
                ]
            )
        );
    }

    /**
     * Get a user register in the newsletter
     *
     * @param string $mail
     * @return Users|null
     */
    public function getUserNewsletter(string $mail)
    {
        return $this->getEntityManager()->getRepository('AppBundle:Users')
            ->findOneBy(
                [
                    'username' => $mail,
                    'enabled' => false,
                    'enableNewsletter' => true,
                ]
            );
    }

    public function switchUserData(Users $userRegister, Users $userFromForm)
    {
        $encoder = $this->passwordEncoder;
        $encoded = $encoder->encodePassword($userFromForm, $userFromForm->getPassword());
        $userRegister->setPassword($encoded);
        $userRegister->setEnableNewsletter($userFromForm->isEnableNewsletter());
        $userRegister->setCivility($userFromForm->getCivility());
        $userRegister->setFirstName($userFromForm->getFirstName());
        $userRegister->setLastName($userFromForm->getLastName());
        $userRegister->setAddress1($userFromForm->getAddress1());
        $userRegister->setAddress2($userFromForm->getAddress2());
        $userRegister->setBirthDate($userFromForm->getBirthDate());
        $userRegister->setCity($userFromForm->getCity());
        $userRegister->setZipCode($userFromForm->getZipCode());
        $userRegister->setPhoneNumber($userFromForm->getPhoneNumber());
        $userRegister->setEnabled(true);

        return $userRegister;
    }

    /**
     * Get a user
     *
     * @param int $id
     * @return Users|null
     */
    public function get(int $id)
    {
        return $this->getEntityManager()->getRepository('AppBundle:Users')
            ->find($id);
    }
}
