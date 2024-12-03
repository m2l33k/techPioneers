<?php

namespace App\Tests\Controller;

use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EvenementControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/evenement/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Evenement::class);

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
        self::assertPageTitleContains('Evenement index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'evenement[Titre_Evenement]' => 'Testing',
            'evenement[Date_Evenement]' => 'Testing',
            'evenement[Description_Evenement]' => 'Testing',
            'evenement[Organisateur_Evenement]' => 'Testing',
            'evenement[lien_Evenement]' => 'Testing',
            'evenement[Lieu_Evenement]' => 'Testing',
            'evenement[category]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Evenement();
        $fixture->setTitre_Evenement('My Title');
        $fixture->setDate_Evenement('My Title');
        $fixture->setDescription_Evenement('My Title');
        $fixture->setOrganisateur_Evenement('My Title');
        $fixture->setLien_Evenement('My Title');
        $fixture->setLieu_Evenement('My Title');
        $fixture->setCategory('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Evenement');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Evenement();
        $fixture->setTitre_Evenement('Value');
        $fixture->setDate_Evenement('Value');
        $fixture->setDescription_Evenement('Value');
        $fixture->setOrganisateur_Evenement('Value');
        $fixture->setLien_Evenement('Value');
        $fixture->setLieu_Evenement('Value');
        $fixture->setCategory('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'evenement[Titre_Evenement]' => 'Something New',
            'evenement[Date_Evenement]' => 'Something New',
            'evenement[Description_Evenement]' => 'Something New',
            'evenement[Organisateur_Evenement]' => 'Something New',
            'evenement[lien_Evenement]' => 'Something New',
            'evenement[Lieu_Evenement]' => 'Something New',
            'evenement[category]' => 'Something New',
        ]);

        self::assertResponseRedirects('/evenement/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre_Evenement());
        self::assertSame('Something New', $fixture[0]->getDate_Evenement());
        self::assertSame('Something New', $fixture[0]->getDescription_Evenement());
        self::assertSame('Something New', $fixture[0]->getOrganisateur_Evenement());
        self::assertSame('Something New', $fixture[0]->getLien_Evenement());
        self::assertSame('Something New', $fixture[0]->getLieu_Evenement());
        self::assertSame('Something New', $fixture[0]->getCategory());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Evenement();
        $fixture->setTitre_Evenement('Value');
        $fixture->setDate_Evenement('Value');
        $fixture->setDescription_Evenement('Value');
        $fixture->setOrganisateur_Evenement('Value');
        $fixture->setLien_Evenement('Value');
        $fixture->setLieu_Evenement('Value');
        $fixture->setCategory('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/evenement/');
        self::assertSame(0, $this->repository->count([]));
    }
}
