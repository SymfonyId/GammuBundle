<?php
namespace Symfonian\Indonesia\GammuBundle\Manager;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Doctrine\ORM\Query\ResultSetMapping;

class InboxManager extends AbstractManager implements ManagerInterface
{
    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        $resultSetMapping = new ResultSetMapping();
        $resultSetMapping->addScalarResult('ID', 'id');
        $resultSetMapping->addScalarResult('SenderNumber', 'sender');
        $resultSetMapping->addScalarResult('TextDecoded', 'message');
        $resultSetMapping->addScalarResult('Processed', 'processed');
        $resultSetMapping->addScalarResult('RecipientID', 'phone');

        $this->setResultMapping($resultSetMapping);
    }

    public function getTable()
    {
        return 'inbox';
    }

    protected function getGlobalSQL()
    {
        return 'SELECT ID, SenderNumber, TextDecoded, Processed, RecipientID FROM '.$this->getTable();
    }

    public function findByPhoneNumber($phoneNumber)
    {
        return $this->findBy(array('SenderNumber' =>  $phoneNumber));
    }
}
