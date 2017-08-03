<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class MaterialGroupController extends Controller
{
    /**
     * @Route("/groups")
     * @Template("AppBundle:Group:all.html.twig")
     * @Method("GET")
     */
    public function allGroupsAction()
    {
//        $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');
//        $groups = $groupRepository->findBy(array(), array('name' => 'ASC'));
//        $groups = $groupRepository->getTree();
//
//        return ['groups' => $groups];

        $sql = " 
        SELECT CONCAT(REPEAT(' ',COUNT(`parent`.`name`)-1),
`child`.`name`) AS `name`
FROM `material_group` AS `child`,
`material_group` AS `parent`
WHERE `child`.`left_side` BETWEEN `parent`.`left_side` AND `parent`.`right_side`
GROUP BY `child`.`id`
ORDER BY `child`.`left_side`
    ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->query($sql);

        print_r($stmt->fetchAll());

//        return $stmt->fetchAll();
    }
}
