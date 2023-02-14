<?php
namespace App\Controller;


use App\Entity\Properti;
use App\Repository\PropertiRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PropertyController extends AbstractController {

    private $repository;


    /**
     * Autowire : Injection de dépendance
     * @param PropertiRepository $repository
     */
    public function __construct(PropertiRepository $repository){
        $this->repository = $repository;

    }


    /**
     *
     * @return Response
     */

    public function index(): Response {

      $properti = $this->repository->findAllVisible();
       return $this->render('property/index.html.twig',
                      [
                        'current_menu' => 'properties'
                  ]);
    }
//     /**
//     *
//     * Methode 1: Passer en parametres le $slug et le $id
//     * $slug : recupere le title
//     * $id : recupre le id
//     * @return Response
//     */
//    public function show($slug, $id): Response{
//        $properti =$this->repository->find($id);
//        return $this->render('property/show.html.twig',[
//                'properti'=> $properti,
//                'current_menu' => 'properties'
//        ]);
//    }




    /**
     * Methode 2: Utilisation de l'injection
     * @param Properti $properti
     * @param string $slug
     * @return Response
     */
    public function show(Properti $properti, string $slug): Response{

         if($properti->getSlug() !== $slug){
            return $this->redirectToRoute('property.show',
                [
                 'id'=> $properti->getId(),
                 'slug' => $properti->getSlug()
             ], 301);
        }
          return $this->render('property/show.html.twig',[
            'properti'=> $properti,
            'current_menu' => 'properties'
        ]);
    }
}