<?php

namespace App\Tests\Controller;

use App\Entity\Forum;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ForumControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/forum/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Forum::class);

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
        self::assertPageTitleContains('Forum index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'forum[Titre_Forum]' => 'Testing',
            'forum[Description_Forum]' => 'Testing',
            'forum[Createur_Forum]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Forum();
        $fixture->setTitre_Forum('My Title');
        $fixture->setDescription_Forum('My Title');
        $fixture->setCreateur_Forum('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Forum');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Forum();
        $fixture->setTitre_Forum('Value');
        $fixture->setDescription_Forum('Value');
        $fixture->setCreateur_Forum('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'forum[Titre_Forum]' => 'Something New',
            'forum[Description_Forum]' => 'Something New',
            'forum[Createur_Forum]' => 'Something New',
        ]);

        self::assertResponseRedirects('/forum/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre_Forum());
        self::assertSame('Something New', $fixture[0]->getDescription_Forum());
        self::assertSame('Something New', $fixture[0]->getCreateur_Forum());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Forum();
        $fixture->setTitre_Forum('Value');
        $fixture->setDescription_Forum('Value');
        $fixture->setCreateur_Forum('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/forum/');
        self::assertSame(0, $this->repository->count([]));
    }
}
