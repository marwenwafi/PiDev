<?php

namespace FiThnitekBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;

/**
 * Questionnaire
 *
 * @ORM\Table(name="questionnaire")
 * @ORM\Entity(repositoryClass="FiThnitekBundle\Repository\QuestionnaireRepository")
 */
class Questionnaire
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
     * @ORM\Column(name="question", type="string", length=255)
     */
    private $question;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="reponse1", type="string", length=255)
     */
    private $reponse1;
    /**
     * @var string
     *
     *
     * @ORM\Column(name="reponse2", type="string", length=255)
     */
    private $reponse2;





    /***************************************************/
    /********************************************************/


    /**
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="idevent", referencedColumnName="id")
     */
    private $event;




/***************************************************/
    /*******************************************************/





    /**
     * Set question
     *
     * @param string $question
     *
     * @return Questionnaire
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @return string
     */
    public function getReponse1()
    {
        return $this->reponse1;
    }

    /**
     * @param string $reponse1
     */
    public function setReponse1($reponse1)
    {
        $this->reponse1 = $reponse1;
    }

    /**
     * @return string
     */
    public function getReponse2()
    {
        return $this->reponse2;
    }

    /**
     * @param string $reponse2
     */
    public function setReponse2($reponse2)
    {
        $this->reponse2 = $reponse2;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }


}

