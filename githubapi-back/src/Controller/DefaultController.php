<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $form = $this->createFormBuilder([])
            ->setAction($this->generateUrl('gh_user_request'))
            ->add('gh_username', TextType::class)
            ->add('send', SubmitType::class)
            ->getForm();
        return $this->render('base.html.twig', array(
            'form' => $form->createView(),
            'repositories' => []
        ));
    }


    /**
     * @Route("/", name="gh_user_request")
     * @Method({"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function researchAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('gh_user_request'))
            ->add('gh_username', TextType::class)
            ->add('send', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        $data = $form->getData();

        dump($data['gh_username']);

        return $this->render('base.html.twig', array(
            'form' => $form->createView(),
            'repositories' => []
        ));
    }
}