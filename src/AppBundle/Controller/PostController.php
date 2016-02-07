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

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends Controller
{
    /**
     * @Route("/articles", name="articles")
     */
    public function showAction()
    {
        $post = $this->getDoctrine()
        ->getRepository('AppBundle:Post')
        ->findAll();
        return $this->render('post/index.html.twig', array('articles' => $post, 'active' => 'articles'));
    }
    /**
     * @Route("/create")
     */
    public function createAction(Request $request)
    {
        $post = new Post();
        $post->setDate(new \DateTime("today"));
        $post->setName("Бла бьла");
        $post->setContent("Bla bla bla ололол");
        $form = $this->createFormBuilder($post)
        ->add('name', TextType::class)
        ->add('content', TextareaType::class)
        ->add('date', DateType::class)
        ->add('save', SubmitType::class, array('label' => 'Create Task'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $em = $this->getDoctrine()->getManager();

            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('post_success');
        }

//
        return $this->render('post/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @return Response
     * @Route("/postsuccess", name="post_success")
     */
    public function postSuccessAction()
    {
        return new Response('Created post');
    }
}