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
    public function getLeaves ()
    {
        $query = $this->_em->createQuery('SELECT mg FROM AppBundle:MaterialGroup mg WHERE mg.rightSide = mg.leftSide + 1');

        return $query->getResult();

    }

    public function getTree ()
    {

        $sql = " 
        SELECT CONCAT(REPEAT(' ',COUNT(parent.name)-1),
child.name) AS name
FROM AppBundle:MaterialGroup AS child,
AppBundle:MaterialGroup AS parent
WHERE child.leftSide BETWEEN parent.leftSide AND parent.rightSide
GROUP BY child.name
ORDER BY child.leftSide
    ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
