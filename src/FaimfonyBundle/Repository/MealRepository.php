<?php

namespace FaimfonyBundle\Repository;

/**
 * MealRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MealRepository extends \Doctrine\ORM\EntityRepository
{

    public function searchMeal($query)
    {
        return $this->createQueryBuilder('m')
            ->where('m.name LIKE :query')
            ->setParameter('query', $query . '%')
            ->getQuery()
            ->getResult();
    }

    public function maxPriceMeal(){
        $query = $this->createQueryBuilder('m');
        $query->setMaxResults(1);
        $query->orderBy('m.price', 'DESC');
        return $query->getQuery()->getResult();
    }

    public function minPriceMeal(){
        $query = $this->createQueryBuilder('m');
        $query->setMaxResults(1);
        $query->orderBy('m.price', 'ASC');
        return $query->getQuery()->getResult();
    }

    public function userFindMeal($maxPrice, $tags){
        $query = $this->createQueryBuilder('m');
        $query->join('m.tags', 't')->addSelect('t');
        $query->where('m.price <= :price')
            ->setParameters(array(
                'price' => $maxPrice,
            ))
            ->setMaxResults(30);
        $orModule = $query->expr()->orX();
        if(!empty($tags)){
            foreach ($tags as $tag){
                $orModule->add($query->expr()->like('t.name', "'%".$tag->getName())."%'");
            }
        }

        $query->andWhere($orModule);

        return $query->getQuery()->getResult();
    }


}
