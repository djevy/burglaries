<style>
    <?php
    /* * *
    * GOOGLE FONTS, Imports should go on TOP
    */
    if (isset($fonts) && count($fonts) > 0) {
        $fontImport[] = "@import url('https://fonts.googleapis.com/css2?family=";
        foreach ($fonts as $key => $value) {
            $tempFontImport[] = implode(":", array($value['google-name'], $value['google-options-main'])) . implode(";", $value['google-options']);
        }
        $fontImport[] = implode("&family=", $tempFontImport);
        $fontImport[] = "&display=swap');\n";
        echo implode("", $fontImport);
    }

    /******
     * top info
     */
    if ($local) {
    ?>

    /** */
    #current_setup:after {
        content: "CSS: <?php echo date("Ymd - H:i:s"); ?>"
    }

    <?php
    }
    $spriteBaseName = "du" . $projName["_bodyId"] . "_sprite";
    $sprite = $IndexApp->calculateSprite($spriteBaseName);
    ?>

    /* RESET */
    div#du-body.du-body div,
    div#du-body.du-body h2,
    div#du-body.du-body h3,
    div#du-body.du-body p,
    div#du-body.du-body span,
    div#du-body.du-body ul,
    div#du-body.du-body li,
    div#du-body.du-body img,
    div#du-body.du-body button,
    div#du-body.du-body label,
    div#du-body.du-body input,
    div#du-body.du-body select {
        color: inherit;
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 100%;
        font: inherit;
        vertical-align: baseline;
        line-height: normal;
        box-sizing: content-box;
        min-width: auto;
    }

    div#du-body.du-body ul,
    div#du-body.du-body li {
        list-style: none;
    }

    div#du-body.du-body a:focus,
    div#du-body.du-body button:focus {
        outline: 1px dotted #FFF;
    }

    div#du-body.du-body select:focus,
    div#du-body.du-body textarea:focus,
    div#du-body.du-body input:focus {
        outline: 1px dotted #000;
    }

    div#du-body.du-body img {
        display: block
    }

    div#du-body.du-body .du-img-hd,
    div#du-body.du-body h2::before,
    div#du-body.du-body h2::after,
    div#du-body.du-body h3::before,
    div#du-body.du-body h3::after {
        display: none
    }

    /* CLEARFIX */
    <?php
    /* ADD CF TOO */
    $cf = array(
        "div.du-header",
        ".du-container"
    );
    $cfClasses = "";
    $cfClassesIe = "";
    foreach ($cf as $value) {
        $cfClasses .= "div#du-body.du-body " . $value . ":after,\n";
        $cfClassesIe .= "div#du-body.du-body " . $value . ",\n";
    }
    echo $cfClasses;
    ?>

    /** */
    div#du-body.du-body:after {
        content: "";
        display: table;
        clear: both;
    }

    <?php echo $cfClassesIe; ?>

    /** */
    div#du-body.du-body {
        *zoom: 1;
    }

    /* CSS */
    div#du-body.du-body {
        background: #363b59;
        border: 0;
        color: #fff;
        font-family: <?php echo $fonts["main"]["font-family"]; ?>;
        font-size: 17px;
        line-height: 1.1em;
        margin: 10px auto;
        padding: 0;
        position: relative;
        text-align: left;
        width: 100%;
        z-index: 1;
        min-height: 330px;
    }

    div#du-body.du-body .du-wait {
        background: none no-repeat scroll center center #444444;
        background-color: rgba(0, 0, 0, 0.5);
        display: block;
        height: 100%;
        width: 100%;
        position: absolute;
        z-index: 3;
        left: 0;
        top: 0;
    }

    div#du-body.du-body .du-wait span {
        background: none no-repeat scroll center center transparent;
        background-color: rgba(0, 0, 0, 0.4);
        background-image: url("<?php echo $IndexApp->formatImageUrl("def_img", "spinning-loader-black-bg.gif"); ?>");
        -webkit-border-radius: 20px;
        -moz-border-radius: 20px;
        border-radius: 20px;
        display: block;
        height: 100px;
        margin: 0 auto;
        position: relative;
        top: 21%;
        width: 100px;
    }

    div#du-body.du-body .du-wait.du-hide {
        display: none;
    }

    div#du-body.du-body #du-js-warning {
        text-align: center;
        background-color: #000;
        padding: 15px 0;
        color: red;
    }

    div#du-body.du-body .du-container {
        width: 96%;
        max-width: 750px;
        padding: 0px 0px 10px;
        margin: 0 auto;
    }

    div#du-body.du-body .du-header {
        background:
            url("<?php echo $IndexApp->formatImageUrl("img", "du" . $projName["_bodyId"] . "_header_bg.png"); ?>") no-repeat scroll center center #000;
        background-size: 110% auto;
        font-size: 1.2em;
        display: block;
        border-bottom: #de6e18 solid 5px;
    }

    div#du-body.du-body .du-header .du-container {
        font-family: <?php echo $fonts["sec"]["font-family"]; ?>;
    }

    div#du-body.du-body .du-header .du-header-img {
        width: 100%;
        max-width: 380px;
        margin: 20px auto 0;
    }

    div#du-body.du-body .du-header .du-banner {
        visibility: hidden;
        color: #fff;
        background: <?php echo $colors["main"]; ?>;
        margin: 0 auto;
        font-weight: bold;
        padding: 4px 10px 1px;
        text-align: center;
        text-transform: uppercase;
        max-width: 200px;
        font-size: 15px;
    }

    div#du-body.du-body h2 {
        line-height: 1.1em;
        font-size: 2.6em;
        font-weight: bold;
        margin: 15px auto;
        text-align: center;
        color: #FFF;
    }

    div#du-body.du-body .du-text {
        line-height: 1.2em;
        color: #FFF;
        margin: auto;
        text-align: center;
    }

    div#du-body.du-body .du-header .du-text {
        font-size: 1.1em;
        padding: 2px 8%;
        text-align: center;
    }

    div#du-body.du-body #du-widget {
        min-height: 250px;
    }

    div#du-body.du-body #du-widget .du-container {
        color: #000;
        display: none
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-search-box {
        color: #000;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 10px auto;
        padding: 10px 0;
        text-align: center;
        padding: 15px;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-search,
    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-search-go {
        font-size: 1em;
        height: 30px;
        line-height: 1em;
        padding: 4px 0;
        text-align: center;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-search {
        text-transform: uppercase;
        font-weight: bold;
        width: 75%;
        margin-bottom: 10px;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-search-go {
        color: #000;
        cursor: pointer;
        font-weight: bold;
        width: 30%;
        background: #de6e18;
        color: #ffd700;
        -webkit-border-radius: 2em;
        -moz-border-radius: 2em;
        border-radius: 5px;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-results {
        display: none;
        font-size: 1.1em;
        padding: 10px 0 30px;
        text-align: center;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-results .du-text {
        color: #000;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-comparison-bar {
        font-size: 1.1em;
        /* padding: 10px 0 30px; */
        margin-bottom: 10px;
        text-align: center;
        background: #de6e18;
        height: 30px;
        width: 100%;
        z-index: 1;

    }

    /* Results Table */
    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-table-holder {
        margin: 10px auto;
        width: 90%;
        margin-top: 10px;
        font-size: 1em;
        display: none;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-result-table {
        color: #de6e18;
        border-collapse: collapse;
        border-spacing: 0;
        background: transparent;
        width: 100%;
        font-weight: bold;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-result-table .du-row-header {
        border-right: 1px solid #d2d3d3;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-result-table .du-table-body .du-table-row {
        border-top: 1px solid #d2d3d3;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-result-table .du-row-header {
        width: 5.3em;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-result-table .du-data-qty {
        text-align: right;
        vertical-align: middle;
        font-size: 3em;
        font-weight: 800;
        width: 2em;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-table {
        display: table;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-table .du-table-head,
    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-table .du-table-body {
        display: table-row-group;
    }



    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-table-row {
        display: table-row;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-table-cell {
        display: table-cell;
        padding: 5px;
        vertical-align: top;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-row-header {
        width: 5.3em;
        border-right: 1px solid #d2d3d3;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-icon {
        /* background-color: transparent; */
        /* background: url("<?php echo $IndexApp->formatImageUrl("img", "du" . $projName["_bodyId"] . "_key_icon.png"); ?>") no-repeat scroll center center; */
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-icon.du-icon-crime {
        display: block;
        height: 20px;
        width: 20px;
        margin: 0 5px 5px 0;
        float: left;
        /* background: red; */
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-icon.du-icon-crime.du-icon-tiny {
        height: 7px;
        width: 7px;
    }

    /* Results Table */


    /* Map */
    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-mapContainer {
        width: calc(100% - 15px);
        max-width: 600px;
        height: 350px;
        display: block;
        padding: 0;
        margin: 10px auto;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-canvas {
        height: 100%;
        width: 100%;
        z-index: 1;
        border: solid #de6e18;
        border-radius: 5px;
    }


    div#<?php echo $projName["proj"]["id"]; ?>.du-body .leaflet-popup-content {
        padding: 6px;
        background-color: rgba(255, 255, 255, .9);
        border-radius: 5px;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .leaflet-popup-right:before {
        right: unset;
        margin: 0;
        border: unset;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .leaflet-popup-left:before {
        left: unset;
        margin: 0;
        border: unset;
    }

    /* Map */

    /* Slider */
    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-slider-container {
        margin: 20px auto;
        max-width: 605px;
        width: 100%;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-widget .du-section-slider {
        background-color: #363b59;
        padding: 5px;
        border-radius: 5px;
        border: #de6e18 solid;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-widget .du-section-slider .du-text {
        color: #fff;
    }


    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-widget .du-section-slider .du-bottom-line {
        color: #de6e18;
        padding-top: 10px;
        text-align: center;
    }
    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-widget .du-section-slider #du-slider-text {
        color: #de6e18;
        font-weight: bold;
        font-size: 1.2em;
        display: flex;
        justify-content: space-between;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-item-header {
        color: #452a19;
        font-weight: bold;
        text-align: center;
        margin: 15px 0px;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-slider-title {
        text-align: center;
        font-weight: bold;
        font-size: 1.5em;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-bold-data {
        color: #de6e18;
        font-weight: bold;
    }


    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-slider {
        width: 90%;
        height: 100%;
        margin: 60px auto 0px;
        position: relative;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-slider-background {
        display: block;
        width: 100%;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-slider-handle {
        position: absolute;
        bottom: 65%;
        left: 0px;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-slider-handle .du-slider-logo {
        width: 40px;
        margin: auto;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-slider-dot {
        position: absolute;
        bottom: 0;
        left: calc(50% - 5px);
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #fff;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-slider-line {
        width: 5px;
        height: 30px;
        margin: 0 auto;
        background-color: #fff;
    }

    /* Slider */

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-footer {
        text-align: center;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-footnote {
        font-style: italic;
        color: #fff;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-footer-txt {
        color: #fff;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body .du-footer-txt span {
        font-weight: bold
    }

    <?php
    /******
     * Social
     */
    if ($socialItems) {
        include "index_css.social.php";
    }
    ?>

    /******
     * placeholder
     */
    div#du-body.du-body ::-webkit-input-placeholder {
        color: #606060;
    }

    div#du-body.du-body :-moz-placeholder {
        /* Firefox 18- */
        color: #606060;
    }

    div#du-body.du-body ::-moz-placeholder {
        /* Firefox 19+ */
        color: #606060;
    }

    div#du-body.du-body :-ms-input-placeholder {
        color: #606060;
    }

    div#du-body.du-body ::placeholder {
        color: #606060;
    }

    div#du-body.du-body :focus::-webkit-input-placeholder {
        color: transparent;
    }

    /* MOBILE */
    div#du-body.du-body.du-mobile {
        font-size: 14px;
    }

    div#du-body.du-body.du-mobile div.du-header {
        background-size: auto 110%;
    }


    /*     * *
     * SPRITE
     */
    <?php
    if ($sprite) {
    ?>

    /** */
    div#du-body.du-body .du-icon {
        background: url("<?php echo $sprite["main"]["url"]; ?>") no-repeat scroll 0 0 transparent;
    }

    <?php
    }
    if ($sprite && $sprite["ratio2"]) {
    ?>

    /** */
    @media (-webkit-min-device-pixel-ratio: 2),
    (min-resolution: 192dpi) {

        /* Retina-specific stuff here */
        div#du-body.du-body .du-icon {
            background-image: url("<?php echo $sprite["ratio2"]["url"]; ?>");
            background-size: <?php echo $sprite["ratio2"]["size"]["width"] / 2; ?>px;
        }
    }

    <?php } ?>

    /* Newsletter */
    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-nlform.du-nlf-str .du-nlf-title {
        color: #de6e18;
    }

    div#<?php echo $projName["proj"]["id"]; ?>.du-body #du-nlform.du-nlf-str .du-nlf-btn {
        background-color: #363b59;
        color: #de6e18;
    }
</style>