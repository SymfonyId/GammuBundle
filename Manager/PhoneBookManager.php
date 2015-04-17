<?php
namespace Symfonian\Indonesia\GammuBundle\Manager;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Doctrine\ORM\Query\ResultSetMapping;

class PhoneBookManager extends AbstractManager implements ManagerInterface
{
    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        $resultSetMapping = new ResultSetMapping();
        $resultSetMapping->addScalarResult('ID', 'id');
        $resultSetMapping->addScalarResult('Group', 'group');
        $resultSetMapping->addScalarResult('Name', 'name');
        $resultSetMapping->addScalarResult('Number', 'number');

        $this->setResultMapping($resultSetMapping);
    }

    protected function getGlobalSQL()
    {
        return sprintf('
            SELECT
                Phonebook.ID AS ID,
                Group.Name AS Group,
                Phonebook.Name AS Name,
                Phonebook.Number AS Number
            FROM
                %s Phonebook
            JOIN
                pbk_groups Group
                ON
                    Phonebook.GroupID = Group.ID
        ', $this->getTable());
    }

    protected function getTable()
    {
        return 'pbk';
    }

    public function findByPhoneNumber($phoneNumber)
    {
        return $this->findBy(array('Phonebook.Number' =>  $phoneNumber));
    }
}
