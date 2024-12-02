<?php

namespace App\Tests\Controller;

use App\Entity\Ressource;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RessourceControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/ressource/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Ressource::class);

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
        self::assertPageTitleContains('Ressource index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'ressource[Titre_Ressource]' => 'Testing',
            'ressource[Description_Ressource]' => 'Testing',
            'ressource[Type_Ressource]' => 'Testing',
            'ressource[Id_Enseignat_Ressource]' => 'Testing',
            'ressource[Url_Ressource]' => 'Testing',
            'ressource[DateCreation_Ressource]' => 'Testing',
            'ressource[Id_Cours]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ressource();
        $fixture->setTitre_Ressource('My Title');
        $fixture->setDescription_Ressource('My Title');
        $fixture->setType_Ressource('My Title');
        $fixture->setId_Enseignat_Ressource('My Title');
        $fixture->setUrl_Ressource('My Title');
        $fixture->setDateCreation_Ressource('My Title');
        $fixture->setId_Cours('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Ressource');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ressource();
        $fixture->setTitre_Ressource('Value');
        $fixture->setDescription_Ressource('Value');
        $fixture->setType_Ressource('Value');
        $fixture->setId_Enseignat_Ressource('Value');
        $fixture->setUrl_Ressource('Value');
        $fixture->setDateCreation_Ressource('Value');
        $fixture->setId_Cours('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'ressource[Titre_Ressource]' => 'Something New',
            'ressource[Description_Ressource]' => 'Something New',
            'ressource[Type_Ressource]' => 'Something New',
            'ressource[Id_Enseignat_Ressource]' => 'Something New',
            'ressource[Url_Ressource]' => 'Something New',
            'ressource[DateCreation_Ressource]' => 'Something New',
            'ressource[Id_Cours]' => 'Something New',
        ]);

        self::assertResponseRedirects('/ressource/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre_Ressource());
        self::assertSame('Something New', $fixture[0]->getDescription_Ressource());
        self::assertSame('Something New', $fixture[0]->getType_Ressource());
        self::assertSame('Something New', $fixture[0]->getId_Enseignat_Ressource());
        self::assertSame('Something New', $fixture[0]->getUrl_Ressource());
        self::assertSame('Something New', $fixture[0]->getDateCreation_Ressource());
        self::assertSame('Something New', $fixture[0]->getId_Cours());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ressource();
        $fixture->setTitre_Ressource('Value');
        $fixture->setDescription_Ressource('Value');
        $fixture->setType_Ressource('Value');
        $fixture->setId_Enseignat_Ressource('Value');
        $fixture->setUrl_Ressource('Value');
        $fixture->setDateCreation_Ressource('Value');
        $fixture->setId_Cours('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/ressource/');
        self::assertSame(0, $this->repository->count([]));
    }
}
