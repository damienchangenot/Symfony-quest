<?php


namespace App\Controller;


use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProgramController
 * @package App\Controller
 * @Route ("/programs", name="program_")
 */
class  ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('program/index.html.twig', ['programs' => $programs]);
    }

    /**
     * The controller for the category add form
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request) : Response
    {
        $program = new Program();

        $form = $this->createForm(ProgramType::class, $program);
        // Render the form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($program);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('program_index');
        }
        return $this->render('program/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/", methods={"GET"},requirements={"id"="\d+"}, name="show")
     * @param Program $program
     * @return Response
     */
    public function show(Program $program): Response
    {
        if(!$program){
            throw $this->createNotFoundException(
                'No program with id : '.$program.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    /**
     * @param Program $program
     * @param Season $season
     * @return Response
     * @Route("/{program}/seasons/{season}", name="season_show")
     */
    public function showBySeason(Program $program, Season $season): Response
    {
        if(!$program){
            throw $this->createNotFoundException(
                'No program with id : '.$program.' found in program\'s table.'
            );
        }

        if (!$season) {
            throw $this->createNotFoundException(
                'No season with number : ' .$season. ' found in season\'s table.'
            );
        }

        return $this->render("program/season_show.html.twig", ['program' => $program, 'season' => $season]);
    }

    /**
     * @param Program $program
     * @param Season $season
     * @param Episode $episode
     * @return Response
     * @Route ("/{program}/seasons/{season}/episodes/{episode}", name="program_episode_show")
     */
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
    return $this->render("program/episode_show.html.twig", [ 'program'=>$program, 'season'=>$season, 'episode'=>$episode]);
    }
}