<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\commande;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DataType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;





class CommandeController extends Controller
{
     
        /**
     * @Route("/commande_list", name="commande_list")
     * @Template()
     */
    public function commande_list()
    {  
        $em = $this->getDoctrine()->getManager();
        
        $commandes = $em->getRepository(commande::class)
        ->findAll();
     
        return $this->render('default/commmande.html.twig', ['commandes' => $commandes]);
        
    }

    /**
     * @Route("ajouter_commande",name="ajouter_commande")
     */

    public function register_comm(Request $request)
    {
        $comm =new commande();


        $form= $this->createFormBuilder($comm)
        ->add('adresse',TextType::class)
        ->add('nom',TextType::class)
        ->add('numero',TextType::class)
        ->add('Register',SubmitType::class,array('label'=>'Ajouter Commande'))
        ->getForm();
       

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
          

           $adresse = $form['adresse']->getData();
           $nom = $form['nom']->getData();
           $numero = $form['numero']->getData();
          
           $comm->setAdresse($adresse);
           $comm->setNom($nom);
           $comm->setNumero($numero);

           $em=$this->getDoctrine()->getManager();

           $em->persist($comm);
           $em->flush();
   
   
       }

        return $this->render('default/add_com.html.twig',array('form'=>$form->createView(),

       ));
    }





}
