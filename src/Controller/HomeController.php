<?php
namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method render(string $string, array $array)
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(EntityManagerInterface $em)
    {
        $postsManager = $em->getRepository(Post::class);
        $posts = $postsManager->findAll();

        return $this->render('/home.html.twig', [
            'posts' => $posts,
        ]);
    }

}
