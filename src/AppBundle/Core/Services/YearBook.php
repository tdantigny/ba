<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Entity\GuideTags;
use AppBundle\Core\Entity\PaiementMethodForYearBook;
use AppBundle\Core\Entity\Users;
use AppBundle\Core\Exception\CustomException;
use AppBundle\Core\Manager\Manager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use AppBundle\Core\Entity\Yearbook as YearBookEntity;

/**
 * Class YearBook
 * @package AppBundle\Core\Services
 */
class YearBook extends Manager
{
    /**
     * @var UploadFile
     */
    private $uploadFile;

    /**
     * GuideBook constructor.
     * @param EntityManager $entityManager
     * @param UploadFile    $uploadFile
     */
    public function __construct(EntityManager $entityManager, UploadFile $uploadFile)
    {
        parent::__construct($entityManager);
        $this->uploadFile = $uploadFile;
    }

    /**
     * Create a year book and save the picture
     * Step 1 : Upload the file
     * Step 2 : Associate each paiement method to the year book
     * Step 3 : Set the current user, creator of the year book
     * Step 4 : Set the current date as creation date of the year book
     *
     * @param YearBookEntity $yearBook
     * @param Users          $user
     */
    public function createdYearBook(YearBookEntity $yearBook, Users $user)
    {
        $fileName = $this->uploadFile->updateFile($yearBook->getPicture(), 'year_book');
        $this->associatePaiementMethods($yearBook);
        $this->setCreationDateAndUser($yearBook, $user);

        $yearBook->setPicture($fileName);
        $yearBook->setHtml(html_entity_decode($yearBook->getHtml()));
        $this->getEntityManager()->persist($yearBook);
        $this->getEntityManager()->flush($yearBook);

        return;
    }

    /**
     * Get the paiement methods associate to a year book
     *
     * @param YearBookEntity $yearbook
     * @return YearBookEntity
     */
    public function getPaiementMethods(YearBookEntity $yearbook)
    {
        $paiementMethodForYearBook = $this->getEntityManager()
            ->getRepository('AppBundle:PaiementMethodForYearBook')
            ->findBy(['yearbook' => $yearbook]);

        $collectionOfPaiement = new ArrayCollection();

        foreach ($paiementMethodForYearBook as $paiementMethod) {
            $collectionOfPaiement->add($paiementMethod->getPaiementMethod());
        }

        $yearbook->setPaiementsMethod($collectionOfPaiement);

        return $yearbook;
    }

    /**
     * Associate paiement method to a year book
     *
     * @param YearBookEntity $yearbook
     * @throws CustomException
     */
    private function associatePaiementMethods(YearBookEntity $yearbook)
    {
        if (empty($yearbook->getPaiementsMethod())) {
            throw new CustomException('Il faut renseigner au moins un moeyn de paiement');
        }

        foreach ($yearbook->getPaiementsMethod() as $paiementMethod) {
            $paiementMethodYearBook = new PaiementMethodForYearBook();
            $paiementMethodYearBook->setPaiementMethod($paiementMethod);
            $paiementMethodYearBook->setYearbook($yearbook);
            $this->getEntityManager()->persist($paiementMethodYearBook);
        }

        return;
    }

    /**
     * Associate the connected user and th current date to the new year book
     *
     * @param YearBookEntity $yearbook
     * @param Users          $users
     */
    private function setCreationDateAndUser(YearBookEntity $yearbook, Users $users)
    {
        $yearbook->setCreationUser($users);
        $yearbook->setUpdatedUser($users);
        $yearbook->setCreationDate(new \DateTime('now'));
        $yearbook->setUpdatedDate(new \DateTime('now'));

        return;
    }

//    /**
//     * Remove a guide book
//     *
//     * @param GuideBookEntity $guideBook
//     * @throws CustomException
//     */
//    public function delete(GuideBookEntity $guideBook)
//    {
//        try {
//            $this->getEntityManager()->remove($guideBook);
//            $this->getEntityManager()->flush();
//        } catch (CustomException $customException) {
//            throw new CustomException('Unable to remove this guide book');
//        }
//    }
}
