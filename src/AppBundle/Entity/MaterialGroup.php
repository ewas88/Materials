<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MaterialGroup
 *
 * @ORM\Table(name="material_group")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MaterialGroupRepository")
 */
class MaterialGroup
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="right_side", type="integer")
     */
    private $rightSide;

    /**
     * @var int
     *
     * @ORM\Column(name="left_side", type="integer")
     */
    private $leftSide;

    /**
     * @ORM\OneToMany(targetEntity="Material", mappedBy="group")
     */
    private $materials;
    public function __construct() {
        $this->materials = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return MaterialGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set rightSide
     *
     * @param integer $rightSide
     * @return MaterialGroup
     */
    public function setRightSide($rightSide)
    {
        $this->rightSide = $rightSide;

        return $this;
    }

    /**
     * Get rightSide
     *
     * @return integer 
     */
    public function getRightSide()
    {
        return $this->rightSide;
    }

    /**
     * Set leftSide
     *
     * @param integer $leftSide
     * @return MaterialGroup
     */
    public function setLeftSide($leftSide)
    {
        $this->leftSide = $leftSide;

        return $this;
    }

    /**
     * Get leftSide
     *
     * @return integer 
     */
    public function getLeftSide()
    {
        return $this->leftSide;
    }
}
