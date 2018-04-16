<?php

namespace ProjetInformatiqueIndividuel\Tests;

require_once __DIR__.'/../../vendor/autoload.php';

use Silex\WebTestCase;

class AppTest extends WebTestCase
{
    /**
     * Basic, application-wide functional test inspired by Symfony best practices.
     * Simply checks that all application URLs load successfully.
     * During test execution, this method is called for each URL returned by the provideUrls method.
     *
     * @dataProvider provideUrls
     */
    public function testPageIsSuccessful($url)
    {
        $client = $this->createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * {@inheritDoc}
     */
    public function createApplication()
    {
        $app = new \Silex\Application();

        require __DIR__.'/../../app/config/dev.php';
        require __DIR__.'/../../app/app.php';
        require __DIR__.'/../../app/routes.php';

        // Generate raw exceptions instead of HTML pages if errors occur
        unset($app['exception_handler']);
        // Simulate sessions for testing
        $app['session.test'] = true;
        // Enable anonymous access to admin zone
        $app['security.access_rules'] = array();

        return $app;
    }

    /**
     * Provides all valid application URLs.
     *
     * @return array The list of all valid application URLs.
     */
    public function provideUrls()
    {
        return array(
            array('/'),
            array('/partenariats'),
            array('/login'),
            array('/recherche-stage'),
            array('/recherche-semestre'),
            array('/stage/1'),
            array('/semestre/2'),
            array('/inscription'),

            /* UTILISATEUR */
            array('/mesexperiences'),
            array('/mescommentaires'),
            array('/profil'),
            array('/modification_profil'),
            array('/ajout_stage'),
            array('/ajout_semestre'),
            array('/modification_stage/1'),
            array('/modification_semestre/2'),
            array('/mesexperiences'),
            array('/mescommentaires'),
            array('/mesexperiences/stage/1/suppression'),
            array('/mesexperiences/semestre/2/suppression'),
            array('/mescommentaires/stage/1/suppression'),
            array('/mescommentaires/semestre/1/suppression'),


            /* ADMIN */
            array('/admin'),
            array('/admin/ajout_entreprise'),
            array('/admin/ajout_universite'),
            array('/admin/modification_entreprise/1'),
            array('/admin/modification_universite/2'),
            array('/admin/suppression_entreprise/1'),
            array('/admin/suppression_universite/2'),
            array('/admin/modification_semestre/1'),
            array('/admin/modification_stage/2'),
            array('/admin/suppression_semestre/1'),
            array('/admin/suppression_stage/2'),
            array('/admin/suppression_commentaire_stage/1'),
            array('/admin/suppression_commentaire_semestre/2'),
            array('/admin/modification_utilisateur/2'),
            array('/admin/suppression_utilisateur/3')
        );
    }
}