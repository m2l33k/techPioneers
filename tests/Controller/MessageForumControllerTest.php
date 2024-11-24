<?php

namespace App\Tests\Controller;

use App\Entity\MessageForum;
use App\Repository\MessageForumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class MessageForumControllerTest extends WebTestCase{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/message/forum/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(MessageForum::class);

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
        self::assertPageTitleContains('MessageForum index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'message_forum[Createur_MessageForum]' => 'Testing',
            'message_forum[Id_Forum]' => 'Testing',
            'message_forum[Conetenu_Id_MessageForum]' => 'Testing',
            'message_forum[DateCreation_Id_MessageForum]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new MessageForum();
        $fixture->setCreateur_MessageForum('My Title');
        $fixture->setId_Forum('My Title');
        $fixture->setConetenu_Id_MessageForum('My Title');
        $fixture->setDateCreation_Id_MessageForum('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('MessageForum');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new MessageForum();
        $fixture->setCreateur_MessageForum('Value');
        $fixture->setId_Forum('Value');
        $fixture->setConetenu_Id_MessageForum('Value');
        $fixture->setDateCreation_Id_MessageForum('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'message_forum[Createur_MessageForum]' => 'Something New',
            'message_forum[Id_Forum]' => 'Something New',
            'message_forum[Conetenu_Id_MessageForum]' => 'Something New',
            'message_forum[DateCreation_Id_MessageForum]' => 'Something New',
        ]);

        self::assertResponseRedirects('/message/forum/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCreateur_MessageForum());
        self::assertSame('Something New', $fixture[0]->getId_Forum());
        self::assertSame('Something New', $fixture[0]->getConetenu_Id_MessageForum());
        self::assertSame('Something New', $fixture[0]->getDateCreation_Id_MessageForum());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new MessageForum();
        $fixture->setCreateur_MessageForum('Value');
        $fixture->setId_Forum('Value');
        $fixture->setConetenu_Id_MessageForum('Value');
        $fixture->setDateCreation_Id_MessageForum('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/message/forum/');
        self::assertSame(0, $this->repository->count([]));
    }
}
