<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Unit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class UnitController extends Controller
{
    /**
     * @Route("/units")
     * @Template("AppBundle:Unit:all.html.twig")
     * @Method("GET")
     */
    public function allUnitsAction()
    {
        $unitRepository = $this->getDoctrine()->getRepository('AppBundle:Unit');
        $units = $unitRepository->findBy(array(), array('name' => 'ASC'));

        return ['units' => $units];
    }

    /**
     * @Route("/units/update/{id}")
     * @Template("AppBundle:Unit:update.html.twig")
     * @Method("GET")
     */
    public function unitDetailsAction($id)
    {
        if (is_numeric($id)) {
            $unitRepository = $this->getDoctrine()->getRepository('AppBundle:Unit');
            $unit = $unitRepository->find($id);

            if ($unit) {
                return ['unit' => $unit];
            } else {
                return ['message' => "Niepoprawny numer ID jednostki miary."];
            }
        } else {
            return ['message' => "Niepoprawny numer ID jednostki miaryyy."];
        }

    }

    /**
     * @Route("/units/update/{id}")
     * @Template("AppBundle:Unit:update.html.twig")
     * @Method("POST")
     */
    public function updateUnitAction(Request $request, $id)
    {
        if (is_numeric($id)) {
            $em = $this->getDoctrine()->getManager();

            $unitRepository = $this->getDoctrine()->getRepository('AppBundle:Unit');
            $unit = $unitRepository->find($id);

            if ($unit) {
                $name = $request->request->get('name');
                $abbreviation = $request->request->get('abbreviation');

                if ($name != "") {
                    $unit->setName($name);
                }

                if ($abbreviation != "") {
                    $unit->setAbbreviation($abbreviation);
                }

                $em->persist($unit);
                $em->flush();

                return ['message' => "Dane jednostki miary zostały zmienione."];

            } else {
                return ['message' => "Niepoprawny numer ID jednostki miary."];
            }
        } else {
            return ['message' => "Niepoprawny numer ID jednostki miary...."];
        }
    }

                                                                                                                                                                                                                                                                                                                                                                                            /**
                                                                                                                                                                                                                                                                                                                                                                                             * @Route("/units")
                                                                                                                                                                                                                                                                                                                                                                                             * @Template("AppBundle:Unit:all.html.twig")
                                                                                                                                                                                                                                                                                                                                                                                             * @Method("POST")
                                                                                                                                                                                                                                                                                                                                                                                             */
                                                                                                                                                                                                                                                                                                                                                                                            public function newUnitAction(Request $request)
                                                                                                                                                                                                                                                                                                                                                                                            {
                                                                                                                                                                                                                                                                                                                                                                                                $em = $this->getDoctrine()->getManager();
                                                                                                                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                                                $name = $request->request->get('name');
                                                                                                                                                                                                                                                                                                                                                                                                $abbreviation = $request->request->get('abbreviation');
                                                                                                                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                                                $unit = new Unit();
                                                                                                                                                                                                                                                                                                                                                                                                $unit->setName($name);
                                                                                                                                                                                                                                                                                                                                                                                                $unit->setAbbreviation($abbreviation);
                                                                                                                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                                                $em->persist($unit);
                                                                                                                                                                                                                                                                                                                                                                                                $em->flush();
                                                                                                                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                                                $unitRepository = $this->getDoctrine()->getRepository('AppBundle:Unit');
                                                                                                                                                                                                                                                                                                                                                                                                $units = $unitRepository->findBy(array(), array('name' => 'ASC'));
                                                                                                                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                                                return ['units' => $units, 'message' => "Jednostka miary dodana do bazy."];
                                                                                                                                                                                                                                                                                                                                                                                            }
}
