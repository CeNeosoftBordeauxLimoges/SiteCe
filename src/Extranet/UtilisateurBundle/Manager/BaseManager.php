<?php

namespace Extranet\UtilisateurBundle\Manager;

abstract class BaseManager
{
    public function persistAndFlush($entity)
    {
        if ($this->persist($entity)) {

            $this->flush($entity);

            return true;
        }

        return false;
    }

    public function removeAndFlush($entity)
    {
        if ($this->remove($entity)) {

            $this->flush($entity);

            return true;
        }

        return false;
    }

    public function flush($entity)
    {
        try {
            $this->em->flush($entity);

            return true;
        } catch (Exception $ex) {

            return false;
        }

    }

    public function persist($entity)
    {
        try {
            $this->em->persist($entity);

            return true;
        } catch (Exception $ex) {

            return false;
        }
    }

    public function remove($entity)
    {
        try {
            $this->em->remove($entity);

            return true;
        } catch (Exception $ex) {

            return false;
        }
    }
}