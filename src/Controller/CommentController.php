<?php
namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method render(string $string, array $array)
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/comments")
     */
    public function index(EntityManagerInterface $em)
    {
        $commentsManager = $em->getRepository(Comment::class);
        $comments = $commentsManager->findAll();

        return $this->render('/comments/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/comments/show/$id")
     */
    public function show()
    {
        $comments = ['lets','try','a','test'];

        return $this->render('/comments/index.html.twig', [
            'comments' => $comments,
        ]);
    }

}
