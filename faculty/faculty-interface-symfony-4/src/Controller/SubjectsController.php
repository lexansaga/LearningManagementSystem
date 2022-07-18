<?php

namespace App\Controller;

use App\Entity\FacultyLoads;
use App\Entity\Activities;
use App\Entity\CourseEnrolled;
use App\Entity\Students;
use App\Entity\ActivitiesSubmitted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Filesystem\Filesystem;
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
    public function createActivity(Request $request){
        return $this->render('subjects/createactivity.html.twig',[
            'id'=>$request->get('id'),
            'programclass'=>$request->get('programclass'),
            'coursename'=>$request->get('coursename')

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
    public function showActivityView($id){

        $subact = $this->getDoctrine()->getRepository(ActivitiesSubmitted::class)->find($id);
        $activity = $this->getDoctrine()->getRepository(Activities::class)->findBy(array('id'=>$subact->getActivityid()));
        $temp = array('id'=>$subact->getActivityid(),'activityname'=>$activity[0]->getActivityname(),'tasktype'=>$activity[0]->getTasktype(),'activitytype'=>$activity[0]->getActivitytype(),'quizquestions'=>$subact->getCorrectanswers(),'score'=>$subact->getScore());
        $allfiles = json_decode($subact->getFile());
        if($subact->getFile()!=null){
            
            $studentID = $subact->getStudentid();
            
            
        }
        
        return $this->render('subjects/viewactivity.html.twig', [
                'userid'=>$studentID,
                'id'=>$id,
                'activity'=>$temp,
                'subfiles'=>$allfiles
        ]);
    }

    public function retriveFile(Request $request){
        $finder = new Finder();
        
        
        
        $filename = $request->query->get("name");
        $filepath = $request->query->get("path");
        $id = $request->query->get("id");
        $log_directory = $this->getParameter('kernel.project_dir'). "\data\{$filepath}\{$id}";

        $finder->files()->in($log_directory);
        $foundFile;
        foreach($finder as $file){
            
            
            
            if($filename==$file->getFilename()){
                $foundFile = $file;
            }
        
            
            
        }
        
        
        
        $response = new BinaryFileResponse($foundFile->getPathname());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );
        
        return $response;

    }
    public function showSubmission($id){
        $activity = $this->getDoctrine()->getRepository(Activities::class)->find($id);
        $allActivities = $this->getDoctrine()->getRepository(ActivitiesSubmitted::class)->findBy(array('activityid'=>$id));

        $all = array();
        
        foreach($allActivities as $val){
            $stuID = $val->getStudentid();
            
            $stud = $this->getDoctrine()->getRepository(Students::class)->findBy(array('idnum'=>$stuID));
            $stuFname = $stud[0]->getFname();
            $stuMname = $stud[0]->getMname();
            $stuLname = $stud[0]->getLname();

            $studentname = $stuFname . $stuMname . $stuLname;
            array_push($all,array("fullname"=>$studentname,"studentID"=>$stuID,"score"=>$val->getScore(),"datesubmitted"=>$val->getTimestamp(),"id"=>$val->getId(),"correctanswers"=>$val->getCorrectanswers()));
            
        }
        return $this->render('subjects/subjectsubmission.html.twig', [
            'all'=>$all,
            'activity'=>$activity
        ]);
    }
    public function uploadModules(ManagerRegistry $doctrine,Request $request){
        $courseID = $request->request->get("id");
        $files = $request->files->all();
        $all = $doctrine
            ->getRepository(FacultyLoads::class)->find($courseID);
        $entityManager = $doctrine->getManager();
        if($files!=null){
            
            if (!file_exists($this->getParameter('kernel.project_dir') ."/data/modules/$courseID")) {
                mkdir($this->getParameter('kernel.project_dir') ."/data/modules/$courseID", 0777, true);
            }
            $index = 0;
            $tempArr = $all->getModules();
            if($tempArr==null){
                $tempArr = array();
            }
            foreach ($files as $file) {
                $filename = $request->request->get('filename'.$index);
                
                $target = $this->getParameter('kernel.project_dir') ."/data/modules/$courseID/$filename";
                array_push($tempArr,$filename);
                move_uploaded_file($file, $target);    
            
                $index++;
            }
            $all->setModules($tempArr);
        }
        
        $entityManager->flush();
        $response = new Response("Successful");
        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    }
    public function addPoints(ManagerRegistry $doctrine,Request $request){
        $json = $request->getContent();
        $entityManager = $doctrine->getManager();
        $myJson = json_decode($json);
        
        $subactivity = $entityManager->getRepository(ActivitiesSubmitted::class)->find($myJson->id);
        
        $subactivity->setScore($subactivity->getScore() + $myJson->score);
        $entityManager->flush();
        $response = new Response("Successful");
        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    }
    public function showClassroom($id){
        $userID = $this->getUser()->getIdnum();
        
        $classroom = $this->getDoctrine()
            ->getRepository(CourseEnrolled::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();            
        $allActivities = $this->getDoctrine()->getRepository(Activities::class)->findBy(array('ProgramClass'=>$classroom->getProgramClass(),'Course'=>$classroom->getCourse()));
        
        
        foreach($allActivities as $act){
            $subactivity = $entityManager->getRepository(ActivitiesSubmitted::class)->findBy(array('activityid'=>$act->getId()));
            $latestAct = $entityManager->getRepository(ActivitiesSubmitted::class)->findBy(array('activityid'=>$act->getId(),'isvalid'=>true));
            $act->setMaxattempt($act->getMaxattempt()-count($subactivity));
            if(count($latestAct) > 0 ){
                $act->setMaxScore($latestAct[0]->getScore());
            }
        }
        return $this->render('student/classroom.html.twig', [
            'id'=>$id,
            
            'classroom'=>$classroom,
            'all'=>$allActivities
        ]);
    }

    public function showClassroomModule($id){
        $userID = $this->getUser()->getIdnum();
        
        $classroom = $this->getDoctrine()
            ->getRepository(CourseEnrolled::class)->find($id);

        $allActivities = $this->getDoctrine()->getRepository(ActivitiesSubmitted::class)->findBy(array('studentid'=>$userID));
        
        $modules = $this->getDoctrine()->getRepository(FacultyLoads::class)->findBy(array('courseName'=>$classroom->getCourse()));
        
        return $this->render('student/classroom.html.twig', [
            'id'=>$id,
            'load'=>$modules[0],
            'classroom'=>$classroom,
            'all'=>$allActivities
        ]);
    }


    public function removeModule(ManagerRegistry $doctrine,Request $request){
        $entityManager = $doctrine->getManager();
        $id = $request->request->get('id');
        $filename = $request->request->get("filename");
        $curClass = 
            $doctrine->getRepository(FacultyLoads::class)
            ->find($id);
        
        $array = $curClass->getModules();
        $index = array_search($filename,$array);
        if($index !== FALSE){
            unset($array[$index]);
        }
        $curClass->setModules($array);
        $entityManager->flush();
        $target = $this->getParameter('kernel.project_dir') ."/data/modules/$id/$filename";
        $filesystem = new Filesystem();
        $filesystem->remove($target);
        
        $response = new Response("Successful");
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
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
        $course = $request->request->get('course');
        $programclass = $request->request->get('programclass');
        $tasktype = $request->request->get('tasktype');
        $description = $request->request->get('description');
        $maxattempt = $request->request->get('maxattempt');


        
        $facultyID = $request->request->get('facultyloadid');

        $files = $request->files->all();
        
        if($files!=null){
            
            if (!file_exists($this->getParameter('kernel.project_dir') ."/data/activities/$facultyID")) {
                mkdir($this->getParameter('kernel.project_dir') ."/data/activities/$facultyID", 0777, true);
            }
            $index = 0;
            $tempArr = array();
            foreach ($files as $file) {
                $filename = $request->request->get('filename'.$index);
                
                $target = $this->getParameter('kernel.project_dir') ."/data/activities/$facultyID/$filename";
                array_push($tempArr,$filename);
                move_uploaded_file($file, $target);    
            
                $index++;
            }
                
        }
        $deadline = $request->request->get('deadline');
        $maxScore = $request->request->get('maxscore');
        $activity = new Activities();
        
        $activity->setActivityname($actname);
        if($acttype=="Essay"){
            $activity->setAllowfileupload(true);
        }
        if($acttype=="Exam"){
            $myTimer = $request->request->get('timer');
            $dyObj = json_decode($myTimer);
            
             $activity->setTimer(array('hours'=>$dyObj->hours,'minutes'=>$dyObj->minutes,'seconds'=>$dyObj->seconds));
        }
        if($acttype=="Quiz"||$acttype=="Exam"){
            $activity->setQuestions(json_decode($questions));
        }
        if(isset($file)&&$acttype!="Quiz"){
            $activity->setFile(json_encode($tempArr));
        }
        $activity->setMaxattempt($maxattempt);
        $activity->setActivitytype($acttype);
        $activity->setTimestamp(new DateTime(date("Y-m-d H:i:s")));
        $activity->setFacultyloadId($facultyID);
        $activity->setMaxScore($maxScore);
        $activity->setTasktype($tasktype);
        $activity->setDescription($description);
        $activity->setDescription($description);
        $activity->setProgramClass($programclass);
        $activity->setCourse($course);
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
        $class = $request->get('programclass');
        
        $currentRoom = $this->getDoctrine()->getRepository(FacultyLoads::class)->find($id);
        
        
        $latestActivities = $this->getDoctrine()->getRepository(Activities::class)->findBy(array('facultyload_id' => $id));
        
        
        $tempArr = array();
        foreach($latestActivities as $act) {
            $studentActivities = $this->getDoctrine()->getRepository(ActivitiesSubmitted::class)->findBy(array('activityid' => $act->getId()));
            array_push($tempArr,$studentActivities);
            if($act->getFile()!=null){
                $act->setFile(json_decode($act->getFile()));
            }
            
        }
        return $this->render('subjects/view.html.twig', [
            'coursename'=>$coursename,
            'myid'=>$id,
            'modules'=>$currentRoom->getModules(),
            'programclass'=>$class,
            'allActivities'=>$latestActivities,
            'studentactivities'=> $tempArr
        ]);
    }

}
