<?php

namespace Levi9\JamArchiveBundle\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Levi9\JamArchiveBundle\Services\JamJarService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Levi9\JamArchiveBundle\Entity\JamJar;
use Levi9\JamArchiveBundle\Entity\JamType;
use Levi9\JamArchiveBundle\Entity\JamYear;

class JamJarServiceTest extends WebTestCase
{
    const DEFAULT_COUNT_OF_JAMS = 20;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var JamJarService
     */
    private $jamJarService;

    /**
     * @var EntityRepository
     */
    private $jamJarRepository;

    public function setUp()
    {
        $client = self::createClient();
        $container = $client->getContainer();
        $this->jamJarService = $container->get('jam_jar');
        $this->entityManager = $container->get('doctrine')->getManager();
        $this->jamJarRepository = $this->entityManager->getRepository('Levi9JamArchiveBundle:JamJar');
        $this->entityManager->beginTransaction();
    }

    /**
     * @dataProvider cloneJamsSuccessProvider
     */
    public function testCloneJamsSuccess($amount)
    {
        $this->assertEquals(
            self::DEFAULT_COUNT_OF_JAMS,
            count($this->jamJarRepository->findAll())
        );

        $this->jamJarService->cloneJams($this->getNewJamJar(), $amount);

        $this->assertEquals(
            self::DEFAULT_COUNT_OF_JAMS + $amount,
            count($this->jamJarRepository->findAll())
        );
    }

    public function cloneJamsSuccessProvider()
    {
        return [
            [2],
            [5],
            [10],
        ];
    }

    /**
     * @dataProvider cloneJamsFailProvider
     */
    public function testCloneJamsFail($amount)
    {
        $this->assertEquals(
            self::DEFAULT_COUNT_OF_JAMS,
            count($this->jamJarRepository->findAll())
        );

        $this->jamJarService->cloneJams($this->getNewJamJar(), $amount);

        $this->assertEquals(
            self::DEFAULT_COUNT_OF_JAMS,
            count($this->jamJarRepository->findAll())
        );
    }

    public function cloneJamsFailProvider()
    {
        return [
            [0],
            [-1],
            [null],
            [''],
            ['hello'],
        ];
    }

    public function getNewJamJar()
    {
        $jamJar = new JamJar();
        $jamJar->setComment('good');

        $jamType = new JamType();
        $jamType->setName('peach');

        $jamYear = new JamYear();
        $jamYear->setName('2012');

        $jamJar->setType($jamType);
        $jamJar->setYear($jamYear);

        return $jamJar;
    }

    public function tearDown()
    {
        $this->entityManager->rollback();
    }
}
