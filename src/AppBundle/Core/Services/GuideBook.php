<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Exception\CustomException;
use AppBundle\Core\Manager\Manager;
use AppBundle\Core\Model\GuideBookParagraph;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use AppBundle\Core\Entity\GuideBook as GuideBookEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Core\Model\GuideBook as GuideBookModel;

/**
 * Class GuideBook
 * @package AppBundle\Core\Services
 */
class GuideBook extends Manager
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
     * Create a guide book and save the picture
     *
     * @param GuideBookEntity $guideBook
     */
    public function createdGuideBook(GuideBookEntity $guideBook)
    {
        $fileName = $this->uploadFile->updateFile($guideBook->getPicture(), 'guide_book');

        $guideBook->setPicture($fileName);
        $guideBook->setHtml(html_entity_decode($guideBook->getHtml()));
        $this->getEntityManager()->persist($guideBook);
        $this->getEntityManager()->flush($guideBook);
    }

    /**
     * Enable or disable a guide book
     *
     * @param GuideBookEntity $guideBook
     * @throws CustomException
     */
    public function disabledEnabled(GuideBookEntity $guideBook)
    {
        try {
            if ($guideBook->getActive()) {
                $guideBook->setActive(false);
            } else {
                $guideBook->setActive(true);
            }

            $this->getEntityManager()->flush($guideBook);
        } catch (CustomException $customException) {
            throw new CustomException('Unable to enabled/disabled this guide book');
        }
    }

    /**
     * Remove a guide book
     *
     * @param GuideBookEntity $guideBook
     * @throws CustomException
     */
    public function delete(GuideBookEntity $guideBook)
    {
        try {
            $this->getEntityManager()->remove($guideBook);
            $this->getEntityManager()->flush();
        } catch (CustomException $customException) {
            throw new CustomException('Unable to remove this guide book');
        }
    }

    /**
     * Return a random guid book according to the day
     *
     * @return GuideBookEntity|null
     */
    public function getRandomOne()
    {
        $allActiveGuideBook = $this->getEntityManager()->getRepository('AppBundle:GuideBook')
            ->findBy(
                [
                    'active' => true,
                ]
            );

        if (empty($allActiveGuideBook)) {
            return null;
        }

        $todayDate = new \DateTime();
        $todayDay = (int) $todayDate->format('d');
        $guideKey = $todayDay % count($allActiveGuideBook);

        return $allActiveGuideBook[$guideKey];
    }

    /**
     * Return all guid book
     *
     * @return GuideBookModel[]
     */
    public function getAll()
    {
        $guidBooks = [];
        for ($index = 0; $index < 4; $index++) {
            $guidBooks[] = $this->get($index+1);
        }

        return $guidBooks;
    }

    /**
     * Return a guid book by id
     *
     * @param int $id
     * @return GuideBookModel
     */
    public function get(int $id)
    {
        $paragraphs = new ArrayCollection();

        $guideBookParagraphs1 = new GuideBookParagraph();
        $guideBookParagraphs1->setTitle('Test Paragraphe 1');
        $guideBookParagraphs1->setPicture('Fortitude.png');
        $guideBookParagraphs1->setContent('*Lorem ipsum dolor sit amet*, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.

h2. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,');
        $guideBookParagraphs1->setPicturePosition('right');
        $paragraphs->add($guideBookParagraphs1);

        $guideBookParagraphs2 = new GuideBookParagraph();
        $guideBookParagraphs2->setTitle('Test Paragraphe 2');
        $guideBookParagraphs2->setPicture('original.jpg');
        $guideBookParagraphs2->setContent('+Lorem ipsum dolor+ sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.

Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,');

        $guideBookParagraphs2->setPicturePosition('left');
        $paragraphs->add($guideBookParagraphs2);

        $guideBookParagraphs3 = new GuideBookParagraph();
        $guideBookParagraphs3->setTitle('Test Paragraphe 3');
        $guideBookParagraphs3->setPicture('img-thing.jpeg');
        $guideBookParagraphs3->setContent('_Lorem ipsum dolor sit amet_, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.

h3. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,');

        $guideBookParagraphs3->setPicturePosition('right');
        $paragraphs->add($guideBookParagraphs3);

        $guideBook = new GuideBookModel();
        $guideBook->setId($id);
        $guideBook->setEnable(true);
        $guideBook->setTitle('Test');
        $guideBook->setPicture('1344585.jpg');
        $guideBook->setParagraphs($paragraphs);

        return $guideBook;
    }
}
