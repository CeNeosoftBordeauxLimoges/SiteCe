<?php
namespace Extranet\UtilisateurBundle\Service;

use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class Password
{
    private $encoderFactory;
    private $characters = 'abcefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';


    public function __construct(EncoderFactory $encoder_factory)
    {
        $this->encoderFactory = $encoder_factory;
    }

    public function generate(&$entity)
    {
        $clearPassword = substr(str_shuffle($this->characters), 0, 8);

        $encoder = $this->encoderFactory->getEncoder($entity);

        $password = $encoder->encodePassword($clearPassword, $entity->getSalt());

        if ($entity->setPassword($password)) {

            return $clearPassword;
        }

        return false;
    }

    public function encode(&$entity)
    {
        $encoder = $this->encoderFactory->getEncoder($entity);

        return $encoder;
    }

}
