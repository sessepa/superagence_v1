<?php
namespace App\Controller;

use App\Repository\PropertiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;


class HomeController extends AbstractController {
     /**
     * @var Environment
     */
    private $twig;

    public function __Construct(Environment $twig, ){
        $this->twig =$twig;
    }

    /**
     * @param PropertiRepository $repository
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(PropertiRepository $repository): Response{
         $properties= $repository->findLastest();
        return new Response( $this->twig->render('pages/home.html.twig',[
                                                       'properties'=>$properties
        ]));

    }
}