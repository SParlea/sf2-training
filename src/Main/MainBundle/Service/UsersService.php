<?php
namespace Main\MainBundle\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;

class UsersService
{
	private $request;
	private $container;

	public function __construct($request,$container)
    {
        $this->request = $request;
        $this->container = $container;
    }

	public function sendRegisterMail($form)
	{
		$key = sha1($form->getData()->getUsername());
		$message = \Swift_Message::newInstance()
                    ->setSubject('Book Shop – Account activation')
                    ->setFrom('BookShop@bookstore.com')
                    ->setTo($form->getData()->getEmail())
                    ->setBody('Hello '.$form->getData()->getFirstname().' '.$form->getData()->getLastname().'<br/>
To activate your account please access the following link : <a href="'.$this->container->get('router')->generate('main_main_homepage',array('key'=>$key),true).'">Activation Link</a><br/>
This link is available for 24 hours and can be used only once. ','text/html');
        $this->container->get('mailer')->send($message);

        return $key;
	}
}