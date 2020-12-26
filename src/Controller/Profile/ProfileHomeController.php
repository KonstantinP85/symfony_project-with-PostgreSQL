<?php


namespace App\Controller\Profile;


use App\Entity\Profile;
use App\Entity\User;
use App\Form\ProfileType;
use App\Form\QuestType;
use App\Form\UserType;
use App\Repository\ProfileRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileHomeController extends ProfileBaseController
{
    private $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * @Route ("/profile", name="profile")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $email = $this->getUser()->getEmail();
        $profile = $this->getDoctrine()->getRepository(Profile::class)->findOneBy(['email' => $email]);

        if (!empty($profile)) {
            $form = $this -> createForm(QuestType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())            //проверяем данные из формы
            {
                if ($form->get('search')->isClicked())
                {
                    $id = $request->get('quest');
                    $language = $id['language'];
                    $forRender = parent::renderDefault();
                    $forRender['title'] = 'Search';
                    $forRender['profile'] = $this->profileRepository->getSearchProfile($language);
                    return $this->render('profile/User/search.html.twig', $forRender);
                }
            }
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
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $profile = new Profile();
        $email = $this->getUser()->getEmail();
        $form = $this -> createForm(ProfileType::class, $profile);
        $form->handleRequest($request);                          //принимаем данные из формы
        if ($form->isSubmitted() && $form->isValid())            //проверяем данные из формы
        {
            $profile->setEmail($email);
            $this->profileRepository->setCreateProfile($profile);
            //  $this->addFlash('success', 'Profile was created!');
            return $this->redirectToRoute('profile');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Create profile';
        $forRender['form'] = $form->createView();
        return $this->render('profile/User/form.html.twig', $forRender);
    }

    /**
     * @Route ("profile/update", name="profile_update")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function update(Request $request)
    {
        $email = $this->getUser()->getEmail();
        $profile = $this->getDoctrine()->getRepository(Profile::class)->findOneBy(['email' => $email]);
        $form = $this -> createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())            //проверяем данные из формы
        {
            if ($form->get('save')->isClicked())
            {
                $this->profileRepository->setUpdateProfile($profile);
                //$this->addFlash('success', 'Task was updated!');
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
    public function search(Request $request)
    {
        $id = $request->get('quest');
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Search';
        $forRender['task'] = $this->profileRepository->getSearchProfile($id);
        return $this->render('profile/User/search.html.twig', $forRender);

    }

}