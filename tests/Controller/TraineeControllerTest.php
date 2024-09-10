<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TraineeControllerTest extends WebTestCase
{
    public function testIndexPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/trainee');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Les Stagiaires');
        $this->assertCount(1, $crawler->filter('h2')); // Vérifie qu'il y a un titre h2
    }

    public function testNewTraineeFormSubmission()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/trainee/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Créer un stagiaire'); 

        // Récupérer le formulaire d'ajout de stagiaire
        $form = $crawler->selectButton('Enregistrer')->form([
            'trainee[name]' => 'John',
            'trainee[firstName]' => 'Doe',
            'trainee[gender]' => 'M',
            'trainee[dateBirth]' => '1990-01-01',
            'trainee[city]' => 'Paris',
            'trainee[email]' => 'john.doe@example.com',
            'trainee[phone]' => '0601020304',
        ]);

        // Soumettre le formulaire
        $client->submit($form);

        // Vérifie la redirection après la soumission
        $this->assertResponseRedirects('/admin/trainee');
        $client->followRedirect();

        // Vérifie qu'un message flash de succès est présent
        $this->assertSelectorTextContains('.alert-success', 'Votre stagiaire a été créé avec succès !');
    }

    public function testSearchTrainee()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/search?term=John');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('td', 'John');
    }
}
