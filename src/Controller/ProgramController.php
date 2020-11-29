<?php


namespace App\Controller;


use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/{id}/", methods={"GET"},requirements={"id"="\d+"}, name="show")
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);

        if(!$program){
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    /**
     * @param int $programId
     * @param int $seasonId
     * @Route("/{programId}/seasons/{seasonId}", name="season_show")
     * @return Response
     */
    public function showBySeason(int $programId, int $seasonId): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' =>$programId]);

        if(!$program){
            throw $this->createNotFoundException(
                'No program with id : '.$programId.' found in program\'s table.'
            );
        }
        $season =$this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(['program' => $programId,'number' => $seasonId]);

        if (!$season) {
            throw $this->createNotFoundException(
                'No season with number : ' . $seasonId . ' found in season\'s table.'
            );
        }

        return $this->render("program/season_show.html.twig", ['program' => $program, 'season' => $season[0]]);
    }
}