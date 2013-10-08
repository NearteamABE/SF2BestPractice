<?php

namespace Nearteam\CoreBundle\Manager\Doctrine;

use Doctrine\ORM\EntityManager;
use Nearteam\CoreBundle\Manager\ManagerInterface;

/**
 * Astract class that  for describe a manager class
 *
 * @author gcavana
 */
abstract class AbstractManager implements ManagerInterface
{

    protected $em;
    protected $class;

    /**
     *
     * @param EntityManager $em
     * @param type $entityClassName 
     */
    public function __construct(EntityManager $em, $entityClassName)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($entityClassName);

        $metadata = $em->getClassMetadata($entityClassName);
        $this->class = $metadata->name;
    }

    /**
     *
     * @return object 
     */
    public function createObject()
    {
        $class = $this->getClass();

        return new $class();
    }

    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritDoc}
     */
    public function load($id)
    {
		return $this->repository->find($id);
		
    }

    /**
     * {@inheritDoc}
     */
    public function loadOneBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function loadBy(array $criteria)
    {

        return $this->repository->findBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function loadAll()
    {
		return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
		
    }
	
	/**
     * {@inheritDoc}
     */
	
	public function delete($entity)
	{
	    $this->em->remove($entity);
        $this->em->flush();
	
	}

}