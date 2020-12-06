<?php

namespace App\Controller;

use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ActorController
 * @package App\Controller
 * @Route("/actors", name="actors_")
 */
class ActorController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $actors = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findAll();

        return $this->render('actors/index.html.twig', ['actors'=>$actors]);
    }
    /**
     * @param Actor $actor
     * @return Response
     * @Route("/{id}", name="show")
     */
    public function show(Actor $actor): Response
    {
        return $this->render('actors/show.html.twig',['actor'=> $actor] );
    }

}