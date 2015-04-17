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

    abstract protected function getTable();

    abstract protected function getGlobalSQL();

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

    public function findBy(array $criteria)
    {
        $where = array();
        foreach ($criteria as $field => $value) {
            $where[] = array(
                'column' => $field,
                'operator' => '=',
                'alias' => $field,
                'value' => $value,
                'conjunction' => 'AND',
            );
        }

        return $this->findLimit($criteria);
    }

    public function searchBy(array $criteria)
    {
        $where = array();
        foreach ($criteria as $field => $value) {
            $where[] = array(
                'column' => $field,
                'operator' => 'LIKE',
                'alias' => $field,
                'value' => $value,
                'conjunction' => 'O',
            );
        }

        return $this->findLimit($criteria);
    }

    public function findAll()
    {
        return $this->execute($this->getGlobalSQL());
    }

    public function findLimit($criteria, $limit = -1, $start = 0)
    {
        $sql = $this->getGlobalSQL().' WHERE ';

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
        $result = $this->execute('SELECT SUM(ID) AS total FROM '.$this->getTable(), array(), $resultMapping);

        return $result['total'];
    }
}
