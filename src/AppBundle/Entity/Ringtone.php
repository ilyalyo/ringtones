<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use AppBundle\Entity\User;


/**
 * @ORM\Entity
 * @Vich\Uploadable
 * @ORM\Table(name="ringtone")
 */
class Ringtone
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Symfony\Component\HttpFoundation\File\File
     * @Assert\File(
     *     maxSize = "10M",
     *     maxSizeMessage = "Max size is 10M",
     * )
     * @Vich\UploadableField(mapping="post_cover", fileNameProperty="coverName")
     */
    protected $cover;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255,  name="cover_name", nullable=true)
     */
    protected $coverName;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    protected $user;

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
     * Set title
     *
     * @param string $title
     *
     * @return Ringtone
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Ringtone
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function getCover()
    {
        return $this->cover;
    }

    /*
    * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
    *
    */
    public function setCover(File $cover = null)
    {
        if (null != $cover) {
            $this->cover = $cover;
            //Trick : if we change only the cover, the entity does not fire the persist.
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * Set coverName
     *
     * @param string $coverName
     *
     * @return Ringtone
     */
    public function setCoverName($coverName)
    {
        $this->coverName = $coverName;

        return $this;
    }

    /**
     * Get coverName
     *
     * @return string
     */
    public function getCoverName()
    {
        return $this->coverName;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Ringtone
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Ringtone
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
