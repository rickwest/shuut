<?php

namespace App\Controller;

use App\Entity\Driver;
use App\Form\DriverType;
use App\Table\TableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/driver", name="driver_")
 */
class DriverController extends Controller
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(Request $request, TableFactory $tableFactory): Response
    {
        return $this->render('driver/index.html.twig', [
            'table' => $tableFactory->getTable($request, Driver::class),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $driver = new Driver();
        $form = $this->createForm(DriverType::class, $driver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($driver);
            $entityManager->flush();

            $this->addFlash('success', 'Driver - ' . $driver->getName() . ' was created successfully');

            return $this->redirectToRoute('driver_show', [
                'id' => $driver->getId(),
            ]);
        }

        return $this->render('driver/new.html.twig', [
            'driver' => $driver,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Driver $driver): Response
    {
        return $this->render('driver/show.html.twig', [
            'driver' => $driver,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Driver $driver): Response
    {
        $form = $this->createForm(DriverType::class, $driver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Driver - ' . $driver->getName() . ' was updated successfully');

            return $this->redirectToRoute('driver_show', [
                'id' => $driver->getId(),
            ]);
        }

        return $this->render('driver/edit.html.twig', [
            'driver' => $driver,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Driver $driver): Response
    {
        if ($this->isCsrfTokenValid('delete'.$driver->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($driver);
            $entityManager->flush();

            $this->addFlash('success', 'Driver - ' . $driver->getName() . ' was deleted successfully');
        }

        return $this->redirectToRoute('driver_index');
    }
}
