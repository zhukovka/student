<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenka
 * Date: 2/3/16
 * Time: 00:59
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends Controller
{
    /**
     * @Route("/create")
     */
    public function createAction()
    {
        $post = new Post();
        $post->setDate(new \DateTime("11-11-1990"));
        $post->setName("Бла бьла");
        $post->setContent("Bla bla bla ололол");

        $em = $this->getDoctrine()->getManager();

        $em->persist($post);
        $em->flush();

        return new Response('Created product id ' . $post->getId());
    }
}