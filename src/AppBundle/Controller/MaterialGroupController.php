<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\MaterialGroup;

class MaterialGroupController extends Controller
{
    /**
     * @Route("/groups")
     * @Template("AppBundle:Group:all.html.twig")
     * @Method("GET")
     */
    public function allGroupsAction()
    {
        $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');
        $allGroups = $groupRepository->findBy(array(), array('name' => 'ASC'));

//$roots = $groupRepository->findAll(array('parent' => null));
//
//print_r(MaterialGroup::getTree($roots));






        return [ 'allGroups' => $allGroups];
    }

    /**
     * @Route("/groups")
     * @Template("AppBundle:Group:all.html.twig")
     * @Method("POST")
     */
    public function newGroupAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $name = $request->request->get('name');
        $abbreviation = $request->request->get('abbreviation');


        $em->persist($unit);
        $em->flush();



        return ['units' => $units, 'message' => "Jednostka miary dodana do bazy."];
    }
}
