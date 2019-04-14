<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use App\Table\TableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/job", name="job_")
 */
class JobController extends Controller
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(Request $request, TableFactory $tableFactory): Response
    {
        return $this->render('job/index.html.twig', [
            'table' => $tableFactory->getTable($request, Job::class),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET", "POST"})
     */
    public function show(Request $request, Job $job): Response
    {
        if (! $job->isComplete()) {
            $form = $this->createForm(JobType::class, $job);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Job - ' . $job->getId() . ' was updated successfully');

                return $this->redirectToRoute('job_show', [
                    'id' => $job->getId(),
                ]);
            }
        }

        return $this->render('job/show.html.twig', [
            'job' => $job,
            'form' => isset($form) ? $form->createView() : null,
        ]);
    }

    /**
     * @Route("/complete/{id}", name="complete", methods={"POST"})
     */
    public function complete(Request $request, Job $job)
    {
        if ($this->isCsrfTokenValid('complete'.$job->getId(), $request->request->get('_token')) && $job->canBeCompleted()) {
            $job->complete();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Quote - ' . $job->getId() . ' accepted and job created successfully.');
        }

        return $this->redirectToRoute('job_show', [
            'id' => $job->getId(),
        ]);
    }

    /**
     * @Route("/cancel/{id}", name="cancel", methods={"POST"})
     */
    public function cancel(Request $request, Job $job)
    {
        if ($this->isCsrfTokenValid('cancel'.$job->getId(), $request->request->get('_token'))) {
            $job->cancel();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Job - ' . $job->getId() . ' cancelled 😔.');
        }

        return $this->redirectToRoute('job_index', [
            'id' => $job->getId(),
        ]);
    }
}
