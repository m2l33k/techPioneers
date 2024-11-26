<?php

namespace App\Tests\Controller;

use App\Entity\Cours;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CoursControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/cours/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Cours::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Cour index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'cour[Titre_Cours]' => 'Testing',
            'cour[Descriptio_Cours]' => 'Testing',
            'cour[Id_Enseignant_Cours]' => 'Testing',
            'cour[Date_creation_Cours]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cours();
        $fixture->setTitre_Cours('My Title');
        $fixture->setDescriptio_Cours('My Title');
        $fixture->setId_Enseignant_Cours('My Title');
        $fixture->setDate_creation_Cours('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Cour');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cours();
        $fixture->setTitre_Cours('Value');
        $fixture->setDescriptio_Cours('Value');
        $fixture->setId_Enseignant_Cours('Value');
        $fixture->setDate_creation_Cours('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'cour[Titre_Cours]' => 'Something New',
            'cour[Descriptio_Cours]' => 'Something New',
            'cour[Id_Enseignant_Cours]' => 'Something New',
            'cour[Date_creation_Cours]' => 'Something New',
        ]);

        self::assertResponseRedirects('/cours/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre_Cours());
        self::assertSame('Something New', $fixture[0]->getDescriptio_Cours());
        self::assertSame('Something New', $fixture[0]->getId_Enseignant_Cours());
        self::assertSame('Something New', $fixture[0]->getDate_creation_Cours());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cours();
        $fixture->setTitre_Cours('Value');
        $fixture->setDescriptio_Cours('Value');
        $fixture->setId_Enseignant_Cours('Value');
        $fixture->setDate_creation_Cours('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/cours/');
        self::assertSame(0, $this->repository->count([]));
    }
}
