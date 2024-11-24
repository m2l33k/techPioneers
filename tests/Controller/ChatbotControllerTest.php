<?php

namespace App\Tests\Controller;

use App\Entity\Chatbot;
use App\Repository\ChatbotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ChatbotControllerTest extends WebTestCase{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/chatbot/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Chatbot::class);

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
        self::assertPageTitleContains('Chatbot index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'chatbot[Datecreation_Chatbot]' => 'Testing',
            'chatbot[Contenu_Chatbot]' => 'Testing',
            'chatbot[Autheur_Chatbot]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Chatbot();
        $fixture->setDatecreation_Chatbot('My Title');
        $fixture->setContenu_Chatbot('My Title');
        $fixture->setAutheur_Chatbot('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Chatbot');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Chatbot();
        $fixture->setDatecreation_Chatbot('Value');
        $fixture->setContenu_Chatbot('Value');
        $fixture->setAutheur_Chatbot('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'chatbot[Datecreation_Chatbot]' => 'Something New',
            'chatbot[Contenu_Chatbot]' => 'Something New',
            'chatbot[Autheur_Chatbot]' => 'Something New',
        ]);

        self::assertResponseRedirects('/chatbot/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDatecreation_Chatbot());
        self::assertSame('Something New', $fixture[0]->getContenu_Chatbot());
        self::assertSame('Something New', $fixture[0]->getAutheur_Chatbot());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Chatbot();
        $fixture->setDatecreation_Chatbot('Value');
        $fixture->setContenu_Chatbot('Value');
        $fixture->setAutheur_Chatbot('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/chatbot/');
        self::assertSame(0, $this->repository->count([]));
    }
}
