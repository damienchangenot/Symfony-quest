<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route ("/categories", name="category_")
 * @return Response
 */
class CategoryController extends AbstractController
{
    /**
     * @Route ("/", name="index")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/index.html.twig', ['categories' => $categories]);
    }

    /**
     * @param string $categoryName
     * @Route ("/{categoryName}", name="show")
     */
    public function  show(string $categoryName)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name'=> $categoryName]);

        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' =>$category] ,['id'=> 'DESC'],3);

        if (!$categoryName){
            throw $this->createNotFoundException(
        'No category with id : '.$categoryName.' found in categorie\'s table.');
        }

        return $this->render('category/show.html.twig', ['programs' => $programs]);
    }
}