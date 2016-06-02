<?php

namespace Cytron\Bundle\BabitchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Cytron\Bundle\BabitchBundle\Form\TeamType;

/**
 * Class TeamController.
 */
class TeamController extends FOSRestController implements ClassResourceInterface
{
    use PaginatorTrait;

    /**
     * Create a team.
     *
     * @param Request $request
     *
     * @return \FOS\RestBundle\View\View
     *
     * @ApiDoc(
     *  section="Team",
     *   description="Create a team",
     *   input={"class"="Cytron\Bundle\BabitchBundle\Form\TeamType", "name"=""},
     *   output="Cytron\Bundle\BabitchBundle\Entity\Team",
     *   statusCodes={
     *     201="Team created",
     *     400="Bad request",
     *     422="Unprocessable entity"
     *   }
     * )
     */
    public function cpostAction(Request $request)
    {
        $manager = $this->get('cytron_babitch.team.manager');
        $entity = $manager->create();
        $form = $this->container->get('form.factory')->createNamed('', new TeamType(), $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager->persist($entity, true);

            return $this->view($entity, 201, array(
                'Location' => $this->generateUrl('get_team', ['id' => $entity->getId()], true),
            ));
        }

        return $this->view($form, 422);
    }

    /**
     * Get a team's details.
     *
     * @param int $id Team id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @ApiDoc(
     *  section="Team",
     *   description="Get a team's details",
     *   output="Cytron\Bundle\BabitchBundle\Entity\Team",
     *   statusCodes={
     *     200="OK",
     *     400="Bad request",
     *     404="Team not found"
     *   }
     * )
     *
     * @Route(requirements={
     *   "id"="\d+"
     * })
     */
    public function getAction($id)
    {
        $team = $this->get('cytron_babitch.team.manager')->getRepository()->find($id);

        if (is_null($team)) {
            return $this->view(sprintf('Team with id %s not found', $id), 404);
        }

        return $this->view($team, 200);
    }

    /**
     * Get teams list.
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return \FOS\RestBundle\View\View
     *
     * @QueryParam(name="page", requirements="\d+", default="1", description="Current page index")
     * @QueryParam(name="per_page", requirements="\d+", default="50", description="Number of elements displayed per page")
     *
     * @ApiDoc(
     *  section="Team",
     *   description="Get teams list",
     *   output="Cytron\Bundle\BabitchBundle\Entity\Team",
     *   statusCodes={
     *     200="OK",
     *     400="Bad request"
     *   }
     * )
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        list($start, $limit) = $this->getStartAndLimitFromParams($paramFetcher);

        $repository = $this->get('cytron_babitch.team.manager')->getRepository();
        $entities = $repository->findBy([], ['id' => 'DESC'], $limit, $start);

        return $this->view($entities, 200);
    }

    /**
     * Update a team.
     *
     * @param Request $request Request
     * @param int     $id      Team id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @Route(requirements={"id"="\d+"})
     *
     * @ApiDoc(
     *  section="Team",
     *   description="Update a team",
     *   input={"class"="Cytron\Bundle\BabitchBundle\Form\TeamType", "name"=""},
     *   statusCodes={
     *     204="Team updated",
     *     400="Bad request",
     *     404="Team not found",
     *     422="Unprocessable entity"
     *   }
     * )
     */
    public function putAction(Request $request, $id)
    {
        $manager = $this->get('cytron_babitch.team.manager');
        $entity = $manager->getRepository()->find($id);

        if (!$entity) {
            return $this->view(sprintf('Team with id %s not found', $id), 404);
        }

        $form = $this->container->get('form.factory')->createNamed('', new TeamType(), $entity);

        $form->submit($request);

        if ($form->isValid()) {
            $manager->persist($entity, true);

            return $this->view(null, 204);
        }

        return $this->view($form, 422);
    }

    /**
     * Delete a team.
     *
     * @param int $id Team id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @Route(requirements={"id"="\d+"})
     *
     * @ApiDoc(
     *  section="Team",
     *   description="Delete a team",
     *   statusCodes={
     *     204="Team deleted",
     *     404="Team not found"
     *   }
     * )
     */
    public function deleteAction($id)
    {
        $manager = $this->get('cytron_babitch.team.manager');
        $entity = $manager->getRepository()->find($id);

        if (!$entity) {
            return $this->view(sprintf('Team with id %s not found', $id), 404);
        }

        $manager->remove($entity, true);

        return $this->view(null, 204);
    }
}
