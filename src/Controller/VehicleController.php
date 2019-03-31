<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleFormType;
use App\Table\TableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vehicle", name="vehicle_")
 */
class VehicleController extends Controller
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(Request $request, TableFactory $tableFactory): Response
    {
        return $this->render('vehicle/index.html.twig', [
            'table' => $tableFactory->getTable($request,Vehicle::class),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleFormType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicle);
            $entityManager->flush();

            $this->addFlash('success', 'Vehicle - ' . $vehicle->getRegistration() . ' was created successfully');

            return $this->redirectToRoute('vehicle_show', [
                'id' => $vehicle->getId(),
            ]);
        }

        return $this->render('vehicle/new.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Vehicle $vehicle): Response
    {
        return $this->render('vehicle/show.html.twig', [
            'vehicle' => $vehicle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vehicle $vehicle): Response
    {
        $form = $this->createForm(VehicleFormType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Vehicle - ' . $vehicle->getRegistration() . ' was updated successfully');

            return $this->redirectToRoute('vehicle_show', [
                'id' => $vehicle->getId(),
            ]);
        }

        return $this->render('vehicle/edit.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Vehicle $vehicle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vehicle);
            $entityManager->flush();

            $this->addFlash('success', 'Vehicle - ' . $vehicle->getRegistration() . ' was deleted successfully');
        }

        return $this->redirectToRoute('vehicle_index');
    }
}
