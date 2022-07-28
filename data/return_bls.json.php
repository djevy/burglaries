<?php
$appOptions = array(
    "short" => "_bls",
    "checkOrigin" => false,
    "debug" => true,
    "debugDB" => false,
    "localDbName" => "2015_elections"
);

define('OKTORUN+IMCOOL+GHSD3KFGDD5WDG4DFASFDBZDF', TRUE);
include "../../_base/return.base.php";
$appOptions["live"] = $mainOptions["live"];
if ($appOptions["live"]) {
    $appOptions["localDbName"] = false;
}

/* * *
 * VALIDATE ORIGIN
 * * */
if (!$appOptions["checkOrigin"]) {
    header("Access-Control-Allow-Origin: *");
} else {
    $specialExemptions = false;
    /*
      $specialExemptions = array(
      "localhost"
      );
     */
    $OriginChecker = new CheckOriginClass($specialExemptions);

    if (!$OriginChecker->isOriginOk()) {
        $msg = $OriginChecker->getOriginError();
        if (!$appOptions["debug"]) {
            $msg = "";
        }
        die($msg);
    }
}

/* OPTIONS */
$availableTypes = array(
    "burglaries",
);
/* INPUT VARIABLES */
$baseFilter = array(
    'filter' => FILTER_SANITIZE_STRING,
    'flags' => FILTER_FLAG_NO_ENCODE_QUOTES
);
$baseArrayFilter = array(
    'filter' => FILTER_SANITIZE_STRING,
    'flags' => FILTER_FLAG_NO_ENCODE_QUOTES | FILTER_REQUIRE_ARRAY
);
$myInputsArgs = array(
    "type" => $baseFilter,
    "info" => $baseFilter,
);
$myInputs = filter_input_array(INPUT_POST, $myInputsArgs);
if (is_null($myInputs)) {
    $myInputs = array();
}

if (
    !isset($myInputs["type"]) ||
    !in_array($myInputs["type"], $availableTypes)
) {
    die($dieMsg["invalid_type"]);
} else if (!isset($myInputs['info'])) {
    die($dieMsg["missing_data"]);
}

/* READY TO START */
include_once "return" . $appOptions["short"] . ".json.fun.php";
if ($appOptions["localDbName"]) {
    $baseDB["db"] = $appOptions["localDbName"];
}

$DefaultCodeDataApp = new DefaultCodeApp($baseDB, $appOptions);

/* * **** this app ***** */
$finalResult = $DefaultCodeDataApp->findArea($myInputs["info"]);

/* * **** this app ***** */
if ($finalResult) {
    echo $DefaultCodeDataApp->returnJsonReady($finalResult);
}

$DefaultCodeDataApp->x();
