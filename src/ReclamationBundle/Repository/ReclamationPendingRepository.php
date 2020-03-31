<?php

namespace ReclamationBundle\Repository;
use Doctrine\ORM\EntityRepository;
use ReclamationBundle\Repository;
use Doctrine\ORM\Query;

/**
 * ReclamationPendingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReclamationPendingRepository extends \Doctrine\ORM\EntityRepository
{ public function findByNbR($mot, $score)
{
    $Query= $this->getEntityManager()->createQuery( "select A from ReclamationBundle:Reclamation A where A.nbReclamation<=:5 
        ")->setParameter( 'nb',$score)->setParameter('mot', '%'.$mot.'%');
    return $Query->getResult();
}
}