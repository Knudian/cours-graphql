<?php

namespace App\Factory;

use App\Constant\MessageCode;
use App\Entity\User;
use App\Exception\User\CredentialsException;
use App\Exception\User\NoChangeInActivationException;
use App\Exception\NoModificationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFactory
 * @package App\Factory
 */
class UserFactory
{
    /**
     * @var array
     */
    private $sampleUser = array(
        'username'  => null,
        'lastName'  => null,
        'firstName' => null,
        'email'     => null,
        'password'  => 'P@ssword'
    );

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * UserFactory constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->em = $entityManager;

    }

    /**
     * @param array $input
     * @return User
     */
    public function make(array $input): User
    {
        $data = array_merge($this->sampleUser, $input);
        $user = new User();
        $user->setUsername($data['username'])
            ->setEmail($data['email'])
            ->setLastName($data['lastName'])
            ->setFirstName($data['firstName'])
            ->setPassword($this->passwordEncoder->encodePassword($user, $data['password']));

        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     * @param User $user
     * @param string $password
     * @throws CredentialsException
     */
    public function canConnect(User $user, string $password): void
    {
        if( !$this->passwordEncoder->isPasswordValid($user, $password)) {
            throw new CredentialsException(MessageCode::INVALID_CREDENTIALS);
        }
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
     * @throws NoModificationException
     */
    public function update(User $user, array $data): User
    {
        $hasBeenModified = false;
        foreach (['username', 'firstName', 'lastName'] as $key) {
            if (array_key_exists($key, $data) && $user->get($key) !== $data[$key]) {
                $user->set($key, $data[$key]);
                $hasBeenModified = true;
            }
        }
        if ($hasBeenModified) {
            $this->em->persist($user);
            $this->em->flush();
        } else {
            throw new NoModificationException();
        }
        return $user;
    }

    /**
     * @param User $user
     * @param bool $status
     * @throws NoChangeInActivationException
     */
    public function changeActive(User $user, bool $status)
    {
        if ($user->getIsActive() === $status)
            throw new NoChangeInActivationException();
        $user->setIsActive($status);
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param User $user
     */
    public function delete(User $user): void
    {
        $user->setUsername('Utilisateur désinscrit')
            ->setFirstName('inconnu')
            ->setLastName('inconnu')
            ->setIsActive(false);

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param User $user
     */
    public function resetPassword(User $user): void
    {
        $newPassword = md5(json_encode($user).time());
        $newPassword = substr($newPassword, rand(0, strlen($newPassword)), 8);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $newPassword));
        $this->em->persist($user);
        $this->em->flush();
    }
}