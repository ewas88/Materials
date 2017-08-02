<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class MaterialController extends Controller
{
    /**
     * @Route("/materials")
     * @Template("AppBundle:Material:all.html.twig")
     * @Method("GET")
     */
    public function allMaterialsAction()
    {
        $materialRepository = $this->getDoctrine()->getRepository('AppBundle:Material');
        $materials = $materialRepository->findBy(array(), array('name' => 'ASC'));

        return ['materials' => $materials];
    }

    /**
     * @Route("/materials/update/{id}", name="update_material")
     * @Template("AppBundle:Material:update.html.twig")
     */
    public function updateMaterialAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $materialRepository = $this->getDoctrine()->getRepository('AppBundle:Material');
        $material = $materialRepository->find($id);

        if ($material) {

        }
        
    }
}
