<?php

namespace FiThnitekBundle\Controller;

use FiThnitekBundle\Entity\Category;
use FiThnitekBundle\Form\CategorieType;
use FiThnitekBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function addCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, array("label"=>"Ajouter"));
        $form = $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute("fi_thnitek_listCategory");
        }
        return $this->render('@FiThnitek/Category/AddCategory.html.twig', array ("f"=>$form->createView()));
    }

    public function modifyCategoryAction(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository(Category:: class)->find($id);
        $form = $this->createForm(CategoryType::class, $category, array("label"=>"Modifier"));
        $form = $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute("fi_thnitek_listCategory");
        }
        return $this->render('@FiThnitek/Category/ModifyCategory.html.twig', array ("f"=>$form->createView()));
    }

    public function deleteCategoryAction($id)
    {
        $cat = $this->getDoctrine()->getRepository(Category:: class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($cat);
        $em->flush();
        return $this->redirectToRoute("fi_thnitek_listCategory");
    }

    public function ListCategoryAction()
    {
        $mod = $this->getDoctrine()->getRepository(Category:: class)->findAll();
        return $this->render('@FiThnitek/Category/ListCategory.html.twig', array('table'=>$mod));
    }


}
