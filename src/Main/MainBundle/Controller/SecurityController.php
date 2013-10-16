<?php
namespace Main\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Main\MainBundle\Entity\Users;
use Main\MainBundle\Form\RegisterType;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'MainMainBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
    public function registerAction()
    {
        $user = new Users();
        $request = $this->getRequest();
        $form = $this->createForm(new RegisterType(), $user);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            $service = $this->container->get('main_main.users');
            if($form->isValid())
            {
                $key = $service->sendRegisterMail($form);

                $this->get('session')->getFlashBag()->add('notice', 'Register success! A mail containing the account activation link has been sent to your email address. Access it to activate your account.');
                /*
                $user->setActivationKey($key);
                $user->setPassword(md5($form->getData->getPassword()))
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();*/
                return $this->redirect($this->generateUrl('main_main_register'));
            }
        }
        return $this->render(
            'MainMainBundle:Security:register.html.twig', array('form'=>$form->createView(),'errors'=>'')
        );
    }
}