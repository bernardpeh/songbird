<?php

namespace AppBundle\Entity;

use Bpeh\NestablePageBundle\Model\PageMetaBase;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * PageMeta
 *
 * @ORM\Table(name="pagemeta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageMetaRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 *
 */
class PageMeta extends PageMetaBase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $featuredImage;

    /**
     * @Vich\UploadableField(mapping="featured_image", fileNameProperty="featuredImage")
     * @var File
     */
    private $featuredImageFile;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param File|null $image
     */
    public function setFeaturedImageFile(File $image = null)
    {
        $this->featuredImageFile = $image;

        if ($image) {
            $this->setModified(new \DateTime());
        }
    }

    /**
     * @return File
     */
    public function getFeaturedImageFile()
    {
        return $this->featuredImageFile;
    }

    /**
     * @param $image
     */
    public function setFeaturedImage($image)
    {
        $this->featuredImage = $image;
    }

    /**
     * @return string
     */
    public function getFeaturedImage()
    {
        return $this->featuredImage;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getLocale().': '.$this->getMenuTitle();
    }
}