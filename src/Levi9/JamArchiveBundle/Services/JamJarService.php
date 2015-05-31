<?php

namespace Levi9\JamArchiveBundle\Services;

use Doctrine\ORM\EntityManager;
use Levi9\JamArchiveBundle\Entity\JamJar;

class JamJarService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Clone $jamJar object $amount times
     *
     * @param JamJar $jamJar
     * @param $amount
     */
    public function cloneJams(JamJar $jamJar, $amount)
    {
        if (!is_int($amount) && $amount < 1) {
            return;
        }

        while ($amount--) {
            $cloneJamJar = clone $jamJar;
            $this->entityManager->persist($cloneJamJar);
        }

        $this->entityManager->flush();
    }
}
