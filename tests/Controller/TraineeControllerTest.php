<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TraineeControllerTest extends WebTestCase
{
    public function testIndexPage()
    {

        //Cela crée un client pour simuler les requêtes HTTP.
        $client = static::createClient();

        //Cela envoie une requête GET à l’URL spécifiée et récupère le contenu de la page.
        $crawler = $client->request('GET', '/admin/trainee');

        //Cela vérifie que la réponse HTTP est un succès (code 200).
        $this->assertResponseIsSuccessful();

        //Cela vérifie que le texte du premier élément h2 contient “Les Stagiaires”.
        $this->assertSelectorTextContains('h2', 'Les Stagiaires');

        //Cela vérifie qu’il y a exactement un élément h2 sur la page.
        $this->assertCount(1, $crawler->filter('h2')); 
    }

    public function testNewTraineeFormSubmission()
    {

        //Création de client et requête 
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/trainee/new');


        //Vérification de la réponse 
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

        //Si vous souhaitez que le client suive automatiquement toutes les redirections, vous pouvez Forcez-les en appelant la méthode avant d’exécuter la requête :followRedirects()
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
