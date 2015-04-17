<?php
namespace Symfonian\Indonesia\GammuBundle\Manager;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

interface ManagerInterface
{
    public function findByPhoneNumber($phoneNumber);

    public function findBy(array $criteria);

    public function searchBy(array $criteria);

    public function findAll();

    public function findLimit($limit, $start = 0);

    public function countRecord();
}
