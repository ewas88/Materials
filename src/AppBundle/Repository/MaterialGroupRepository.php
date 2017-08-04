<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MaterialGroupRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MaterialGroupRepository extends EntityRepository
{
    public function getLeaves()
    {
        $query = $this->_em->createQuery(
            'SELECT child 
            FROM AppBundle:MaterialGroup AS parent,  AppBundle:MaterialGroup AS child 
            WHERE parent.id <> child.parent');

        return $query->getResult();

    }

    public function getList($id)
    {
        $query = $this->_em->createQuery('SELECT m FROM AppBundle:MaterialGroup m WHERE m.id != :id')
            ->setParameter('id', $id);;

        return $query->getResult();
    }


}
