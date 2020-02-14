<?php


namespace FiThnitekBundle\Entity;
use Doctrine\ORM\Mapping as ORM ;
/**
 * @ORM\Entity
 */

class ReplyQuestionnaire
{
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
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**

     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="userId",
     *  referencedColumnName="id")
     */
private $userId;
    /**

     * @ORM\ManyToOne(targetEntity="Questionnaire")
     * @ORM\JoinColumn(name="questionnaireId",
     *  referencedColumnName="id")
     */
    private $questionnaireId;

    /**
     * @ORM\Column(type="string")
     */
private $reponse;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getQuestionnaireId()
    {
        return $this->questionnaireId;
    }

    /**
     * @param mixed $questionnaireId
     */
    public function setQuestionnaireId($questionnaireId)
    {
        $this->questionnaireId = $questionnaireId;
    }

    /**
     * @return mixed
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * @param mixed $reponse
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;
    }



}