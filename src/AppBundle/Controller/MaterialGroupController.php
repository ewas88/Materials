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

        $groups = $groupRepository->findBy(array('parent' => null));
        
        return ['groups' => $groups, 'allGroups' => $allGroups];
    }

    /**
     * @Route("/groups/update/{id}", name="update_group")
     * @Template("AppBundle:Group:update.html.twig")
     * @Method("GET")
     */
    public function groupDetailsAction($id)
    {
        if (is_numeric($id)) {
            $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');
            $group = $groupRepository->find($id);

            $groups = $groupRepository->findBy(array('parent' => null));

            if ($group) {
                return ['group' => $group, 'groups' => $groups];
            } else {
                return ['message' => "Niepoprawny numer ID grupy."];
            }
        } else {
            return ['message' => "Niepoprawny numer ID grupy."];
        }

    }

    /**
     * @Route("/groups/update/{id}")
     * @Template("AppBundle:Group:update.html.twig")
     * @Method("POST")
     */
    public function updateGroupAction(Request $request, $id)
    {
        if (is_numeric($id)) {
            $em = $this->getDoctrine()->getManager();

            $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');
            $group = $groupRepository->find($id);

            if ($group) {
                $name = $request->request->get('name');
                $parent = $request->request->get('group');

                if ($name != "") {
                    $group->setName($name);
                }

                if ($parent == null) {
                    $group->setParent(null);
                } else if ($parent != "same") {
                    $materialRepository = $this->getDoctrine()->getRepository('AppBundle:Material');
                    $materials = $materialRepository->findBy(array('group' => $parent));
                    if ($materials) {
                        return ['message' => "Wybrana grupa posiada przypisane materiały. 
                        Usuń materiały z grupy, aby móc przypisać podgrupę."];
                    } else {
                    $group->setParent($groupRepository->find($parent));
                    }
                }

                $em->persist($group);
                $em->flush();

                return ['message' => "Dane grupy zostały zmienione."];

            } else {
                return ['message' => "Niepoprawny numer ID grupy."];
            }
        } else {
            return ['message' => "Niepoprawny numer ID grupy."];
        }
    }

    /**
     * @Route("/groups")
     * @Template("AppBundle:Group:all.html.twig")
     * @Method("POST")
     */
    public function newGroupAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $groupRepository = $this->getDoctrine()->getRepository('AppBundle:MaterialGroup');

        $name = $request->request->get('name');
        $parent = $request->request->get('group');

        $group = new MaterialGroup();
        $group->setName($name);

        if ($parent == null) {
            $group->setParent(null);
        } else {
            $group->setParent($groupRepository->find($parent));
        }

        $em->persist($group);
        $em->flush();

        $allGroups = $groupRepository->findBy(array(), array('name' => 'ASC'));

        $groups = $groupRepository->findBy(array('parent' => null));

        return ['groups' => $groups, 'allGroups' => $allGroups, 'message' => "Grupa materiałów dodana do bazy."];
    }
}
