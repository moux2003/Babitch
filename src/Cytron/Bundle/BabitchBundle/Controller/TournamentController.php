<?php

namespace Cytron\Bundle\BabitchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Cytron\Bundle\BabitchBundle\Form\TournamentType;

/**
 * Class TournamentController.
 */
class TournamentController extends FOSRestController implements ClassResourceInterface
{
    use PaginatorTrait;

    /**
     * Create a tournament.
     *
     * @param Request $request
     *
     * @return \FOS\RestBundle\View\View
     *
     * @ApiDoc(
     *  section="Tournament",
     *   description="Create a tournament",
     *   input={"class"="Cytron\Bundle\BabitchBundle\Form\TournamentType", "name"=""},
     *   output="Cytron\Bundle\BabitchBundle\Entity\Tournament",
     *   statusCodes={
     *     201="Tournament created",
     *     400="Bad request",
     *     422="Unprocessable entity"
     *   }
     * )
     */
    public function cpostAction(Request $request)
    {
        $manager = $this->get('cytron_babitch.tournament.manager');
        $entity = $manager->create();
        $form = $this->container->get('form.factory')->createNamed('', new TournamentType(), $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager->persist($entity, true);

            return $this->view($entity, 201, array(
                'Location' => $this->generateUrl('get_tournament', ['id' => $entity->getId()], true),
            ));
        }

        return $this->view($form, 422);
    }

    /**
     * Get a tournament's details.
     *
     * @param int $id Tournament id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @ApiDoc(
     *  section="Tournament",
     *   description="Get a tournament's details",
     *   output="Cytron\Bundle\BabitchBundle\Entity\Tournament",
     *   statusCodes={
     *     200="OK",
     *     400="Bad request",
     *     404="Tournament not found"
     *   }
     * )
     *
     * @Route(requirements={
     *   "id"="\d+"
     * })
     */
    public function getAction($id)
    {
        $tournament = $this->get('cytron_babitch.tournament.manager')->getRepository()->find($id);

        if (is_null($tournament)) {
            return $this->view(sprintf('Tournament with id %s not found', $id), 404);
        }

        return $this->view($tournament, 200);
    }

    /**
     * Get tournaments list.
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return \FOS\RestBundle\View\View
     *
     * @QueryParam(name="page", requirements="\d+", default="1", description="Current page index")
     * @QueryParam(name="per_page", requirements="\d+", default="50", description="Number of elements displayed per page")
     *
     * @ApiDoc(
     *  section="Tournament",
     *   description="Get tournaments list",
     *   output="Cytron\Bundle\BabitchBundle\Entity\Tournament",
     *   statusCodes={
     *     200="OK",
     *     400="Bad request"
     *   }
     * )
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        list($start, $limit) = $this->getStartAndLimitFromParams($paramFetcher);

        $repository = $this->get('cytron_babitch.tournament.manager')->getRepository();
        $entities = $repository->findBy([], ['id' => 'DESC'], $limit, $start);

        return $this->view($entities, 200);
    }

    /**
     * Update a tournament.
     *
     * @param Request $request Request
     * @param int     $id      Tournament id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @Route(requirements={"id"="\d+"})
     *
     * @ApiDoc(
     *  section="Tournament",
     *   description="Update a tournament",
     *   input={"class"="Cytron\Bundle\BabitchBundle\Form\TournamentType", "name"=""},
     *   statusCodes={
     *     204="Tournament updated",
     *     400="Bad request",
     *     404="Tournament not found",
     *     422="Unprocessable entity"
     *   }
     * )
     */
    public function putAction(Request $request, $id)
    {
        $manager = $this->get('cytron_babitch.tournament.manager');
        $entity = $manager->getRepository()->find($id);

        if (!$entity) {
            return $this->view(sprintf('Tournament with id %s not found', $id), 404);
        }

        $form = $this->container->get('form.factory')->createNamed('', new TournamentType(), $entity);

        $form->submit($request);

        if ($form->isValid()) {
            $manager->persist($entity, true);

            return $this->view(null, 204);
        }

        return $this->view($form, 422);
    }

    /**
     * Delete a tournament.
     *
     * @param int $id Tournament id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @Route(requirements={"id"="\d+"})
     *
     * @ApiDoc(
     *  section="Tournament",
     *   description="Delete a tournament",
     *   statusCodes={
     *     204="Tournament deleted",
     *     404="Tournament not found"
     *   }
     * )
     */
    public function deleteAction($id)
    {
        $manager = $this->get('cytron_babitch.tournament.manager');
        $entity = $manager->getRepository()->find($id);

        if (!$entity) {
            return $this->view(sprintf('Tournament with id %s not found', $id), 404);
        }

        $manager->remove($entity, true);

        return $this->view(null, 204);
    }
}
