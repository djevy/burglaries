<script src="<?php echo "##tempFinalFile##" . $IndexApp->getScriptFilename() . $localCacheBust; ?>"></script>
<?php
$addMainNewsletter = "";
if (
    $newsletter &&
    $newsletter["main"]
) {
    $addMainNewsletter = 'data-du-newsletter="' . $newsletter["main"] . '"';
}
?>
<div <?php /*
*/ ?> id="<?php echo $projName["proj"]["id"]; ?>" <?php /*
*/ ?> class="du-body du-mobile <?php echo $projName["proj"]["vers"]; ?>" <?php /*
*/ echo $addMainNewsletter; /* 
*/ ?> data-tmdatatrack="<?php echo $projName["proj"]["tmdatatrack"]; ?>" <?php /*
*/ ?>>
    <div id="du-wait<?php echo $projName["-bodyId"]; ?>" class="du-wait du-hide"><span>&nbsp;</span></div>
    <noscript>
        <div id="du-js-warning">This widget requires javascript to work.</div>
    </noscript>
    <a name="du-top"></a>
    <div id="du-widget-body">
        <div id="du-temp-header" class="du-header">
            <div class="du-container">
                <h2><?php echo $projName["headerAlt"]; ?></h2>
            </div>
        </div>
        <!-- ++++++++ -->
        <div id="du-main-header" class="du-header">
            <div class="du-container">
                <img class="du-header-img" alt="<?php echo $projName["headerAlt"]; ?>" src="<?php echo $IndexApp->formatImageUrl("img", "du" . $projName["_bodyId"] . "_header.png"); ?>" />

                <div class="du-text">How many burglary cases were reported in your area? </div>
                <div class="du-text">Enter your details below to find out</div>
                <div id="du-search-box">
                    <input type="text" name="du-search" id="du-search" maxlength="15" placeholder="Type your postcode" />
                    <button type="button" id="du-search-go">Search</button>
                </div>
            </div>
        </div>
        <div id="du-widget">
            <div class="du-container">
                <!-- <div id="du-comparison-bar"></div> -->


                <div id="du-mapContainer">
                    <div id="du-canvas">

                    </div>

                </div>

                <div id="du-slider-container"></div>
                
                <div id="du-table-holder">
                    <div id="du-result-table" class="du-table">
                        <span class="du-table-head">
                            <span class="du-table-row">
                                <span class="du-table-cell du-row-header"> Period </span>
                                <span class="du-table-cell">Number of burglaries</span></span></span>
                        <span class="du-table-body" id="du-table-body"></span>
                    </div>
                    <div class="du-data-note du-table-footnote" style="display: none;"></div>
                </div>

                
            </div>
            <div class="du-footer">
                <div class="du-text" id="du-footnote">*Figures exclude Greater Manchester, due to incomplete data.</div>
                <div class="du-container">
                    <?php
                    if ($socialItems) { ?>
                        <ul id="du-social-holder">
                            <li class="du-social-box"><a class="du-social-btn du-btn" target="_blank" href="" title=""><span></span></a></li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if ($newsletter) { ?>
            <div class="du-nlf-holder"></div>
        <?php } ?>
        <!-- ++++++++ -->
    </div>
</div>
<?php if ($local) { ?>
    <!--meta property="fb:app_id" content="226899387441465"-->
    <meta property="fb:app_id" content="261815760677199">
    <meta name="twitter:site" value="@MENSports">
<?php } ?>
<?php if (!isset($fonts) || count($fonts) == 0) { ?>
    <script>
        alert("no font set");
    </script>
<?php } ?>
<script>
    (function() {
        function waitForIt(thisFunc, attempts) {
            if (typeof(window[thisFunc]) == "function") {
                const thisApp = new window[thisFunc]();
            } else {
                if (--attempts > 0) {
                    setTimeout(function() {
                        waitForIt(thisFunc, attempts)
                    }, 100);
                }
            }
        }
        waitForIt("<?php echo $projName["widgetFunction"]; ?>", 30);
    }());
</script>