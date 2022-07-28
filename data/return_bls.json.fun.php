<?php
defined('OKTORUN+IMCOOL+GHSD3KFGDD5WDG4DFASFDBZDF') or exit('');
$on = "im_cool+>W$@`ov1e|Wu7W_q]-,Nx$;}TyL`b5g@l++gsz]6S!q9''zM15vR]nQVNNsT^lxx%(ou{EM)JjzH^X;R^,TYm8^[#AIvS@Sq7[!3";
include '../_base/inc/base_v2.inc.php';

if ($appOptions["debug"]) {
    include($mainOptions["adoFolder"] . "adodb-exceptions.inc.php");
}
include($mainOptions["adoFolder"] . "adodb.inc.php");

class DefaultCodeApp extends BaseClass
{
    /*     * ****************************************
     *          APP - DB
     */

    private $burglaries = false;
    
    public function findArea($postcode) {
        $result = "";
        $result = $this -> readPostcodeData($postcode);
        // $distinct =  $this -> findDistinct();
        $error = false;
        // $result = $this -> attemptUpdate($postcode);

        if (!$result || !$result["la"] || is_null($result["la"])) {
            $result = $this->lookupPostcode($postcode);

            if (!isset($result) || $result["la"] == null || !$result["la"]) {
                return array("code" => $result, "status" => "1", "error" => "No data available for this postcode", "debug" => "No Result");
            }
        }
        
        if($error){
            return array("error" => $error);
        } 

        if (!$this -> burglaries) {
            include_once "return_bls.json.fun.burglaries.php";
            $this -> burglaries = $burglaries;
        }

        if (!isset($this -> burglaries["res"][$result["la"]])) {
            return array("code" => $result, "status" => "2", "error" => "No data available for this postcode", "debug" => "No Data");
        };

        return array(
            "code" => $result,
            "res" => $this -> burglaries["res"][$result["la"]]
        );
    }
    
    private function lookupPostcode($postcode)
    {
        // $postcodeIO = $this->searchPostcodeIO($postcode);
        $thatPostcode = $this->findThatPostcode($postcode);

        // if (!isset($postcodeIO["result"]["codes"]["admin_district"])) {
        //     return false;
        // }
        if (!isset($thatPostcode["data"]["attributes"]["laua"])) {
            return false;
        }


        // $ladcd = $postcodeIO["result"]["codes"]["admin_district"];
        $la = $thatPostcode["data"]["attributes"]["laua"];
        $la_name = $thatPostcode["data"]["attributes"]["laua_name"];
        $lat = $thatPostcode["data"]["attributes"]["lat"];
        $long = $thatPostcode["data"]["attributes"]["long"];

        // $this->updateDatabase(array($pfa, $postcode));

        return array("la" => $la, "la_name" => $la_name, "lat" => $lat, "long" => $long);
    }
    private function updateDatabase($data)
    {
        if (!is_object($this->DB)) {
            $this->connectDb();
        }

        $sql = "UPDATE du_postcode_data
                SET pfa = ?
                WHERE pcds = ?;";

        $query = $this->DB->Prepare($sql);
        $this->DB->execute($query, $data);
    }
    // private function searchPostcodeIO($postcode)
    // {
    //     $data = file_get_contents("https://api.postcodes.io/postcodes/" . trim($postcode));
    //     return json_decode($data, true);
    // }
    private function findThatPostcode($postcode)
    {
        $data = file_get_contents("https://findthatpostcode.uk/postcodes/" . trim($postcode));
        return json_decode($data, true);
    }
    private function readPostcodeData($postcode)
    {
        if (!is_object($this->DB)) {
            $this->connectDb();
        }
        $sql = "SELECT
                    `pcds` AS `pc`,
                    `lad11cd` AS `la`,
                    `lat` AS `lat`,
                    `long` AS `long`
                FROM
                du_postcode_data as `pcd`
                WHERE
                    pcd.pcds = ?";

        $query = $this->DB->Prepare($sql);
        return $this->DB->GetRow($query, array($postcode));
    }
    /*     * ****************************************
     *          APP - widget
     */

    public function getPostcodeData($postcode)
    {
        $decodedPostcode = $postcode;
        if (base64_encode(base64_decode($postcode, true)) === $postcode) {
            $decodedPostcode = base64_decode($postcode);
        }
        $res = $this->readPostcodeData($decodedPostcode);

        if ($res) {
            return array(
                "res" => $res
            );
        }
        return array(
            "error" => "no data"
        );
    }
    /*     * ****************************************
     *          APP - support
     */
}
