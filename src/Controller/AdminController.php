<?php


namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function dashboard()
    {

       return $this->render('/admin/dashboard.html.twig');
    }



}