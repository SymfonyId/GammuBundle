<?php
namespace Symfonian\Indonesia\GammuBundle\Manager;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Doctrine\ORM\Query\ResultSetMapping;

class PhonesManager extends AbstractManager implements ManagerInterface
{
    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        $resultSetMapping = new ResultSetMapping();
        $resultSetMapping->addScalarResult('NetCode', 'network_code');
        $resultSetMapping->addScalarResult('NetName', 'network_name');
        $resultSetMapping->addScalarResult('Send', 'is_sender');
        $resultSetMapping->addScalarResult('Receive', 'is_receiver');
        $resultSetMapping->addScalarResult('Sent', 'message_sent');
        $resultSetMapping->addScalarResult('Received', 'message_received');

        $this->setResultMapping($resultSetMapping);
    }

    protected function getGlobalSQL()
    {
        return 'SELECT NetCode, NetName, Send, Receive, Sent, Received FROM '.$this->getTable();
    }

    protected function getTable()
    {
        return 'phones';
    }

    public function findByPhoneNumber($phoneNumber)
    {
        throw new \RuntimeException('This manager is not supported for findByPhoneNumber');
    }
}
