<?php


namespace App\Service;


class GeoApi
{
    protected $url = 'https://geo.api.gouv.fr/';

    public function getAllCommune() : array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url . 'communes');
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

        return json_decode($result);
    }

    public function getAllPostalCode() : array{
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url . 'communes?fields=codesPostaux');
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

        $result = json_decode($result);
        $codePostauxList = [];

        foreach ($result as $item){
            foreach ($item->codesPostaux as $codePostal){
                $codePostauxList[] = $codePostal;
            }
        }

        $codePostauxList = array_unique($codePostauxList);

        return $codePostauxList;
    }

    public function getCommuneBy(array $params) : array
    {
        dump($params);
        $datas = '';
        for($i = 0; $i < sizeof($params); $i++){
            dump($params[$i][0] . ' ' . $params[$i][1]);
            if(!empty(trim($params[$i][1]))){
                if(empty(trim($datas))){
                    $datas = '?' . $params[$i][0] . '=' . $params[$i][1];
                }else{
                    $datas = $datas . '&' . $params[$i][0] . '=' . $params[$i][1];
                }
            }
        }

        dump($datas);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url . 'communes' . $datas);
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

        dump(json_decode($result));
        $result = json_decode($result);

        if(sizeof($result) === 0){
            return [];
        }

        dd($result);

        return [
            'nom' => $result[0]->nom,
            'code' => $result[0]->code,
            'codeDepartement' => $result[0]->codeDepartement,
            'codeRegion' => $result[0]->codeRegion,
            'codesPostaux' => $result[0]->codesPostaux,
            'population' => $result[0]->population,
        ];
    }
}