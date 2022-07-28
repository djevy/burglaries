<?php
$myInputsArgs = array(
    "live" => FILTER_SANITIZE_ENCODED,
    "gen" => FILTER_SANITIZE_ENCODED,
    "version" => FILTER_SANITIZE_ENCODED,
);
$myInputs = filter_input_array(INPUT_GET, $myInputsArgs);
if (is_null($myInputs)) {
    $myInputs = array();
}
$localCacheBust = "?cache=" . date("zHis");
$local = true;
if (isset($myInputs["live"]) && !!$myInputs["live"]) {
    $localCacheBust = "";
    $local = false;
}
ob_start();
$projName = array(
    "long" => "Burglaries",
    "seo" => "burglaries",
    "bodyId" => "bls",
    "headerAlt" => "burglaries",
    "breaks" => array(
        "tablet" => false, // false for mid size options
        "mobile" => 618,
    ),
);
$projName["_bodyId"] = "_" . $projName["bodyId"];
$projName["-bodyId"] = "-" . $projName["bodyId"];

$projName["proj"] = array(
    "id" => "du-proj-" . str_replace("_", "-", $projName["seo"]),
    "vers" => "", // "du-vers-"
    /** FELIX */
    "tmdatatrack" => "data-unit_" . $projName["seo"]
);
$projName["proj"]["css"] = "div#" . $projName["proj"]["id"] . ".du-body";
$projName["widgetFunction"] = "du_" . $projName["seo"] . $projName["_bodyId"] . "_widget";
/**
 * Social
 */
$projectHash =   str_replace(' ', '', ucwords(str_replace('_', ' ', $projName["seo"])));
// $socialItems = false;
$socialItems = array(
    "toScript" => array(
        "message" => "I just used the " . $projName["long"] . " interactive on ",
        "hash" => "reachDataUnit," . $projectHash,
    ),
    "btns" => array(
        "Facebook",
        "Twitter",
        "WhatsApp",
    ),
);
// $socialItems = false;
/* * ****************** */
$ui = true;
/** always use */
$supportClass = true;
/**
 * newsletter support
 */
$newsletter = array(
    "main"  => false, // "birm_whatson", // loads first
    "default"  => "iya", // default newsletter, loads if no main newsletter is available "mirror_euro_20",
    "skin" => false, // Skin version. "normal" (false), "short", "skinny"
    "style"  => false, // style version "light" (false), "dark",
    "callback"  => false, // "du_finished" <- call after subscribing
    "skip"  => false, // "No thanks, I just want the results" // <- button message
);
// $newsletter = false;
/* * ****************** */

$base_s3 = "../";
$url_server = "../";
$base_dir = "projects/";
$base_proj = $base_dir . "burglaries/";
$baseUrl = array(
    "url" => $url_server,
    "proj" => $base_proj,
    "img" => "img/",
    "def_img" => $base_s3 . "_main_tm/",
    "js" => $base_s3 . "js/",
    "supportClass" => $supportClass ? $base_s3 . "_base_pkg_inc/code_to_min/du_support_fc_script.min.js" : false,
    "newsletter" => $newsletter ? $base_s3 . "newsletter_subscription/loc_files/du_newsletter.js" : false,
    "analytics" => false,
    "php_setup" => array(
        "local" => $local,
        "json" => "./data/",
        "ui" => $ui,
        "class" => "local"
    ),
    "toSave" => array(
        "toMin" => "code_to_min/",
        "files" => "loc_files/",
        "preview" => "preview/",
    )
);
$localBaseUrl = $baseUrl;

if (!$local) {
    $base_s3 = "https://static.trinitymirrordataunit.com/";
    $url_server = "https://www.trinitymirrordataunit.com/";
    /* uncomment if project folder name is different */
    // $base_proj = "projectFolderName/";
    $baseUrl = array(
        "url" => $url_server,
        "proj" => $base_proj,
        "img" => $base_s3 . "img/" . $projName["seo"] . "/",
        "def_img" => $base_s3 . "img/base/",
        "js" => $base_s3 . "js/",
        "supportClass" => $supportClass ? $base_s3 . "js/du_support_fc_script.min.js" : false,
        "newsletter" => $newsletter ? $base_s3 . "js/du_newsletter.min.js" : false,
        "analytics" => $baseUrl["analytics"],
        "php_setup" => array(
            "local" => $local,
            "json" => $url_server . $projName["seo"] . "/",
            "ui" => $ui,
            "class" => "notlocal"
        ),
        "toSave" => array(
            "toMin" => "code_to_min/",
            "files" => "code_to_min/",
            "preview" => "preview/",
        )
    );
}

include "index.inc.php";
$indexOptions = array(
    "local" => $local,
    "baseUrl" => $baseUrl,
    "localBaseUrl" => $localBaseUrl,
    "projName" => $projName,
    "version" => false,
);
$IndexApp = new IndexApp($indexOptions);
$baseUrl["final"] = $baseUrl["url"] . $baseUrl["proj"];
$bodyClass = $IndexApp->genBodyClass($myInputs);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $projName["long"]; ?> - Index.php</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0" />
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW" />
    <?php /*
          <script src="<?php echo $localBaseUrl["js"]; ?>jquery-3.5.1.min.js"></script>
          <script src="<?php echo $localBaseUrl["js"]; ?>jquery-ui.min.js"></script>
          <link rel="stylesheet" href="<?php echo $localBaseUrl["js"]; ?>jquery-ui.css" />
         */ ?>
    <style>
        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            padding: 0
        }

        body.body-widget {
            background-color: #cfe7cf
        }

        body.body-widget-live {
            background-color: #ffd9df
        }

        #current_setup {
            padding-left: 10px
        }

        #current_setup:after,
        #current_setup li {
            list-style: none;
            display: inline-block;
            border: 2px solid #fff;
            border-radius: 1em;
            font-size: 14px;
            text-transform: capitalize;
            padding: 2px 6px;
            margin: 0 2px;
            background: #c60000;
            color: #fff;
            font-weight: bold
        }

        #current_setup li.js,
        #current_setup:after {
            background: #004f9c
        }

        #current_setup li.on {
            background: #00b700
        }

        #current_setup li.genCode {
            border-radius: 0;
            background: gold;
            border: 2px solid #000
        }

        @media (max-width: 600px) {
            body {
                padding: 16px
            }
        }
    </style>
</head>

<body class="<?php echo $bodyClass; ?>">
    <ul id="current_setup" class="<?php echo $baseUrl["php_setup"]["class"]; ?>">
        <?php echo $IndexApp->getOptionsLightsHtml(isset($myInputs["gen"]) ? $myInputs["gen"] : ""); ?>
    </ul>
    <!-- ********************************** INI *************************** -->
    <!-- #### -->
    <?php
    $colors["main"] = "#a7120e";
    $fonts = array(
        "main" => array(
            "font-family" => '"Open Sans", sans-serif',
            "google-name" => "Open+Sans",
            "google-options-main" => "wght@",
            "google-options" => array(
                "400",
                "700",
                "800"
            )
        ),
        "sec" => array(
            "font-family" => '"Signika Negative", sans-serif',
            "google-name" => "Signika+Negative",
            "google-options-main" => "wght@",
            "google-options" => array(
                "400",
                "700"
            )
        )
    );
    $addLive = !$local ? "&live=1" : "";
    $addLive .= isset($myInputs["version"]) ? "&version=" . $myInputs["version"] : "";
    if (isset($myInputs["gen"])) {
        switch ($myInputs["gen"]) {
            case "css":
                ob_clean();
                include "index_css.php";
                $IndexApp->formatAndSaveCss(ob_get_contents());
                break;
            case "script":
                ob_clean();
                include "index_script.php";
                $IndexApp->formatAndSaveJs(ob_get_contents());
                break;
            case "innerHtml":
                ob_clean();
                include "index_html.php";
                $IndexApp->generateInnerHtml(ob_get_contents());
                break;
            case "widget":
                include "index_html.php";
                $IndexApp->generateMainHtml(ob_get_contents(), $addLive);
                break;
            default:
                break;
        }
    } else {
        include "index.info.php";
    }

    ?>
    <!-- #### -->
    <!-- ********************************** END *************************** -->
</body>

</html><?php
        if (!$local) {
            $IndexApp->formatAndSaveCodeFiles(ob_get_contents());
        }
