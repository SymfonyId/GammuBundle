<?php
namespace Symfonian\Indonesia\GammuBundle\Manager;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractManager implements ManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ResultSetMapping
     */
    protected $resultSetMapping;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setResultMapping(ResultSetMapping $resultSetMapping)
    {
        $this->resultSetMapping = $resultSetMapping;
    }

    public function execute($sql, array $parameters = array(), ResultSetMapping $resultMapping = null)
    {
        $query = $this->entityManager->createNativeQuery($sql, ! $resultMapping? : $this->resultSetMapping);
        $result = $query->execute($parameters);

        return $result;
    }
}
