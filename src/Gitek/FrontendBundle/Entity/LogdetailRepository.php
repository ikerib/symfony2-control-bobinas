<?php

namespace Gitek\FrontendBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * LogdetailRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LogdetailRepository extends EntityRepository
{
    public function findByComponentedatamatrix($componente, $lote, $uuid)
    {
        $em = $this->getEntityManager();

        $dql = "SELECT l
                    FROM FrontendBundle:Logdetail l
                    WHERE l.componente = :componente
                    AND l.lote = :lote
                    AND l.uuid = :uuid";

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('componente', $componente);
        $consulta->setParameter('lote', $lote);
        $consulta->setParameter('uuid', $uuid);
//        print_r($consulta->getSQL());
        return $consulta->getResult();
    }
}
