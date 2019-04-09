<?php

namespace App\Controller;

use App\DistanceMatrix\DistanceMatrixInterface;
use App\Entity\Quote;
use App\Form\QuoteStep1Type;
use App\Form\QuoteStep2Type;
use App\Table\TableFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quote", name="quote_" )
 */
class QuoteController extends Controller
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(Request $request, TableFactory $tableFactory): Response
    {
        return $this->render('quote/index.html.twig', [
            'table' => $tableFactory->getTable($request, Quote::class),
//            'quotes' => $quoteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function newStep1(Request $request, DistanceMatrixInterface $distanceMatrix): Response
    {
        $quote = new Quote();
        $form = $this->createForm(QuoteStep1Type::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // We store the distance as an attribute of quote because we don't want to be hitting api unnecessarily
            $quote->setDistance($distanceMatrix->getDistance($quote->getPickUp(), $quote->getDropOff()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quote);
            $entityManager->flush();

            return $this->redirectToRoute('quote_new_2', [
                'id' => $quote->getId(),
            ]);
        }

        return $this->render('quote/new_step_1.html.twig', [
            'quote' => $quote,
            'form' => $form->createView(),
            'googleMapsApiKey' => $this->getParameter('google_maps_api_key'),
        ]);
    }

    /**
     * @Route("/new/{id}", name="new_2")
     * @Route("/edit/{id}", name="edit")
     * @Method("GET, POST")
     */
    public function newStep2(Request $request, Quote $quote, DistanceMatrixInterface $distanceMatrix): Response
    {
        $form = $this->createForm(QuoteStep2Type::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quote);
            $entityManager->flush();

            $this->addFlash('success', 'Quote - ' . $quote->getId() . ' was updated successfully');

            return $this->redirectToRoute('quote_show', [
                'id' => $quote->getId(),
            ]);
        }

        return $this->render('quote/new_edit.html.twig', [
            'quote' => $quote,
            'form' => $form->createView(),
            'map' => $distanceMatrix->getMap($quote->getPickUp(), $quote->getDropOff())
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Quote $quote): Response
    {
        if ($quote->status() === Quote::STATUS_ACCEPTED) {
            return $this->redirectToRoute('job_show', [
                'id' => $quote->getJob()->getId(),
            ]);
        }

        return $this->render('quote/show.html.twig', [
            'quote' => $quote,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Quote $quote): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quote->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quote);
            $entityManager->flush();

            $this->addFlash('success', 'Quote - ' . $quote->getId() . ' was deleted successfully');
        }

        return $this->redirectToRoute('quote_index');
    }

    /**
     * @Route("/{id}", name="accept", methods={"POST"})
     */
    public function accept(Request $request, Quote $quote)
    {
        if ($this->isCsrfTokenValid('accept'.$quote->getId(), $request->request->get('_token'))) {
            $quote->accept();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Quote - ' . $quote->getId() . ' accepted and job created successfully.');
        }

        return $this->redirectToRoute('job_show', [
            'id' => $quote->getJob()->getId(),
        ]);
    }
}
