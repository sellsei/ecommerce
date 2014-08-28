<?php

namespace Sellsei\EcommerceCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SellseiEcommerceCoreBundle:Default:index.html.twig', array());
    }

    public function homeAction()
    {
        return $this->render('SellseiEcommerceCoreBundle:Default:home.html.twig', array());
    }
}
