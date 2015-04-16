<?php
namespace Symfonian\Indonesia\GammuBundle\Manager;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Doctrine\ORM\Query\ResultSetMapping;

class InboxManager extends AbstractManager implements ManagerInterface
{
    const GLOBAL_SQL = 'SELECT SenderNumber, TextDecoded, Processed, RecipientID FROM inbox';

    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        $resultSetMapping = new ResultSetMapping();
        $resultSetMapping->addScalarResult('SenderNumber', 'sender');
        $resultSetMapping->addScalarResult('TextDecoded', 'message');
        $resultSetMapping->addScalarResult('Processed', 'processed');
        $resultSetMapping->addScalarResult('RecipientID', 'sender');

        $this->setResultMapping($resultSetMapping);
    }

    public function findByPhoneNumber($phoneNumber)
    {
        return $this->findBy(array('SenderNumber' =>  $phoneNumber));
    }

    public function findAll()
    {
        return $this->execute(self::GLOBAL_SQL);
    }

    public function findBy(array $criteria)
    {
        return $this->findLimit($criteria);
    }

    public function findLimit($criteria, $limit = -1, $start = 0)
    {
        $sql = self::GLOBAL_SQL.' WHERE ';

        foreach ($criteria as $value) {
            $sql .= sprintf('%s %s :%s %s ', $value['column'], $value['operator'], $value['alias'], $value['conjunction']);
            $this->parameters[$value['alias']] = $value['value'];
        }

        $sql = trim(rtrim(trim($sql), 'AND'));

        if ($limit > 0) {
            $sql .= sprintf(' LIMIT %d, %d', $limit, $start);
        }

        return $this->execute($sql, array_merge($criteria, array('start' => $start, 'limit' => $limit)));
    }

    public function countRecord()
    {
        $resultMapping = new ResultSetMapping();
        $resultMapping->addScalarResult('total', 'total');
        $result = $this->execute('SELECT SUM(ID) AS total FROM inbox', array(), $resultMapping);

        return $result['total'];
    }
}
