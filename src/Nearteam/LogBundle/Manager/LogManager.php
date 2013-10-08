<?php

namespace Nearteam\LogBundle\Manager;

use Doctrine\ORM\EntityManager;
use Nearteam\CoreBundle\Manager\Doctrine\AbstractManager;
use Nearteam\LogBundle\Entity\Log;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class LogManager extends AbstractManager
{

    /**
     *
     * @param EntityManager $em
     * @param type $entityClassName
     */
    protected $userRepository;

    public function __construct(EntityManager $em, $entityClassName, $userRepository)
    {
        parent::__construct($em, $entityClassName);
        $this->userRepository = $em->getRepository($userRepository);
    }

    /**
     * save logs for action update User
     * @param User $user
	 * @param string $idUser
     */
    public function updateUserLog($user, $idUser)
    {
		$updateUserLog = new Log();
        $updateUserLog->setAction(Log::ACTION_UPDATE_User);
        $encodedObject = $user->serialise();
		$updateUserLog->setTargetType(get_class($user));
		$updateUserLog->setTargetId($user->getIdUser());
        $updateUserLog->setTarget($encodedObject);
        $updateUserLog->setIdUser($user);
        $updateDate = date('Y-m-d');
        $updateHour = date('H:m');
        $updateMessage =  $updateDate . "," . $updateHour . " ,Update user" . "," . $user->getIdUser();
        $updateUserLog->setMessage($updateMessage);
        $this->save($updateUserLog);
    }

   
    /**
     * save logs for action Delete User
     * @param User $user
	 * @param string $idUser
     */
    public function deleteUserLog($user, $idLFUser)
    {

		$deleteUserLog = new Log();
        $deleteUserLog->setAction(Log::ACTION_DELETE_User);
        $encodedObject = $user->serialise();

		$deleteUserLog->setTargetType(get_class($user));
		$deleteUserLog->setTargetId($user->getIdUser());

        $deleteUserLog->setTarget($encodedObject);
        $deleteUserLog->setIdUser($user);
        $deleteDate = date('Y-m-d');
        $deleteHour = date('H:m');
        $deleteMessage =  $deleteDate . "," . $deleteHour . ",Delete user" . "," . $user->getIdUser();
        $deleteUserLog->setMessage($deleteMessage);
        $this->save($deleteUserLog);
    }

    /**
     * save logs for action change Password
     * @param User $user
	 * @param string $idLFUser
     */
    public function changeUserPasswordLog($user, $idUser)
    {
        $changePasswordLog = new Log();
        $changePasswordLog->setAction(Log::ACTION_CHANGEMENT_PASSWORD);
		$changePasswordLog->setTargetId($user->getIdUser());
		$encodedObject = $user->serialise();
		$changePasswordLog->setTargetType(get_class($user));
		$changePasswordLog->setTarget($encodedObject);
        $changePasswordLog->setIdUser($user);
        $changePasswordDate = date('Y-m-d');
        $changePasswordHour = date('H:m');
        $changePasswordMessage =  $changePasswordDate . ", " . $changePasswordHour . ", Change password" . ", " . $user->getIdUser();
        $changePasswordLog->setMessage($changePasswordMessage);
        $this->save($changePasswordLog);
    }

   
    /**
     * Blacklist a User logs
     * @param $user
	 * @param string $idUser
     */
    public function blacklistUserLog($user, $idUser)
    {

        $blacklistUserLog = new Log();
        $blacklistUserLog->setAction(Log::ACTION_BLACK_LIST_User);
        $encodedObject = $user->serialise();

		$blacklistUserLog->setTargetType(get_class($user));
		$blacklistUserLog->setTargetId($user->getIdUser());

        $blacklistUserLog->setTarget($encodedObject);
        $blacklistUserLog->setIdUser($user);
        $blacklistDate = date('Y-m-d');
        $blacklistHour = date('H:m');
        $blacklistMessage =  $blacklistDate . "," . $blacklistHour . ",Blacklist user" . "," . $user->getIdUser();
        $blacklistUserLog->setMessage($blacklistMessage);
        $this->save($blacklistUserLog);
    }

   
}

