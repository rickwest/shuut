<?php

namespace App\Controller;

use App\Entity\PriceMatrix;
use App\Form\PriceMatrixType;
use App\Repository\PriceMatrixRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/price/matrix", name="price_matrix_")
 */
class PriceMatrixController extends Controller
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(PriceMatrixRepository $priceMatrixRepository): Response
    {
        return $this->render('price_matrix/index.html.twig', [
            'price_matrices' => $priceMatrixRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $priceMatrix = new PriceMatrix();
        $form = $this->createForm(PriceMatrixType::class, $priceMatrix);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($priceMatrix);
            $entityManager->flush();

            $this->addFlash('success', 'Price Matrix - ' . $priceMatrix->getName() . ' was created successfully');

            return $this->redirectToRoute('price_matrix_show', [
                'id' => $priceMatrix->getId(),
            ]);
        }

        return $this->render('price_matrix/new.html.twig', [
            'price_matrix' => $priceMatrix,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(PriceMatrix $priceMatrix): Response
    {
        return $this->render('price_matrix/show.html.twig', [
            'price_matrix' => $priceMatrix,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PriceMatrix $priceMatrix): Response
    {
        $form = $this->createForm(PriceMatrixType::class, $priceMatrix);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Price Matrix - ' . $priceMatrix->getName() . ' was updated successfully');

            return $this->redirectToRoute('price_matrix_show', [
                'id' => $priceMatrix->getId(),
            ]);
        }

        return $this->render('price_matrix/edit.html.twig', [
            'price_matrix' => $priceMatrix,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, PriceMatrix $priceMatrix): Response
    {
        if ($this->isCsrfTokenValid('delete'.$priceMatrix->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($priceMatrix);
            $entityManager->flush();

            $this->addFlash('success', 'Price Matrix - ' . $priceMatrix->getName() . ' was deleted successfully');
        }

        return $this->redirectToRoute('price_matrix_index');
    }
}
