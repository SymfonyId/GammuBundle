<?php
namespace Symfonian\Indonesia\GammuBundle\Manager;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Doctrine\ORM\Query\ResultSetMapping;

class OutboxManager extends AbstractManager implements ManagerInterface
{
    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        $resultSetMapping = new ResultSetMapping();
        $resultSetMapping->addScalarResult('DestinationNumber', 'receiver');
        $resultSetMapping->addScalarResult('TextDecoded', 'message');
        $resultSetMapping->addScalarResult('SenderID', 'modem');

        $this->setResultMapping($resultSetMapping);
    }

    public function getTable()
    {
        return 'outbox';
    }

    public function getGlobalSQL()
    {
        return 'SELECT DestinationNumber, TextDecoded, SenderID FROM '.$this->getTable();
    }

    public function findByPhoneNumber($phoneNumber)
    {
        return $this->findBy(array('DestinationNumber' =>  $phoneNumber));
    }
}
