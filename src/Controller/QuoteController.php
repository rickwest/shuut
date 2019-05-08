<?php

namespace App\Controller;

use App\DistanceMatrix\DistanceMatrixInterface;
use App\Entity\LineItem;
use App\Entity\Quote;
use App\Form\QuoteEditType;
use App\Form\QuoteType;
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
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, DistanceMatrixInterface $distanceMatrix): Response
    {
        $quote = new Quote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // We store the distance as an attribute of quote because we don't want to be hitting api unnecessarily
            $quote->setDistance($distanceMatrix->getDistance($quote->getPickUp(), $quote->getDropOff()));

            if ($quote->getPriceMatrix()) {
                $applyEntry = null;

                foreach ($quote->getPriceMatrix()->getEntries() as $entry) {
                   if ($entry->getVehicleType() === $quote->getVehicleType()) {
                       $applyEntry = $entry;
                   }
                }

                if ($applyEntry) {
                    $lineItem = new LineItem();
                    $lineItem
                        ->setDescription('Mileage Charge')
                        ->setQuantity($quote->getDistance()->distanceMiles())
                        ->setRate($applyEntry->getSalePrice());

                    $quote->addLineItem($lineItem);
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quote);
            $entityManager->flush();

            return $this->redirectToRoute('quote_new_2', [
                'id' => $quote->getId(),
            ]);
        }

        return $this->render('quote/new.html.twig', [
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
    public function newEdit(Request $request, Quote $quote, DistanceMatrixInterface $distanceMatrix): Response
    {
        $form = $this->createForm(QuoteEditType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $quote->setStatus(
                $quote->getLineItems()->count() > 0 ? Quote::STATUS_COMPLETE : Quote::STATUS_INCOMPLETE
            );

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
            'map' => $quote->getDistance() ? $distanceMatrix->getMap($quote->getPickUp(), $quote->getDropOff()) : null,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Quote $quote): Response
    {
        if ($quote->getStatus() === Quote::STATUS_ACCEPTED) {
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
