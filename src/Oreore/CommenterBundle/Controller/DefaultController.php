<?php

namespace Oreore\CommenterBundle\Controller;

use Oreore\CommenterBundle\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $comment = new Comment();

        $form = $this->createFormBuilder($comment)
            ->add('content', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Comment'])
            ->getForm();

        $repository = $this->getDoctrine()
            ->getRepository('OreoreCommenterBundle:Comment');
        $comments = $repository->findAll();

        return [
           'form' => $form->createView(),
           'comments' => $comments
        ];
    }

    /**
     * @Route("/")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $data = $request->request->all();
        $content = $data['form']['content'];

        $comment = new Comment();
        $comment->setContent($content);

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/destroy", name="destroy")
     */
    public function destroyAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('OreoreCommenterBundle:Comment');
        $comments = $repository->findAll();

        $em = $this->getDoctrine()->getManager();
        foreach ($comments as $key => $comment) {
            $em->remove($comment);
        }
        $em->flush();

        return $this->redirectToRoute('index');
    }
}
