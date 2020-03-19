<?php

namespace App\Controller;

use App\Service\EtablissementPublicApi;
use App\Service\GeoApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        if($_POST && isset($_POST)){
            if(!empty(trim($_POST['ville'])) && !empty(trim($_POST['codePostal']))){
                $commune = (new GeoApi())->getCommuneBy([
                    ['nom', $_POST['ville']],
                    ['codePostal', $_POST['codePostal']]
                ]);

                if(sizeof($commune) !== 0){
                    $ettablissements = (new EtablissementPublicApi())->getEttablissementBy($commune['code'], [
                        'mairie',
                        'pole_emploi',
                        'gendarmerie'
                    ]);

//                    dd($ettablissements);
                }else{
                    $this->addFlash('danger', 'Votre recherche ne correspond à aucune commune !');
                }
            }else{
                $this->addFlash('danger', 'Merci de remplir au tous les champs !');
            }


//            dd($ettablissements);
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'communesForList' => (new GeoApi())->getAllCommune(),
            'ettablissements' => $ettablissements ?? [],
            'commune' => $commune ?? [],
            'codePostalList' => (new GeoApi())->getAllPostalCode()
        ]);
    }
}
