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
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\ParameterBag;

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
     * @var Paginator
     */
    private $paginator;

    /**
     * GuideBook constructor.
     * @param EntityManager $entityManager
     * @param UploadFile    $uploadFile
     */
    public function __construct(EntityManager $entityManager, UploadFile $uploadFile, Paginator $paginator)
    {
        parent::__construct($entityManager);
        $this->uploadFile = $uploadFile;
        $this->paginator = $paginator;
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
        $yearBook = $this->associatePaiementMethods($yearBook);
        $this->setCreationDateAndUser($yearBook, $user);

        $yearBook->setPicture($fileName);
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
     * Get by id
     *
     * @param int $id
     * @return YearBookEntity|null
     */
    public function get(int $id)
    {
        return $this->getEntityManager()->getRepository('AppBundle:Yearbook')
            ->find($id);
    }

    /**
     * Incremente the number of click on a year book link
     *
     * @param YearBookEntity $yearbook
     * @return YearBookEntity
     */
    public function incrementedClick(YearBookEntity $yearbook)
    {
        $newClick = $yearbook->getClick() + 1;
        $yearbook->setClick(
            $newClick
        );

        $this->getEntityManager()->flush($yearbook);

        return $yearbook;
    }

    /**
     * Get the list of year book pushed
     *
     * @return YearBookEntity[]
     */
    public function getPushed()
    {
        return $this->getEntityManager()->getRepository('AppBundle:Yearbook')
            ->findBy(
                [
                    'push' => true,
                ]
            );
    }

    /**
     * @param ParameterBag $getParameter
     * @return mixed
     */
    public function getPagination(ParameterBag $getParameter)
    {
        $query = $this->getEntityManager()->getRepository('AppBundle:Yearbook')
            ->getPaginationQuery();

        return $this->paginator->paginate(
            $query,
            $getParameter->get('page', 1),
            10
        );
    }

    /**
     * Associate paiement method to a year book
     *
     * @param YearBookEntity $yearbook
     * @return YearBookEntity
     * @throws CustomException
     */
    private function associatePaiementMethods(YearBookEntity $yearbook)
    {
        if (empty($yearbook->getPaiementsMethod())) {
            throw new CustomException('Il faut renseigner au moins un moeyn de paiement');
        }

        $collection = new ArrayCollection();

        foreach ($yearbook->getPaiementsMethod() as $paiementMethod) {
            $paiementMethodYearBook = new PaiementMethodForYearBook();
            $paiementMethodYearBook->setPaiementMethod($paiementMethod);
            $paiementMethodYearBook->setYearbook($yearbook);
            $this->getEntityManager()->persist($paiementMethodYearBook);
            $collection->add($paiementMethodYearBook);
        }

        $yearbook->setPaiementsMethod($collection);

        return $yearbook;
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
