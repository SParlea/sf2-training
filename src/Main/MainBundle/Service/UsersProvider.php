<?php
namespace Main\MainBundle\Service;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Main\MainBundle\Entity\Users;

class UsersProvider implements UserProviderInterface
{
    protected $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }
    public function loadUserByUsername($username)
    {
        $em = $this->doctrine->getManager();
        // make a call to your webservice here
        $userData = $em->getRepository('MainMainBundle:Users')->findOneBy(array('username'=>$username));
        // pretend it returns an array on success, false if there is no user
        if ($userData) {
            $password = $userData->getPassword();
            $roles = array($userData->getRoles()->getRole());
            $activated = $userData->getActivated();
            return new Users($username, $password, $roles, $activated);
        }

        throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof Users) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'namespace Main\MainBundle\Entity\Users';
    }
}