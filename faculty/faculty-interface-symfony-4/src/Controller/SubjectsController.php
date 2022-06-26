<?php

namespace App\Controller;

use App\Entity\FacultyLoads;
use App\Entity\Activities;
use App\Entity\CourseEnrolled;
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
        $facultyID = $this->getUser()->getFacultyId();

        $all = $this->getDoctrine()
            ->getRepository(FacultyLoads::class)->findBy(array('facultyId' => $facultyID));
        
        return $this->render('subjects/index.html.twig', [
            'controller_name' => 'SubjectsController',
            'subjects'=>$all
        ]);
    }

    public function showClassrooms(){
        $userID = $this->getUser()->getIdnum();
        
        $all = $this->getDoctrine()
            ->getRepository(CourseEnrolled::class)->findBy(array('idnum' => $userID));

        return $this->render('student/classrooms.html.twig', [
            'all'=>$all
        ]);
    }

   public function removeActivity(ManagerRegistry $doctrine,Request $request){

        $id = json_decode($request->getContent())->id;
        $entityManager = $doctrine->getManager();
        $entite = $entityManager->getRepository(Activities::class)->find($id);

      
        $entityManager->remove($entite);

        
        $entityManager->flush();
        $response = new Response("Successful");
        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
        
   }

    public function addActivity(ManagerRegistry $doctrine,Request $request){
        
        $entityManager = $doctrine->getManager();
        $actname = $request->request->get('activityname');
        
        $acttype = $request->request->get('activitytype');
        $questions = $request->request->get('questions');
        $file = $request->files->get('file');
        if($file!=null){

            $filename = $request->request->get('filename');
            $target = $this->getParameter('kernel.project_dir') ."/data/activities/$filename";
            move_uploaded_file($file, $target);
        }
        $facultyID = $request->request->get('facultyloadid');
        $deadline = $request->request->get('deadline');
        $maxScore = $request->request->get('maxscore');
        $activity = new Activities();
        $activity->setActivityname($actname);
        if($acttype=="Quiz"){
            $activity->setQuestions(json_decode($questions));
        }
        if(isset($file)&&$acttype!="Quiz"){
            $activity->setFile($filename);
        }
        $activity->setActivitytype($acttype);
        $activity->setTimestamp(new DateTime(date("Y-m-d H:i:s")));
        $activity->setFacultyloadId($facultyID);
        $activity->setMaxScore($maxScore);
        $activity->setActivityDeadline(new DateTime($deadline));

        
        $entityManager->persist($activity);

        // // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        
        $response = new Response(json_encode($activity));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
  /**
     * @Route("/subjects/{id}", name="view")
     */
    public function view(Request $request): Response
    {
        
        $coursename = $request->get('course');
        $id = $request->get('id');
        
        
        
        
        $latestActivities = $this->getDoctrine()->getRepository(Activities::class)->findBy(array('facultyload_id' => $id));
        
        
        
        foreach($latestActivities as $act) {
            if($act->getFile()!=null){
                $curFile = stream_get_contents($act->getFile());
                
                $act->setFile(base64_encode($curFile));
            }
            
        }
        return $this->render('subjects/view.html.twig', [
            'coursename'=>$coursename,
            'myid'=>$id,
            'allActivities'=>$latestActivities,
            
        ]);
    }

}
