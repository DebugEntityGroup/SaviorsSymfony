<?php

namespace ReclamationBundle\Repository;
use Doctrine\ORM\EntityRepository;
use ReclamationBundle\Repository;
use Doctrine\ORM\Query;

/**
 * ReclamationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReclamationRepository extends \Doctrine\ORM\EntityRepository
{
    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p
                FROM ReclamationBundle:Reclamation p
                WHERE p.objet LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }

}