<?php
/**
 * Created by PhpStorm.
 * User: lenka
 * Date: 2/2/16
 * Time: 23:05
 */

namespace AppBundle\Controller;

use AppBundle\Entity\MenuItem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function showAction(Request $request)
    {

        return $this->render('index.html.twig', array('active' => 'home'));
    }

    /**
     * @Route("/genus/{genusName}/notes")
     * @Method("GET")
     */
    public function getNotesAction($genusName)
    {
        $notes = [
            ['id' => 1, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Octopus asked me a riddle, outsmarted me', 'date' => 'Dec. 10, 2015'],
            ['id' => 2, 'username' => 'AquaWeaver', 'avatarUri' => '/images/ryan.jpeg', 'note' => 'I counted 8 legs... as they wrapped around me', 'date' => 'Dec. 1, 2015'],
            ['id' => 3, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Inked!', 'date' => 'Aug. 20, 2015'],
        ];
        $data = [
            'notes' => $notes
        ];
        return new Response(json_encode($data));
    }

    /**
     * @Route("/add/menu-item", name="menu_item")
     */
    public function createAction(Request $request)
    {
        $item = new MenuItem();
        $form = $this->createFormBuilder($item)
        ->add('alias', TextType::class)
        ->add('name', TextType::class)
        ->add('save', SubmitType::class, array('label' => 'Add item'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $em = $this->getDoctrine()->getManager();

            $em->persist($item);
            $em->flush();
            return $this->redirectToRoute('post_success');
        }

//
        return $this->render('menu/new.html.twig', array(
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