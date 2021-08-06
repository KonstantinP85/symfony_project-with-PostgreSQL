<?php

namespace App\Controller\Profile;

use App\Entity\Profile;
use App\Form\ProfileType;
use App\Form\QuestType;
use App\Repository\ProfileRepositoryInterface;
use App\Services\FileServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileHomeController extends ProfileBaseController
{
    private $profileRepository;

    /**
     * @param ProfileRepositoryInterface $profileRepository
     */
    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * @Route ("/profile", name="profile")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $email = $this->getUser()->getEmail();
        $profile = $this->getDoctrine()->getRepository(Profile::class)->findOneBy(['email' => $email]);
        if (!empty($profile)) {
            $form = $this -> createForm(QuestType::class);
            $form->handleRequest($request);
            $forRender = parent::renderDefault();
            $forRender['title'] = 'Your profile';
            $forRender['profile'] = $profile;
            $forRender['form'] = $form->createView();

            return $this->render('profile/index.html.twig', $forRender);
        }
        else {
            return $this->redirectToRoute('profile_create');
        }
    }

    /**
     * @Route ("profile/create", name="profile_create")
     * @param Request $request
     * @param FileServiceInterface $fileService
     * @return RedirectResponse|Response
     */
    public function create(Request $request, FileServiceInterface $fileService)
    {
        $profile = new Profile();
        $email = $this->getUser()->getEmail();
        $form = $this -> createForm(ProfileType::class, $profile);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $filename = $fileService->imageUpload($image);
                $profile->setImage($filename);
            }
            $profile->setEmail($email);
            $this->profileRepository->setCreateProfile($profile);

            return $this->redirectToRoute('profile');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Create profile';
        $forRender['form'] = $form->createView();

        return $this->render('profile/User/form.html.twig', $forRender);
    }

    /**
     * @Route ("profile/update", name="profile_update")
     * @param Request $request
     * @param FileServiceInterface $fileService
     * @return RedirectResponse|Response
     */
    public function update(Request $request, FileServiceInterface $fileService)
    {
        $email = $this->getUser()->getEmail();
        $profile = $this->getDoctrine()->getRepository(Profile::class)->findOneBy(['email' => $email]);
        $form = $this -> createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()) {
                $image = $form->get('image')->getData();
                $image_old = $profile->getImage();
                if ($image) {
                    if ($image_old) {
                        $fileService->imageRemove($image_old);
                    }
                    $filename = $fileService->imageUpload($image);
                    $profile->setImage($filename);
                }
                $this->profileRepository->setUpdateProfile($profile);
            }
            return $this->redirectToRoute('profile');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Update profile';
        $forRender['form'] = $form->createView();

        return $this->render('profile/User/form.html.twig', $forRender);
    }

    /**
     * @Route ("profile/search", name="profile_search")
     * @param Request $request
     * @return Response
     */
    public function search(Request $request): Response
    {
        $id = $request->get('id');
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Search';
        $forRender['profile'] = $this->profileRepository->getSearchProfile($id);

        return $this->render('profile/User/result.html.twig', $forRender);
    }
}