<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Person;
use AppBundle\Form\PersonType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Response;


class SuperController extends Controller
{
    /**
     * @Route("/super", name="super")
     */
    public function superAction()
    {
        $person = new Person();
        $form = $this->createForm(new PersonType(),$person);

        $request = $this->get('request');
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $email = $form->get('email')->getData();
                $fullname = $form->get('fullname')->getData();

                $person->setEmail($email);
                $person->setFullname($fullname);

                $em = $this->getDoctrine()->getManager();
                $em->persist($person);
                $em->flush();

                return new Response('Person '.$fullname.'/'.$email.'Created');
            }
            return $this->render('default/super.html.twig', array('form'=>$form->createView()));
        }

        return $this->render('default/super.html.twig', array('form'=>$form->createView()));
    }
}
