<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Pizza;
use App\Entity\Ingredient;
use App\Entity\commande;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DataType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
  
    /**
 * @Route("/",name="home")
 * @Template()
 */
public function indexAction()
{
    return [];
}
  


    /**
     * @Route("/pizzas", name="pizzas_list")
     * @Template()
     */
    public function pizzasAction()
    {  
        $em = $this->getDoctrine()->getManager();
        
        $pizzas = $em->getRepository(Pizza::class)
        ->findAll();
     
        return $this->render('default/pizzas.html.twig', ['pizzas' => $pizzas]);
        
    }
        /**
     * @Route("/ingredients", name="ingredients_list")
     * @Template()
     */
    public function ingredientsAction()
    {  
        $em = $this->getDoctrine()->getManager();
        
        $ingredients = $em->getRepository(Ingredient::class)
        ->findAll();
     
        return $this->render('default/ingredients.html.twig', ['ingredients' => $ingredients]);
        
    }
    /**
     * @Route("ajouter",name="ajouter")
     */

    public function register_pizza(Request $request)
    {
        $pizza =new Pizza();


        $form= $this->createFormBuilder($pizza)
        ->add('name',TextType::class)
        ->add('description',TextType::class)
        ->add('price',TextType::class)
        ->add('Register',SubmitType::class,array('label'=>'create pizza'))
        ->getForm();
       // die("sub");

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
          

           $nom = $form['name']->getData();
           $description = $form['description']->getData();
           $prix = $form['price']->getData();
          
           $pizza->setPrice($prix);
           $pizza->setName($nom);
           $pizza->setDescription($description);

           $em=$this->getDoctrine()->getManager();

           $em->persist($pizza);
           $em->flush();
   
   
       }


        return $this->render('default/pizza_form.html.twig',array('form'=>$form->createView(),
       ));
    }



    
/**
     * @Route("/pizzas", name="pizzas_list")
     * @Template()
     */
    /*
    public function insertPizzasAction() {
        $em = $this->get('doctrine')->getManager();
        $mozarella = new Ingredient;
        $mozarella->setName('Mozarella');
        $parmesan = new Ingredient;
        $parmesan->setName('Parmesan');
        $quatreFromages = new Pizza;
        $quatreFromages
            ->setName('4 fromages')
            ->setPrice(32.2)
            ->setDescription('Pour les fans de fromage')
            ;   
        $quatreFromages->addIngredient($mozarella);
        $quatreFromages->addIngredient($parmesan);
        $em->persist($quatreFromages);
        $em->persist($mozarella);
        $em->persist($parmesan);
        $em->flush();

        return new Response('Pizzas créées');
    }
    */
 

}
