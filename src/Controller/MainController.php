<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index():Response
    {
        return $this->render('main/index.html.twig', [
            'pageName' => 'Bienvenue sur AnimalSitter',
        ]);
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription():Response
    {
        return $this->render('main/inscription.html.twig', [
            'pageName' => 'Gardien : Guide Complet',
        ]);
    }

    /**
     * @Route("/presentation", name="presentation")
     */
    public function presentation():Response
    {
        return $this->render('main/presentation.html.twig', [
            'pageName' => 'Le pet-sitting, comment ça marche ? ',
        ]);
    }

    /**
     * @Route("/tarif", name="tarif")
     */
    public function tarif():Response
    {
        return $this->render('main/tarif.html.twig', [
            'pageName' => 'Profitez de nos services en',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact():Response
    {
        return $this->render('main/contact.html.twig', [
            'pageName' => 'Contactez-nous',
        ]);
    }
}
