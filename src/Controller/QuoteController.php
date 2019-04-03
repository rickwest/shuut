<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteStep1Type;
use App\Form\QuoteStep2Type;
use App\Repository\QuoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quote")
 */
class QuoteController extends Controller
{
    /**
     * @Route("/", name="quote_index", methods={"GET"})
     */
    public function index(QuoteRepository $quoteRepository): Response
    {
        return $this->render('quote/index.html.twig', [
            'quotes' => $quoteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="quote_new", methods={"GET","POST"})
     */
    public function newStep1(Request $request): Response
    {
        if ($request->getSession()->has('quote')) {
            $request->getSession()->remove('quote');
        };

        $quote = new Quote();
        $form = $this->createForm(QuoteStep1Type::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($quote);
//            $entityManager->flush();
            // Calculate distance

            $request->getSession()->set('quote', $quote);

            return $this->redirectToRoute('quote_new_2');
        }

        return $this->render('quote/new_step_1.html.twig', [
            'quote' => $quote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new/2", name="quote_new_2", methods={"GET","POST"})
     */
    public function newStep2(Request $request): Response
    {
        if (! $request->getSession()->has('quote')) {
            return $this->redirectToRoute('quote_new');
        }

        /** @var Quote $quote */
        $quote = $request->getSession()->get('quote');

        $form = $this->createForm(QuoteStep2Type::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quote);
            $entityManager->flush();

            return $this->redirectToRoute('quote_show', [
                'id' => $quote->getId(),
            ]);
        }

        return $this->render('quote/new_step_2.html.twig', [
            'quote' => $quote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quote_show", methods={"GET"})
     */
    public function show(Quote $quote): Response
    {
        return $this->render('quote/show.html.twig', [
            'quote' => $quote,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="quote_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quote $quote): Response
    {
        $form = $this->createForm(QuoteStep1Type::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quote_index', [
                'id' => $quote->getId(),
            ]);
        }

        return $this->render('quote/edit.html.twig', [
            'quote' => $quote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quote_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Quote $quote): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quote->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quote_index');
    }
}
