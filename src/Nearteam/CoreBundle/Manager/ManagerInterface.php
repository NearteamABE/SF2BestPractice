<?php

namespace Nearteam\CoreBundle\Manager;

/**
 * Interface used for describe a manager class
 *
 * @author gcavana
 */
interface ManagerInterface {

    /**
     * Finds an object by id
     *
     * @param array $criteria
     * @return object $object
     */
    function load($id);

    /**
     * Finds an object by criteria
     *
     * @param array $criteria
     * @return object $object
     */
    function loadOneBy(array $criteria);

    /**
     * Finds objects by criteria
     *
     * @param array $criteria
     * @return array objects
     */
    function loadBy(array $criteria);

    /**
     * Finds all objects
     *
     * @return array $objects
     */
    function loadAll();

    /**
     * Saves an object
     * @param object $object 
     */
    function save($object);

    /**
     * Deletes an object
     * @param object $object 
     */
    function delete($object);

    function getClass();
}