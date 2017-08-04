<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Material;
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

        $unitRepository = $this->getDoctrine()->getRepository('AppBundle:Unit');
        $units = $unitRepository->findBy(array(), array('name' => 'ASC'));

        $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');
        $groups = $groupRepository->findBy(array('parent' => null));

        return ['materials' => $materials, 'units' => $units, 'groups' => $groups];
    }

    /**
     * @Route("/materials/update/{id}", name="update_material")
     * @Template("AppBundle:Material:update.html.twig")
     * @Method("GET")
     */
    public function materialDetailsAction($id)
    {
        if (is_numeric($id)) {
            $materialRepository = $this->getDoctrine()->getRepository('AppBundle:Material');
            $material = $materialRepository->find($id);

            $unitRepository = $this->getDoctrine()->getRepository('AppBundle:Unit');
            $units = $unitRepository->findBy(array(), array('name' => 'ASC'));

            $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');
            $groups = $groupRepository->findBy(array('parent' => null));

            if ($material) {
                return ['material' => $material, 'units' => $units, 'groups' => $groups];
            } else {
                return ['message' => "Niepoprawny numer ID materiału."];
            }
        } else {
            return ['message' => "Niepoprawny numer ID materiału."];
        }

    }

    /**
     * @Route("/materials/update/{id}")
     * @Template("AppBundle:Material:update.html.twig")
     * @Method("POST")
     */
    public function updateMaterialAction(Request $request, $id)
    {
        if (is_numeric($id)) {
            $em = $this->getDoctrine()->getManager();

            $materialRepository = $this->getDoctrine()->getRepository('AppBundle:Material');
            $material = $materialRepository->find($id);

            if ($material) {
                $name = $request->request->get('name');
                $code = $request->request->get('code');
                $unit = $request->request->get('unit');
                $group = $request->request->get('group');

                if ($name != "") {
                    $material->setName($name);
                }

                if ($code != "") {
                    if ($materialRepository->findBy(array('code' => $code))) {
                        return ['message' => "Wybrany kod istnieje już w bazie - proszę stworzyć inny."];
                    } else {
                        $material->setCode($code);
                    }
                }

                if ($unit != "same") {
                    $unitRepository = $this->getDoctrine()->getRepository('AppBundle:Unit');
                    $material->setUnit($unitRepository->find($unit));
                }

                if ($group != "same") {
                    $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');
                    $material->setGroup($groupRepository->find($group));
                }

                $em->persist($material);
                $em->flush();

                return ['message' => "Dane materiału zostały zmienione."];

            } else {
                return ['message' => "Niepoprawny numer ID materiału."];
            }
        } else {
            return ['message' => "Niepoprawny numer ID materiału."];
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

        $materialRepository = $this->getDoctrine()->getRepository('AppBundle:Material');
        $materials = $materialRepository->findBy(array(), array('name' => 'ASC'));

        $unitRepository = $this->getDoctrine()->getRepository('AppBundle:Unit');
        $units = $unitRepository->findBy(array(), array('name' => 'ASC'));

        $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');
        $groups = $groupRepository->findBy(array('parent' => null));

        $name = $request->request->get('name');
        $code = $request->request->get('code');

        $unitRepository = $this->getDoctrine()->getRepository('AppBundle:Unit');
        $unit = $unitRepository->find($request->request->get('unit'));

        $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');
        $group = $groupRepository->find($request->request->get('group'));

        $material = new Material();
        $material->setName($name);

        if ($materialRepository->findBy(array('code' => $code))) {
            return ['materials' => $materials, 'units' => $units, 'groups' => $groups, 'message' => "Wybrany kod istnieje już w bazie - proszę stworzyć inny."];
        } else {
            $material->setCode($code);
        }
        $material->setUnit($unit);
        $material->setGroup($group);

        $em->persist($material);
        $em->flush();

        return ['materials' => $materials, 'units' => $units, 'groups' => $groups, 'message' => "Materiał dodany do bazy."];
    }
}
