<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UserControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/user/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(User::class);

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
        self::assertPageTitleContains('User index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'user[nomUser]' => 'Testing',
            'user[prenomUser]' => 'Testing',
            'user[emailUser]' => 'Testing',
            'user[motdepasseUser]' => 'Testing',
            'user[numtelephoneUser]' => 'Testing',
            'user[roleUser]' => 'Testing',
            'user[datenaissanceUser]' => 'Testing',
            'user[photoUser]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new User();
        $fixture->setNomUser('My Title');
        $fixture->setPrenomUser('My Title');
        $fixture->setEmailUser('My Title');
        $fixture->setMotdepasseUser('My Title');
        $fixture->setNumtelephoneUser('My Title');
        $fixture->setRoleUser('My Title');
        $fixture->setDatenaissanceUser('My Title');
        $fixture->setPhotoUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new User();
        $fixture->setNomUser('Value');
        $fixture->setPrenomUser('Value');
        $fixture->setEmailUser('Value');
        $fixture->setMotdepasseUser('Value');
        $fixture->setNumtelephoneUser('Value');
        $fixture->setRoleUser('Value');
        $fixture->setDatenaissanceUser('Value');
        $fixture->setPhotoUser('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'user[nomUser]' => 'Something New',
            'user[prenomUser]' => 'Something New',
            'user[emailUser]' => 'Something New',
            'user[motdepasseUser]' => 'Something New',
            'user[numtelephoneUser]' => 'Something New',
            'user[roleUser]' => 'Something New',
            'user[datenaissanceUser]' => 'Something New',
            'user[photoUser]' => 'Something New',
        ]);

        self::assertResponseRedirects('/user/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomUser());
        self::assertSame('Something New', $fixture[0]->getPrenomUser());
        self::assertSame('Something New', $fixture[0]->getEmailUser());
        self::assertSame('Something New', $fixture[0]->getMotdepasseUser());
        self::assertSame('Something New', $fixture[0]->getNumtelephoneUser());
        self::assertSame('Something New', $fixture[0]->getRoleUser());
        self::assertSame('Something New', $fixture[0]->getDatenaissanceUser());
        self::assertSame('Something New', $fixture[0]->getPhotoUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new User();
        $fixture->setNomUser('Value');
        $fixture->setPrenomUser('Value');
        $fixture->setEmailUser('Value');
        $fixture->setMotdepasseUser('Value');
        $fixture->setNumtelephoneUser('Value');
        $fixture->setRoleUser('Value');
        $fixture->setDatenaissanceUser('Value');
        $fixture->setPhotoUser('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/user/');
        self::assertSame(0, $this->repository->count([]));
    }
}
