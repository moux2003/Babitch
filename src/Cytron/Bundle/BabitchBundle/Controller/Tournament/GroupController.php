<?php

namespace Cytron\Bundle\BabitchBundle\Controller\Tournament;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Cytron\Bundle\BabitchBundle\Form\TournamentGroupType;
use Cytron\Bundle\BabitchBundle\Controller\PaginatorTrait;

/**
 * Class TournamentController.
 */
class GroupController extends FOSRestController implements ClassResourceInterface
{
    use PaginatorTrait;

    /**
     * Create a tournament group.
     *
     * @param Request $request
     *
     * @return \FOS\RestBundle\View\View
     *
     * @ApiDoc(
     *  section="TournamentGroup",
     *   description="Create a tournament group",
     *   input={"class"="Cytron\Bundle\BabitchBundle\Form\TournamentGroupType", "name"=""},
     *   output="Cytron\Bundle\BabitchBundle\Entity\Tournament\Group",
     *   statusCodes={
     *     201="TournamentGroup created",
     *     400="Bad request",
     *     422="Unprocessable entity"
     *   }
     * )
     */
    public function cpostAction(Request $request, $id)
    {
        $manager = $this->get('cytron_babitch.tournament_group.manager');
        $entity = $manager->create();
        $form = $this->container->get('form.factory')->createNamed('', new TournamentGroupType(), $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager->persist($entity, true);

            return $this->view($entity, 201, array(
                'Location' => $this->generateUrl('get_tournament_group', ['id' => $entity->getId(), 'tournamentId' => $entity->getTournament()->getId()], true),
            ));
        }

        return $this->view($form, 422);
    }

    /**
     * Get a tournament group's details.
     *
     * @param int $id TournamentGroup id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @ApiDoc(
     *  section="TournamentGroup",
     *   description="Get a tournament group's details",
     *   output="Cytron\Bundle\BabitchBundle\Entity\Tournament\Group",
     *   statusCodes={
     *     200="OK",
     *     400="Bad request",
     *     404="TournamentGroup not found"
     *   }
     * )
     *
     * @Route(requirements={
     *   "id"="\d+"
     * })
     */
    public function getAction($tournamentId, $id)
    {
        $tournamentGroup = $this->get('cytron_babitch.tournament_group.manager')->getRepository()->find($id);

        if (is_null($tournamentGroup)) {
            return $this->view(sprintf('TournamentGroup with id %s not found', $id), 404);
        }

        if ($tournamentGroup->getTournament()->getId() !== $tournamentId) {
            return $this->view(sprintf('TournamentGroup does not belong to tournament id %s', $id), 404);
        }

        return $this->view($tournamentGroup, 200);
    }

    /**
     * Get tournament groups list.
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return \FOS\RestBundle\View\View
     *
     * @QueryParam(name="page", requirements="\d+", default="1", description="Current page index")
     * @QueryParam(name="per_page", requirements="\d+", default="50", description="Number of elements displayed per page")
     *
     * @ApiDoc(
     *  section="TournamentGroup",
     *   description="Get tournament groups list",
     *   output="Cytron\Bundle\BabitchBundle\Entity\Tournament\Group",
     *   statusCodes={
     *     200="OK",
     *     400="Bad request"
     *   }
     * )
     *
     * @Route(requirements={
     *   "tournamentId"="\d+"
     * })
     */
    public function cgetAction(ParamFetcher $paramFetcher, $tournamentId)
    {
        list($start, $limit) = $this->getStartAndLimitFromParams($paramFetcher);

        $repository = $this->get('cytron_babitch.tournament_group.manager')->getRepository();
        $entities = $repository->findBy(['tournament' => $tournamentId], ['id' => 'DESC'], $limit, $start);

        return $this->view($entities, 200);
    }

    /**
     * Update a tournament group.
     *
     * @param Request $request Request
     * @param int     $id      TournamentGroup id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @Route(requirements={"id"="\d+"})
     *
     * @ApiDoc(
     *  section="TournamentGroup",
     *   description="Update a tournament",
     *   input={"class"="Cytron\Bundle\BabitchBundle\Form\TournamentGroupType", "name"=""},
     *   statusCodes={
     *     204="TournamentGroup updated",
     *     400="Bad request",
     *     404="TournamentGroup not found",
     *     422="Unprocessable entity"
     *   }
     * )
     */
    public function putAction(Request $request, $tournamentId, $id)
    {
        $manager = $this->get('cytron_babitch.tournament_group.manager');
        $entity = $manager->getRepository()->find($id);

        if (!$entity) {
            return $this->view(sprintf('TournamentGroup with id %s not found', $id), 404);
        }

        $form = $this->container->get('form.factory')->createNamed('', new TournamentGroupType(), $entity);

        $form->submit($request);

        if ($form->isValid()) {
            $manager->persist($entity, true);

            return $this->view(null, 204);
        }

        return $this->view($form, 422);
    }

    /**
     * Delete a tournament group.
     *
     * @param int $id TournamentGroup id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @Route(requirements={"id"="\d+"})
     *
     * @ApiDoc(
     *  section="TournamentGroup",
     *   description="Delete a tournament",
     *   statusCodes={
     *     204="TournamentGroup deleted",
     *     404="TournamentGroup not found"
     *   }
     * )
     */
    public function deleteAction($tournamentId, $id)
    {
        $manager = $this->get('cytron_babitch.tournament_group.manager');
        $entity = $manager->getRepository()->find($id);

        if (!$entity) {
            return $this->view(sprintf('TournamentGroup with id %s not found', $id), 404);
        }

        $manager->remove($entity, true);

        return $this->view(null, 204);
    }
}
