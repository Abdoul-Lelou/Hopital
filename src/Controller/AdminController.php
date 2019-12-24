<?php

namespace App\Controller;

use App\Entity\Medecin;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\Form\ServiceType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MedecinEditType;
use App\Repository\MedecinRepository;
use App\Doc\GenerateMatricule;
use App\Entity\Specialite;
use App\Form\SpecialiteType;
use App\Repository\SpecialiteRepository;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin.service.show")
     */
    public function showService(ServiceRepository $repository)
    {
        $service= new Service();
        //$service->setLibelle('Dermathologie');

        //$em= $this->getDoctrine()->getManager();
        $service=$repository->findAll();
        //$service=$repository->findOneByLibelle('Dermathologie');
        //$service=$repository->findByLib('DERMATHOLOGIE');
        //$service=$repository->dQl();
        
        //$service=$repository->getByservCond(1);  

       // $em->persist($service);
        //$em->clear();
        //$em->flush();

        return $this->render('admin/index.html.twig', [
            'services' => $service
            
        ]);
        
        // ...
    }

     /**
     * @Route("/admin/add", name="admin.service.add")
     */
    public function serviceAdd(Request $request)
    {
        $service = new Service();

        $form = $this->createForm(ServiceType::class, $service);

        
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($service);
        $entityManager->flush();

        return $this->redirectToRoute('admin.service.show');
    }

        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }


     /**
     * @Route("/admin/edit/{id}", name="admin.service.edit")
     */
    
    public function serviceEdit(Request $request,ServiceRepository $repository,$id)
    {
        
        $service=$repository->find($id);
        $form = $this->createForm(ServiceType::class, $service);

        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('admin.service.show');
        }

        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/admin/delete/{id}", name="admin.service.delete")
     */
    
    public function serviceDelete(Request $request,ServiceRepository $repository,$id)
    {
        
        $service=$repository->find($id);
        $form = $this->createForm(ServiceType::class, $service);

        
        $form->handleRequest($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($service);
        $entityManager->flush();

        return $this->redirectToRoute('admin.service.show');
    }

    /**
     * @Route("/admin/showMedecin", name="admin.medecin.show")
     */
    public function showMedecin(MedecinRepository $repository)
    {
        $medecin = new Medecin();
        
        $medecin=$repository->findAll();
       
        return $this->render('admin/showMedecin.html.twig', [
            'medecins'=> $medecin,
            
        ]);
    }

    /**
     *  @Route("/admin/addMedecin", name="admin.medecin.add")
     * 
     */
    public function medecinAdd(Request $request,MedecinRepository $repository)
    {
        $medecin = new Medecin();
        $generMat=new GenerateMatricule($repository);
        $form = $this->createForm(MedecinEditType::class, $medecin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $matricule=$generMat->matricule($medecin);
                $medecin->setMatricule($matricule);
                //dd($form->getData());
                $entityManager->persist($medecin);
                $entityManager->flush();

                return $this->redirectToRoute('admin.medecin.show');    
        }

            return $this->render('admin/formMedecin.html.twig', [
                'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("/admin/medecin/edit/{id<\d+>}", name="admin.medecin.edit")
     */
        
        public function editMedecin(Request $request, Medecin $medecin,$id,MedecinRepository $repository): Response
    {        
        $medecin=$repository->find($id);
        $service=new Service();
        $form = $this->createForm(MedecinEditType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.medecin.show');
        }
        dd($form->getData());

        return $this->render('admin/formMedecin.html.twig', [
            'medecin' => $medecin,
            'form' => $form->createView(),
            
        ]);
    }

    /**
     * @Route("/admin/medecin/delete/{id<\d+>}", name="admin.medecin.delete")
     */
        
    public function deleteMedecin(Request $request, Medecin $medecin,$id,MedecinRepository $repository): Response
    {        
        $medecin=$repository->find($id);
        $form = $this->createForm(MedecinEditType::class, $medecin);
        $form->handleRequest($request);

       
            $em=$this->getDoctrine()->getManager();
            $em->remove($medecin);
            $em->flush();

            return $this->redirectToRoute('admin.medecin.show');
        

    }

    /**
     * @Route("/admin/addSpecialite", name="admin.specialite.add")
     */
    public function specialiteAdd(Request $request)
    {
        $specialite = new Specialite();

        $form = $this->createForm(SpecialiteType::class, $specialite);

        
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($specialite);
        $entityManager->flush();

        return $this->redirectToRoute('admin.specialite.show');
    }

        return $this->render('admin/formSpecialite.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/specialite", name="admin.specialite.show")
     */
    public function showSpecialite(SpecialiteRepository $repository)
    {
        $specialite= new Specialite();
        
        $specialite=$repository->findAll();
        return $this->render('admin/showSpecialite.html.twig', [
            'specialites' => $specialite
            
        ]);
        
    }

    /**
     * @Route("/admin/specialite/edit/{id<\d+>}", name="admin.specialite.edit")
     */
        
    public function editSpecialite(Request $request, Specialite $specialite,$id,SpecialiteRepository $repository): Response
    {        
        $specialite=$repository->find($id);
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.specialite.show');
        }

        return $this->render('admin/formSpecialite.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/specialite/delete/{id<\d+>}", name="admin.specialite.delete")
     */
        
    public function deleteSpecialite(Request $request, Specialite $specialite,$id,SpecialiteRepository $repository): Response
    {        
        $specialite=$repository->find($id);
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);

       
            $em=$this->getDoctrine()->getManager();
            $em->remove($specialite);
            $em->flush();

            return $this->redirectToRoute('admin.specialite.show');
        

    }

}
