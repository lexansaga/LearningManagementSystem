<?php

namespace App\Controller;

use App\Entity\FacultyLoads;
use App\Entity\Activities;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use \Datetime;

class SubjectsController extends AbstractController
{
    #[Route('/subjects', name: 'subjects')]
    public function index(): Response
    {
        $user = $this->getUser()->getFullname();

        $all = $this->getDoctrine()
            ->getRepository(FacultyLoads::class)->findAll();
        
        return $this->render('subjects/index.html.twig', [
            'controller_name' => 'SubjectsController',
            'subjects'=>$all
        ]);
    }


   

    public function addActivity(ManagerRegistry $doctrine,Request $request){
        $entityManager = $doctrine->getManager();

        $activity = new Activities();
        $activity->setActivityname("FirstAct");
        $activity->setQuestions(["Question1"=>"RUNNING UP THAT HILL"]);
        $activity->setTimestamp( new DateTime('2000-01-01'));
        $activity->setFacultyloadId(14);
        $activity->setActivityDeadline(new DateTime('2000-01-01'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($activity);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        $response = new Response(json_encode(array('name' => "HUEHUE")));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
  /**
     * @Route("/subjects/{id}", name="view")
     */
    public function view(int $id, Request $request): Response
    {
        $course = $this->getDoctrine()
            ->getRepository(FacultyLoads::class)
            ->find($id);
        
        $course = $this->getDoctrine()
            ->getRepository(FacultyLoads::class)
            ->find($id);

        $search1 = $request->get('course');
        
        $latestActivities = $this->getDoctrine()->getRepository(Activities::class)->find($id);

     
        
        return $this->render('subjects/view.html.twig', [
            'course'=>$course,
            'allActivities'=>$latestActivities
        ]);
    }

}
