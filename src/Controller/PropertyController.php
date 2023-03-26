<?php
namespace App\Controller;


use App\Entity\Properti;
use App\Entity\PropertiSearch;
use App\Form\PropertiSearchType;
use App\Repository\PropertiRepository;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;


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

    public function index(PaginatorInterface $paginator, Request $request): Response {

        //Mise en place de système de recherche:
        // NB: Avant de faire les etapes 1,2,3, il faut au préalable créer:
        // Dans Entity : => PropertiSearch
        // Générer le formulaire via la commande: php bin/console make:form

        //1 - Créer une entité (ici une classe non reliée à la bd )qui va représenter notre recherche
              $search = new PropertiSearch();

        //2 - Créer un formulaire de saisie pour la recherche
             $form= $this->createForm(PropertiSearchType::class,$search);

        //3- Gérer le traitement dans le contrôleur
            $form->handleRequest($request);

      //On recupère l'ensemble de nos biens
      $properties = $paginator->paginate(
                                          $this->repository->findAllVisibleQuery($search),
                                          $request->query->getInt('page', 1),
                                          12 /* limite par page*/
      );
       return $this->render('property/index.html.twig',
                      [
                        'current_menu' => 'properties',
                          'properties' => $properties,
                          'form'      => $form->createView()  //4 - Envoyer à la vue le formulaire de recherche
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