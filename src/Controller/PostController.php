<?php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method render(string $string, array $array)
 */
class PostController extends AbstractController
{

    /**
     * @Route("/posts",name="indexPost")
     */
    public function index(EntityManagerInterface $em)
    {
        $postsManager = $em->getRepository(Post::class);
        $posts = $postsManager->findAll();

        return $this->render('/posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/posts/new", name="newPost")
     */
    public function create(EntityManagerInterface $em, Request $request)
    {
        $usr = $this->getUser();
        $post = new Post();
        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('content', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Publier'])
            ->getForm();


        $form->handleRequest($request);
        $post->setCreatedAt(new \DateTime());
        $post->setIsDeleted(false);
        $post->setIsPublished(true);
        $post->setAuthor($usr);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();


            return $this->redirectToRoute('index');
        }

        return $this->render('/posts/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/posts/{post}", name="showPost")
     */
    public function show(Post $post, EntityManagerInterface $em, Request $request)
    {
        $usr= $this->getUser();
        $commentRepo = $em->getRepository(Comment::class);
        $comments = $commentRepo->findBy(['post' => $post, 'isDeleted' => false]);

        $comment = new Comment();
        $form = $this->createFormBuilder($comment)
            ->add('content', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Publier'])
            ->getForm();

        $form->handleRequest($request);
        $comment->setCreatedAt(new \DateTime());
        $comment->setIsDeleted(false);
        $comment->setPost($post);
        $comment->setAuthor($usr);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $comment = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
        }
        return $this->render('/posts/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'comments' => $comments,
            'user' => $usr
        ]);

    }
}
