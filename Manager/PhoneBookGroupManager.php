<?php
namespace Symfonian\Indonesia\GammuBundle\Manager;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Doctrine\ORM\Query\ResultSetMapping;

class PhoneBookGroupManager extends AbstractManager implements ManagerInterface
{
    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        $resultSetMapping = new ResultSetMapping();
        $resultSetMapping->addScalarResult('ID', 'id');
        $resultSetMapping->addScalarResult('Name', 'name');

        $this->setResultMapping($resultSetMapping);
    }

    protected function getGlobalSQL()
    {
        return 'SELECT ID, Name FROM '.$this->getTable();
    }

    protected function getTable()
    {
        return 'pbk_groups';
    }

    public function findByPhoneNumber($phoneNumber)
    {
        throw new \RuntimeException('This manager is not supported for findByPhoneNumber');
    }
}
