<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Material;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\MaterialGroup;

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

        $unitRepository = $this->getDoctrine()->getRepository('AppBundle:Unit');
        $units = $unitRepository->findBy(array(), array('name' => 'ASC'));

        $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');
        $groups = $groupRepository->getLeaves();

        return ['materials' => $materials, 'units' => $units, 'groups' => $groups];
    }

    /**
     * @Route("/materials/update/{id}", name="update_material")
     * @Template("AppBundle:Material:update.html.twig")
     */
    public function updateMaterialAction(Request $request, $id)
    {
        if (is_numeric($id)) {
            $materialRepository = $this->getDoctrine()->getRepository('AppBundle:Material');
            $material = $materialRepository->find($id);

            if ($material) {
                return ['material' => $material];
            } else {
                return ['message' => "Niepoprawny numer ID materiału."];
            }
        } else {
            return ['message' => "Niepoprawny numer ID materiałuuu."];
        }

    }

    /**
     * @Route("/materials")
     * @Template("AppBundle:Material:all.html.twig")
     * @Method("POST")
     */
    public function newMaterialAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $name = $request->request->get('name');
        $code = $request->request->get('code');

        $unitRepository = $this->getDoctrine()->getRepository('AppBundle:Unit');
        $unit = $unitRepository->find($request->request->get('unit'));

        $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');
        $group = $groupRepository->find($request->request->get('group'));

        $material = new Material();
        $material->setName($name);
        $material->setCode($code);
        $material->setUnit($unit);
        $material->setGroup($group);

        $em->persist($material);
        $em->flush();

        $materialRepository = $this->getDoctrine()->getRepository('AppBundle:Material');
        $materials = $materialRepository->findBy(array(), array('name' => 'ASC'));

        $unitRepository = $this->getDoctrine()->getRepository('AppBundle:Unit');
        $units = $unitRepository->findBy(array(), array('name' => 'ASC'));

        $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');
        $groups = $groupRepository->getLeaves();

        return ['materials' => $materials, 'units' => $units, 'groups' => $groups, 'message' => "Materiał dodany do bazy."];
    }
}
