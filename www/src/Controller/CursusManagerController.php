<?php

namespace App\Controller;

use App\Form\PathType;
use App\Form\ProjectType;
use App\Form\CategoryType;
use App\Form\CertificateType;
use App\Repository\PathRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PathProjectRepository;
use App\Repository\PathCategoryRepository;
use App\Repository\PathCertificateRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CursusManagerController extends AbstractController
{

    private $entitymanager;

    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entitymanager = $entitymanager;
    }


    /**
     * @Route("/cursus", name="cursus_manager")
     */
    public function index(PathCategoryRepository $category, PathRepository $path, PathProjectRepository $project, PathCertificateRepository $certificat): Response
    {


        // CATEGORY MANAGER
        $category = $category->findBy(array(), array('id' => 'ASC'), 8, 0);

        // CERTIFICAT LEVEL MANAGER 
        $certificat = $certificat->findBy(array(), array('id' => 'ASC'), 8, 0);

        // PATH MANAGER
        $path = $path->findBy(array(), array('id' => 'ASC'), 8, 0);

        // PROJECT MANAGER 
        $project = $project->findBy(array(), array('id' => 'ASC'), 8, 0);


        return $this->render('cursus_manager/index.html.twig', [
            'projects' => $project,
            'paths' => $path,
            'categorys' => $category,
            'certificats' => $certificat,
        ]);
    }

    //////////
    // PATH MANAGER
    //////////

    /**
     * @Route("/cursus/add/path", name="cursus_add_path")
     */
    public function addPath(Request $request): Response
    {
        $form = $this->createForm(PathType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entitymanager->persist($form->getData());
            $this->entitymanager->flush();
            $this->addFlash('success', 'Your path Is added !');
            $this->redirectToRoute('cursus_manager');
        }

        return $this->render('cursus_manager/add_path.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/cursus/edit/path/{id}", name="cursus_edit_path")
     */
    public function editPath(Request $request, PathRepository $path, int $id): Response
    {
        $path = $path->findBy(['id' => $id]);

        if (empty($path)) {
            $this->addFlash('error', 'Your path dont exist!');
            return $this->redirectToRoute('cursus_manager');
        }

        $form = $this->createForm(PathType::class, $path[0]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entitymanager->persist($form->getData());
            $this->entitymanager->flush();
            $this->addFlash('success', 'Your path Is edited !');
            $this->redirectToRoute('cursus_manager');
        }

        return $this->render('cursus_manager/edit_path.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/cursus/remove/path/{id}", name="cursus_remove_path")
     */
    public function removePath(PathRepository $path, int $id)
    {
        $path = $path->findBy(['id' => $id]);

        if (empty($path)) {
            $this->addFlash('error', 'Your path is not removed!');
            return $this->redirectToRoute('cursus_manager');
        }

        $this->entitymanager->remove($path[0]);
        $this->entitymanager->flush();

        $this->addFlash('success', 'Your path is removed!');
        $this->redirectToRoute('cursus_manager');
    }

    //////////
    // CERTIFICAT MANAGER
    //////////

    /**
     * @Route("/cursus/add/certificat", name="cursus_add_certificat")
     */
    public function addCertificat(Request $request): Response
    {
        $form = $this->createForm(CertificateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entitymanager->persist($form->getData());
            $this->entitymanager->flush();
            $this->addFlash('success', 'Your certificat Is added !');
            $this->redirectToRoute('cursus_manager');
        }

        return $this->render('cursus_manager/add_certificat_level.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/cursus/edit/certificat/{id}", name="cursus_edit_certificat")
     */
    public function editCertificat(Request $request, PathCertificateRepository $certificat, int $id): Response
    {
        $certificat = $certificat->findBy(['id' => $id]);

        if (empty($certificat)) {
            $this->addFlash('error', 'Your certificat dont exist!');
            return $this->redirectToRoute('cursus_manager');
        }

        $form = $this->createForm(CertificateType::class, $certificat[0]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entitymanager->persist($form->getData());
            $this->entitymanager->flush();
            $this->addFlash('success', 'Your certificat Is edited !');
            $this->redirectToRoute('cursus_manager');
        }

        return $this->render('cursus_manager/edit_certificat_level.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/cursus/remove/certificat/{id}", name="cursus_remove_certificat")
     */
    public function removeCertificat(PathCertificateRepository $certificat, int $id)
    {
        $certificat = $certificat->findBy(['id' => $id]);

        if (empty($certificat)) {
            $this->addFlash('error', 'Your certificat is not removed!');
            return $this->redirectToRoute('cursus_manager');
        }

        $this->entitymanager->remove($certificat[0]);
        $this->entitymanager->flush();

        $this->addFlash('success', 'Your project is removed!');
        $this->redirectToRoute('cursus_manager');
    }

    //////////
    // PROJECT MANAGER
    //////////

    /**
     * @Route("/cursus/add/project", name="cursus_add_project")
     */
    public function addProject(Request $request): Response
    {
        $form = $this->createForm(ProjectType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entitymanager->persist($form->getData());
            $this->entitymanager->flush();
            $this->addFlash('success', 'Your project Is added !');
            $this->redirectToRoute('cursus_manager');
        }

        return $this->render('cursus_manager/add_project.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/cursus/edit/project/{id}", name="cursus_edit_project")
     */
    public function editProject(Request $request, PathProjectRepository $project, int $id): Response
    {
        $project = $project->findBy(['id' => $id]);

        if (empty($project)) {
            $this->addFlash('error', 'Your project dont exist!');
            return $this->redirectToRoute('cursus_manager');
        }

        $form = $this->createForm(ProjectType::class, $project[0]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entitymanager->persist($form->getData());
            $this->entitymanager->flush();
            $this->addFlash('success', 'Your project Is edited !');
            $this->redirectToRoute('cursus_manager');
        }

        return $this->render('cursus_manager/edit_project.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/cursus/remove/project/{id}", name="cursus_remove_project")
     */
    public function removeProject(PathProjectRepository $project, int $id)
    {
        $project = $project->findBy(['id' => $id]);

        if (empty($project)) {
            $this->addFlash('error', 'Your project is not removed!');
            return $this->redirectToRoute('cursus_manager');
        }

        $this->entitymanager->remove($project[0]);
        $this->entitymanager->flush();

        $this->addFlash('success', 'Your project is removed!');
        $this->redirectToRoute('cursus_manager');
    }


    //////////
    // CATEGORY MANAGER
    //////////


    /**
     * @Route("/cursus/add/category", name="cursus_add_category")
     */
    public function addCategory(Request $request): Response
    {

        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entitymanager->persist($form->getData());
            $this->entitymanager->flush();
            $this->addFlash('success', 'Your category Is added !');
            $this->redirectToRoute('cursus_manager');
        }

        return $this->render('cursus_manager/add_category.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/cursus/edit/category/{id}", name="cursus_edit_category")
     */
    public function editCategory(Request $request, PathCategoryRepository $category, int $id): Response
    {

        $category = $category->findBy(['id' => $id]);

        if (empty($category)) {
            $this->addFlash('error', 'Your category dont exist!');
            return $this->redirectToRoute('cursus_manager');
        }

        $form = $this->createForm(CategoryType::class, $category[0]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entitymanager->persist($form->getData());
            $this->entitymanager->flush();
            $this->addFlash('success', 'Your project Is edited !');
            $this->redirectToRoute('cursus_manager');
        }

        return $this->render('cursus_manager/edit_category.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/cursus/remove/category/{id}", name="cursus_remove_category")
     */
    public function removeCategory(PathCategoryRepository $category,  int $id)
    {
        $category = $category->findBy(['id' => $id]);

        if (empty($category)) {
            $this->addFlash('error', 'Your category is not removed!');
            return $this->redirectToRoute('cursus_manager');
        }

        $this->entitymanager->remove($category[0]);
        $this->entitymanager->flush();

        $this->addFlash('success', 'Your category is removed!');
        $this->redirectToRoute('cursus_manager');
    }
}
