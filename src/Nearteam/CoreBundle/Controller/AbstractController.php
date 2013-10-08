<?php
namespace Nearteam\CoreBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * AbstractController class
 *
 * @author cotal
 */

class AbstractController extends ContainerAware
{

    /**
    * mock the NearteamUser
    *
    */
    protected function getIdUser()
    {
        return 'user_nearteam';
    }


}