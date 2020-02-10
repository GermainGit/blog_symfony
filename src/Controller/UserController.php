<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method render(string $string, array $array)
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users")
     */
    public function index(EntityManagerInterface $em)
    {
        $usersManager = $em->getRepository(User::class);
        $users = $usersManager->findAll();

        return $this->render('/users/index.html.twig', [
            'users' => $users,
        ]);
    }

}
