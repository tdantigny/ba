<?php
/**
 * Created by PhpStorm.
 * User: tegbessou
 * Date: 10/12/2016
 * Time: 22:17
 */

namespace AppBundle\Core\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class UploadFile
 * @package AppBundle\Core\Services
 */
class UploadFile
{
    /**
     * @var array
     */
    private $directoryPictures;

    /**
     * UploadFile constructor.
     * @param array $directoryPictures
     */
    public function __construct(array $directoryPictures)
    {
        $this->directoryPictures = $directoryPictures;
    }

    /**
     * Update the picture for the guide book
     *
     * @param UploadedFile $file
     * @param string       $type
     * @return string
     */
    public function updateFile(UploadedFile $file, string $type)
    {
        // Generate a unique name for the file before saving it
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        // Move the file to the directory where brochures are stored
        $file->move(
            $this->directoryPictures[$type],
            $fileName
        );

        return $fileName;
    }
}