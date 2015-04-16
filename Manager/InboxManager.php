<?php
namespace Symfonian\Indonesia\GammuBundle\Manager;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

class InboxManager extends AbstractManager implements ManagerInterface
{
    const GLOBAL_SQL = '';

    public function findByPhoneNumber($phoneNumber)
    {
        return $this->findBy(array('phoneNumber' =>  $phoneNumber));
    }

    public function findAll()
    {
        $sql = '';

        return $this->execute($sql);
    }

    public function findBy(array $criteria)
    {
        $sql = '';

        return $this->execute($sql, $criteria);
    }

    public function findLimit($limit, $start = 0)
    {
        $sql = '';

        return $this->execute($sql, array('start' => $start, 'limit' => $limit));
    }
}