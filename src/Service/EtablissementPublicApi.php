<?php


namespace App\Service;


class EtablissementPublicApi
{
    protected $url = 'https://etablissements-publics.api.gouv.fr/v3/';

    public function getEttablissementBy(string $code, array $ettablissementsTypes) : array
    {
        $jsonResult = [];
        foreach ($ettablissementsTypes as $ettablissementType){
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $this->url . 'communes/' . $code . '/' . $ettablissementType);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


            $headers = array();
            $headers[] = 'Accept: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                return [];
            }
            curl_close($ch);

            $jsonResult = array_merge($jsonResult, (json_decode($result))->features);
        }

        return $jsonResult;
    }
}