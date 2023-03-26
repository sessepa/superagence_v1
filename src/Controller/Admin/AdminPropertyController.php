<?php
namespace App\Controller\Admin;
use App\Controller\PropertyController;
use App\Entity\Properti;
use App\Form\PropertiType;
use App\Repository\PropertiRepository;
use Doctrine\ORM\EntityManagerInterface;
use  Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;





class AdminPropertyController extends AbstractController{
    /**
     * @var PropertiRepository
     */
    private $repository;

    private $em;

    /**
     * @param PropertiRepository $repository
     */
    public function __construct(PropertiRepository $repository, EntityManagerInterface $em){
       $this->repository = $repository;
       $this->em = $em;
    }

    /**
     * Permet d'afficher les biens non vendus
     * @return Response
     */
    public function index() {
      $properties = $this->repository->findAll();
      return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * Permet de créer un nouveau bien
     * @return void
     */
     public function new(Request $request){

        $properti = new Properti();

        $form = $this->createForm(PropertiType::class,$properti);

         //Gérer la requête lors qu'on clique sur le bouton ajouter
         $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid()){
             $this->em->persist($properti);  //Car $properti est crée de manière manuelle et doc pas suivi par entityManager
             $this->em->flush();
             //Message de confirmation
             $this->addFlash('success','Bien ajouté ave succès');
             return $this->redirectToRoute('admin.property.index');
         }
         return $this->render('admin/property/new.html.twig', [
                             'properti'=> $properti,
                             'form'=>$form->createView()
                 ]);
     }

    /**
     * Permet d'éditer un bien
     * @param Properti $properti
     * @param Request $request
     * @return Response
     */
    public function edit(Properti $properti, Request $request){

        $form = $this->createForm(PropertiType::class,$properti);

        //Gérer la requête lors qu'on clique sur le bouton editer
        $form->handleRequest($request);  // Vérifie si au moins un champ du formulaire a été maj
        //Tester si le formulaire a été envoyé et s'il est valide ?
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();

            //Message de confirmation
            $this->addFlash('success','Bien modifié ave succès');
            //Redirection vers la liste des biens
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/edit.html.twig', [
            'properti'=> $properti,
            'form'=>$form->createView()
        ]);
    }

    /**
     * Pour supprimer un bien
     * @param Properti $properti
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
     public function delete(Properti $properti, Request $request){
        //Gestion de la validation d'un token
       if($this->isCsrfTokenValid('delete' .$properti->getId(), $request->get('_token'))){
          $this->em->remove($properti);
          $this->em->flush();
           //Message de confirmation
           $this->addFlash('success','Bien supprimé ave succès');
           return new Response('Suppression');
      }
        return $this->redirectToRoute('admin.property.index');
    }
}