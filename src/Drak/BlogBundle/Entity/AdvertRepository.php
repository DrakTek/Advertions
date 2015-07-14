<?php

namespace Drak\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends EntityRepository
{
    public function myFindAll()
    {
        // methode 1 : en passant par lentytimanager
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('a')
            ->from($this->_entityName, 'a')
        ;

        // methode 2 : en passant par le raccourci
        $queryBuilder = $this->createQueryBuilder('a');

        // on recupere la query a partir du QueryBuilder
        $query = $queryBuilder->getQuery();

        // on recupere les resultats a partir de la query
        $results = $query->getResult();

        // on retourne ces resultats
        return $results;
    }

    public function whereCurrentYear(QueryBuilder $qb)
    {
        $qb
            ->andWhere('a.mdate BETWEEN :start AND :end')
            ->setParameter('start', new \Datetime(date('Y').'-01-01'))
            ->setParameter('end',   new \Datetime(date('Y').'-12-31'))
        ;
    }

    public function myFind()
    {
        $qb = $this->createQueryBuilder('a');

        // on peut ajouter ce qu'on veut avant
        $qb
            ->where('a.author = :author')
            ->setParameter('author', 'Marine')
        ;

        // on applique notre condition
        $this->whereCurrentYear($qb);

        // on peut ajouter ce qu'on veut apres
        $qb->orderBy('a.mdate','DESC');

        return $q
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAdvertWithApplications()
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->leftJoin('a.applications','app')
            ->addSelect('app')
        ;

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    // les annonces qui correspondent a une liste de categories
    public function getAdvertWithCategories(array $categoryNames)
    {
        $qb = $this->createQueryBuilder('a');

        // on fait la jointure avec l'entite category avec pour alias c
        $qb
            ->join('a.categories', 'cat')
            ->addSelect('cat')
        ;

        // puis on filtre sur le nom des categories a l'aide du IN
        $qb
            ->where(
                $qb
                    ->expr()
                    ->in('c.name', $categoryNames)
            )
        ;

        // on peut ajouter ce qu'on veut apres
        $qb->orderBy('a.mdate','DESC');

        return $q
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAdverts($page, $nbPerPage)
    {
        $query = $this
            ->createQueryBuilder('a')
            // jointure sur l'attribut image
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            // jointure sur l'attribut categories
            ->leftJoin('a.categories', 'c')
            ->addSelect('c')
            ->orderBy('a.mdate', 'DESC')
            ->getQuery()
        ;

        $query
            // on definit l'annonce a partir de laquelle commencer la liste
            ->setFirstResult(($page-1) * $nbPerPage)
            // ainsi que le nombre d'annonce a afficher par page
            ->setMaxResults($nbPerPage)
        ;

        // enfin on retourne l'object paginator correspondant
        // a la requete construite
        return new Paginator($query, true);

        // return $query
        //     ->getResult()
        // ;
    }

    public function getlist_a_nettoyer($days,array $applist)
    {
        $qb = $this->createQueryBuilder('a');
    
        $qb
            ->where('DATE_DIFF(:today, a.updatedAt) > :days')
            ->andwhere(
                $qb
                    ->expr()
                    ->notin('a.id', $applist)
            )
            ->setParameter('today', new \Datetime)
            ->setParameter('days', $days)
        ;
        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
