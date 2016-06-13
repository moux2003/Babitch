<?php

namespace Cytron\Bundle\BabitchBundle\Controller\Tournament;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Cytron\Bundle\BabitchBundle\Form\TournamentMatchType;
use Cytron\Bundle\BabitchBundle\Controller\PaginatorTrait;

/**
 * Class MatchController.
 */
class MatchController extends FOSRestController implements ClassResourceInterface
{
    use PaginatorTrait;

    /**
     * Get a tournament match's details.
     *
     * @param int $id TournamentMatch id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @ApiDoc(
     *  section="TournamentMatch",
     *   description="Get a tournament match's details",
     *   output="Cytron\Bundle\BabitchBundle\Entity\Tournament\Match",
     *   statusCodes={
     *     200="OK",
     *     400="Bad request",
     *     404="TournamentMatch not found"
     *   }
     * )
     *
     * @Route(requirements={
     *   "id"="\d+"
     * })
     */
    public function getAction($id)
    {
        $tournamentMatch = $this->get('cytron_babitch.tournament_match.manager')->getRepository()->find($id);

        if (is_null($tournamentMatch)) {
            return $this->view(sprintf('TournamentMatch with id %s not found', $id), 404);
        }

        return $this->view($tournamentMatch, 200);
    }

    /**
     * Update a tournament match.
     *
     * @param Request $request Request
     * @param int     $id      TournamentMatch id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @Route(requirements={"id"="\d+"})
     *
     * @ApiDoc(
     *  section="TournamentMatch",
     *   description="Update a tournament",
     *   input={"class"="Cytron\Bundle\BabitchBundle\Form\TournamentMatchType", "name"=""},
     *   statusCodes={
     *     204="TournamentMatch updated",
     *     400="Bad request",
     *     404="TournamentMatch not found",
     *     422="Unprocessable entity"
     *   }
     * )
     */
    public function putAction(Request $request, $id)
    {
        $manager = $this->get('cytron_babitch.tournament_match.manager');
        $entity = $manager->getRepository()->find($id);

        if (!$entity) {
            return $this->view(sprintf('TournamentMatch with id %s not found', $id), 404);
        }

        $form = $this->container->get('form.factory')->createNamed('', new TournamentMatchType(), $entity);

        $form->submit($request);

        if ($form->isValid()) {
            $manager->persist($entity, true);

            return $this->view(null, 204);
        }

        return $this->view($form, 422);
    }

    /**
     * Delete a tournament match.
     *
     * @param int $id TournamentMatch id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @Route(requirements={"id"="\d+"})
     *
     * @ApiDoc(
     *  section="TournamentMatch",
     *   description="Delete a tournament",
     *   statusCodes={
     *     204="TournamentMatch deleted",
     *     404="TournamentMatch not found"
     *   }
     * )
     */
    public function deleteAction($tournamentId, $id)
    {
        $manager = $this->get('cytron_babitch.tournament_match.manager');
        $entity = $manager->getRepository()->find($id);

        if (!$entity) {
            return $this->view(sprintf('TournamentMatch with id %s not found', $id), 404);
        }

        $manager->remove($entity, true);

        return $this->view(null, 204);
    }
}
