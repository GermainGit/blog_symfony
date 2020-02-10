<?php
namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method render(string $string, array $array)
 */
class PostController extends AbstractController
{

    /**
     * @Route("/posts")
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
     * @Route("/posts/new")
     */
    public function create(EntityManagerInterface $em, \Symfony\Component\HttpFoundation\Request $request)
    {
        $post = new Post();
        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('content', TextType::class)
            ->add('Author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
            ])
            ->add('save', SubmitType::class, ['label' => 'Publier'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();


            return $this->redirectToRoute('task_success');
        }

        return $this->render('/posts/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
