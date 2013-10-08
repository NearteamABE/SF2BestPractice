<?php

namespace Nearteam\LogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nearteam\LogBundle\Entity\Log
 *
 * @ORM\Entity(repositoryClass="Nearteam\LogBundle\Repository\LogRepository")
 * @ORM\Table(name="log")
 * @ORM\HasLifecycleCallbacks()
 */
class Log
{

	const ACTION_UPDATE_User = 'updateUser';
	const ACTION_DELETE_User = 'deleteUser';
	const ACTION_CHANGEMENT_PASSWORD = 'changePassword';
	const ACTION_BLACK_LIST_User = 'blacklistUser';
	
    /**
     * @ORM\Id
     * @ORM\Column(name="id_Log", columnDefinition="INT UNSIGNED NOT NULL AUTO_INCREMENT")
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idLog;

    /**
     *
     * @var datetime createDt 
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP NULL",name="create_dt")
     */
    protected $createDt;

    /**
     * @var User $idUser
     * @ORM\ManyToOne(targetEntity="Nearteam\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id_user",nullable=true)
     */
    private $idUser;

    /**
     * @var string $action
     * @ORM\Column(type="string",name="action",nullable=false)
     */
    private $action;

    /**
     * @var string $target
     * @ORM\Column(type="text", name="target", nullable=true)
     */
    private $target;

    /**
     * @var string $targetType
     * @ORM\Column(type="string",name="target_type",nullable=true)
     */
    private $targetType;

    /**
     * @var integer $targetId
     * @ORM\Column(name="target_id",columnDefinition="INT UNSIGNED NULL")
     */
    private $targetId;

    /**
     * @var string $actionObject
     * @ORM\Column(type="text",name="action_object",nullable=true)
     */
    private $actionObject;

    /**
     * @var string $actionObjectType
     * @ORM\Column(type="string",name="action_object_type",nullable=true)
     */
    private $actionObjectType;

    /**
     * @var integer $actionObjectId
     * @ORM\Column(name="action_object_id",columnDefinition="INT UNSIGNED NULL")
     */
    private $actionObjectId;

    /**
     * @var string $message
     * @ORM\Column(type="string",name="message",nullable=true)
     */
    private $message;

    


    /**
     * Get idLog
     *
     * @return string 
     */
    public function getIdLog()
    {
        return $this->idLog;
    }

    /**
     * Set createDt
     *
     * @param datetime $createDt
     */
    public function setCreateDt($createDt)
    {
        $this->createDt = $createDt;
    }

    /**
     * Get createDt
     *
     * @return datetime 
     */
    public function getCreateDt()
    {
        return $this->createDt;
    }

    /**
     * Set action
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Get action
     *
     * @return string 
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set target
     *
     * @param text $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * Get target
     *
     * @return text 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set targetType
     *
     * @param string $targetType
     */
    public function setTargetType($targetType)
    {
        $this->targetType = $targetType;
    }

    /**
     * Get targetType
     *
     * @return string 
     */
    public function getTargetType()
    {
        return $this->targetType;
    }

    /**
     * Set targetId
     *
     * @param string $targetId
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;
    }

    /**
     * Get targetId
     *
     * @return string 
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * Set actionObject
     *
     * @param text $actionObject
     */
    public function setActionObject($actionObject)
    {
        $this->actionObject = $actionObject;
    }

    /**
     * Get actionObject
     *
     * @return text 
     */
    public function getActionObject()
    {
        return $this->actionObject;
    }

    /**
     * Set actionObjectType
     *
     * @param string $actionObjectType
     */
    public function setActionObjectType($actionObjectType)
    {
        $this->actionObjectType = $actionObjectType;
    }

    /**
     * Get actionObjectType
     *
     * @return string 
     */
    public function getActionObjectType()
    {
        return $this->actionObjectType;
    }

    /**
     * Set actionObjectId
     *
     * @param string $actionObjectId
     */
    public function setActionObjectId($actionObjectId)
    {
        $this->actionObjectId = $actionObjectId;
    }

    /**
     * Get actionObjectId
     *
     * @return string 
     */
    public function getActionObjectId()
    {
        return $this->actionObjectId;
    }

    /**
     * Set message
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set idUser
     *
     * @param Nearteam\UserBundle\Entity\User $idUser
     */
    public function setIdUser(\Nearteam\UserBundle\Entity\User $idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * Get idUser
     *
     * @return Nearteam\UserBundle\Entity\User 
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
	
}