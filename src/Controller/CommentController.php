<?php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method render(string $string, array $array)
 */
class CommentController extends AbstractController
{
    /**
     * @Route("comment/delete/{comment}", name="delete_comment")
     */
    public function delete(Comment $comment, Request $request, EntityManagerInterface $em){
        $comment->setIsDeleted(true);
        $em->flush();
        return  $this->redirectToRoute('showPost', ['post' => $comment->getPost()->getId()]);
    }

}
