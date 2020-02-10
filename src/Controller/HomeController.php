<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method render(string $string, array $array)
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {

        return $this->render('/home.html.twig', []);
    }

}
