<?php
namespace FaimfonyBundle\Controller;

use FaimfonyBundle\Entity\Meal;
use FaimfonyBundle\Entity\Restaurant;
use FaimfonyBundle\Form\MealType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class MealController extends Controller
{

    /**
     * @Route("meal/create/{id}", name="add_meal")
     */

    public function mealCreateAction(Request $request, $id)
    {

        $restauRepository = $this->getDoctrine()->getRepository(Restaurant::class);
        $restau = $restauRepository->find($id);

        $meal = new Meal();

        $form = $this->CreateForm(MealType::class, $meal);
        $form->handleRequest($request);
        $meal->setRestaurant($restau);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($meal);
            $em->flush();
            return $this->redirect($this->generateUrl('profil_restau', array('user'=> $this->getUser(), 'id'=>$restau->getId())));
        }
        return $this->render('FaimfonyBundle:Default:mealFormulaire.html.twig', array('user'=> $this->getUser(), 'form' => $form->createView()
        ));
    }

    /**
     * @Route("meal/edit/{id}", name="edit_meal")
     */
    public function mealEditAction(Request $request, $id){

        $meal = $this->getDoctrine()->getRepository(Meal::class)->find($id);
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($meal);
            $em->flush();
            return $this->redirect($this->generateUrl('edit_meal', array('user'=> $this->getUser(),'id'=>$meal->getId())));
        }
        return $this->render('FaimfonyBundle:Default:editMeal.html.twig', array('user'=> $this->getUser(),'meal'=>$meal ,'form' => $form->createView()
        ));
    }

    /**
     * @Route("meal/delete/{id}", name="delete_meal")
     */
    public function mealDeleteAction(Request $request, $id){
        $session = new Session();
        $user = $this->getUser();
        $meal = $this->getDoctrine()->getRepository(Meal::class)->find($id);
        if($user == $meal->getRestaurant()->getUser()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($meal);
            $em->flush();
            $session->getFlashBag()->add('notice', 'Votre plat a été supprimé');
            return $this->redirect($this->generateUrl('user_profil'));
        }
        else{
            return $this->redirect($this->generateUrl('user_profil'));
        }
    }

    /**
     * @Route("/add-favorite/{id}", name="add_favorite")
     */
    public function addMealFavorite(Request $request, $id){
        $session = new Session();
        $meal = $this->getDoctrine()->getRepository(Meal::class)->find($id);
        $user = $this->getUser();
        $user->addFavorite($meal);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $session->getFlashBag()->add('notice', 'Le plat à été ajouté aux favoris!');
        return $this->redirect($this->generateUrl('user_profil'));
    }

    /**
     * @Route("/delete-favorite/{id}", name="delete_favorite")
     */
    public function deleteMealFavorite(Request $request, $id){
        $session = new Session();
        $meal = $this->getDoctrine()->getRepository(Meal::class)->find($id);
        $user = $this->getUser();
        $user->removeFavorite($meal);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $session->getFlashBag()->add('notice', 'Le plat à été supprimé des favoris!');
        return $this->redirect($this->generateUrl('user_profil'));
    }


}
