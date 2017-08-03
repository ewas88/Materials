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

    }
}
