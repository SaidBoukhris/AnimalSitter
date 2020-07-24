<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/membre", name="membre_")
 */
class MembreController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(MembreRepository $membreRepository): Response
    {
        return $this->render('membre/index.html.twig', [
            'membres' => $membreRepository->findAll(),
            'pageName' => 'Les Gardiens',
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET","POST"})
     * @Route("/{id<[0-9]+>}/edit", name="edit", methods={"GET","POST"})
     */
    public function formMembre(Membre $membre = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$membre) {
            $membre = new Membre();
        }

        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(!$membre->getId()) {
                $membre->setCreatedAt(new \DateTimeImmutable);
            } else {
                $membre->setModifiedAt(new \DateTimeImmutable);
            }
            
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($membre);
            $entityManager->flush();

            return $this->redirectToRoute('membre_show', ['id' => $membre->getId()]);
        }

        return $this->render('membre/formMembre.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
            'pageName' => 'Formulaire',
            'editMode' => $membre->getId() !== null
        ]);
    }

    /**
     * @Route("/{id<[0-9]+>}", name="show", methods={"GET"})
     */
    public function show(Membre $membre): Response
    {
        return $this->render('membre/show.html.twig', [
            'membre' => $membre,
            'pageName' => $membre->getEmail(),
        ]);
    }

    // /**
    //  * @Route("/{id<[0-9]+>}/edit", name="edit", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, Membre $membre): Response
    // {
    //     $form = $this->createForm(MembreType::class, $membre);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $membre->setmodifiedAt(new \DateTimeImmutable);
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('membre_index');
    //     }

    //     return $this->render('membre/edit.html.twig', [
    //         'membre' => $membre,
    //         'form' => $form->createView(),
    //         'pageName' => 'Modifier',
    //     ]);
    // }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Membre $membre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($membre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('membre_index');
    }
}
