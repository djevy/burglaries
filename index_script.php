<script>
    <?php
    if ($local) {
    ?>
        var dashBoardEl = document.getElementById("current_setup");
        if (dashBoardEl) {
            var node = document.createElement("LI"); /* Create a <li> node */
            var textnode = document.createTextNode("JS: <?php echo date("Ymd - H:i:s"); ?>"); /* Create a text node */
            node.appendChild(textnode); /* Append the text to <li> */
            node.classList.add("js");
            document.getElementById("current_setup").appendChild(node);
        }
        <?php
    }
    // du_My_ga
    $du_myGaFunctionName = "du_MyGa_" . $projName["seo"];
    if ($baseUrl["analytics"]) {
        if ($local) {
        ?>
            var <?php echo $du_myGaFunctionName; ?> = function(C, a, r, l, o, s, N) {
                console.log(o, [C, a, r, l, o, s, N]);
                return true;
            };
        <?php
        } else if (!$baseUrl["analytics"] || $baseUrl["analytics"] == "false") {
        ?>
            alert("MISSING ANALYTICS CODE");
        <?php
        } else {
            /* loading google */
        ?>
            if (typeof <?php echo $du_myGaFunctionName; ?> == "undefined") {
                (function(i, s, o, g, r, a, m) {
                    i["GoogleAnalyticsObject"] = r;
                    i[r] = i[r] || function() {
                        (i[r].q = i[r].q || []).push(arguments);
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o), m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m);
                })(window, document, "script", "//www.google-analytics.com/analytics.js", "<?php echo $du_myGaFunctionName; ?>");
            }
    <?php
        }
    }
    ?>
    if (!<?php echo $projName["widgetFunction"]; ?>) {
        var <?php echo $projName["widgetFunction"]; ?> = function() {
            document.getElementById("du-wait<?php echo $projName["-bodyId"]; ?>").className = "du-wait";
            var main = this;
            var jq, mainEl;
            var started = false;
            this.originalJq = false;
            var docUrl = du_getMainUrl();
            var clk = 0;
            var du_msg = {
                "postcode": "Please enter a postcode",
                "error": "Postcode not found, please try again later",
                "shown": "Please enter a new postcode",
                "signup": "Invalid email or postcode, please try again",
                "data": "There is no data available for this postcode"
            };
            var used = [];
            var areas = false;
            var oldSearch = false;
            var du_postcodeData = false;
            var clickedLayer= false;
            var du_mainData = false;
            var baseHtml = "<?php
                            $widgetInnerHtml = file_get_contents("http://localhost/" . $localBaseUrl["proj"] . "?gen=innerHtml" . $addLive);
                            echo addslashes($widgetInnerHtml);
                            ?>";
            <?php if ($supportClass) { ?>
                /******** add Support Class ********/
                var du_support = false;
                /******** add Support Class ********/
            <?php } ?>
            <?php if ($newsletter) { ?>
                /******** add newsletter Class ********/
                var widgetID = "<?php echo $projName["seo"]; ?>";
                var du_newsletterClass = false;
                /******** add newsletter Class ********/
            <?php } ?>
            var onReady = function() {
                mainEl = jq("#<?php echo $projName["proj"]["id"]; ?>.du-body");
                jq(window).resize(function() {
                    if (main.resizeTO) {
                        clearTimeout(main.resizeTO);
                    }
                    main.resizeTO = setTimeout(function() {
                        jq(this).trigger("du-resizeEnd<?php echo $projName["-bodyId"]; ?>");
                    }, 150);
                });
                jq(window).bind("du-resizeEnd<?php echo $projName["-bodyId"]; ?>", function() {
                    main.du_checkParentSize();
                });
                /* onReady for widget - INI */
                jq("#du-widget-body", mainEl).html(baseHtml);
                <?php if ($supportClass) { ?>
                    /******** add Support Class ********/
                    du_support = new du_support_fc(jq);
                    /*
                     console.log(du_support.addCommas(90999))
                     console.log(du_support.checkPostCode("dsafsdf"))
                     console.log(du_support.checkPostCode("m217pg"))
                     */
                    /******** add Support Class ********/
                <?php } ?>
                <?php if ($newsletter) { ?>
                    /******** add NEWSLETTER ********/
                    if (typeof du_newsletter == "function") {
                        var du_newsletterOptions = {
                            /**  mainEl from main widget **/
                            /* REQUIRED */
                            m: mainEl,
                            /**  jquery **/
                            /* REQUIRED */
                            jq: jq,
                            /**  widget ID - to be used as sourcce of data **/
                            id: widgetID,
                            /**  Short Version **/
                            /** converted to 'SKIN'  */
                            <?php if ($newsletter["skin"]) { ?>
                                skin: "<?php echo $newsletter["skin"]; ?>",
                            <?php } ?>
                            /** style -> light / dark */
                            <?php if ($newsletter['style']) { ?>
                                style: "<?php echo $newsletter['style']; ?>",
                            <?php } ?>
                            /**  send to analytics **/
                            <?php if ($baseUrl["analytics"]) { ?>
                                ac: du_analyticsClick,
                            <?php } ?>
                            /**  if there"s a callback after newsletter submitted **/
                            <?php if ($newsletter["callback"]) { ?>
                                cb: <?php echo $newsletter["callback"]; ?>,
                                /**  if there"s skip button, add text **/
                                <?php if ($newsletter["skip"]) { ?>
                                    sk: "<?php echo $newsletter["skip"]; ?>",
                                <?php } ?>
                            <?php } ?>
                        };
                        /**  if there"s a default newsletter for the widget **/
                        <?php if ($newsletter["default"]) { ?>
                            du_newsletterOptions.nl = "<?php echo $newsletter["default"]; ?>";
                        <?php } ?>
                        du_newsletterClass = new du_newsletter(du_newsletterOptions);
                    }
                    /******** add NEWSLETTER ********/
                <?php } ?>

                /* onReady for widget - END */
                /* inicio  */
                /*
                 var address = "**** ***";
                 if (typeof btoa == "function") {
                    address = btoa(address);
                 }
                 var headerData = {
                    type: "<?php echo $projName["seo"]; ?>",
                    info: address
                 }
                 getjson(headerData, du_test, du_test);
                /*
                 wait(0);
                 */
                /* * /
                du_analyticsClick("sdfsd");
                /***/
                // du_analytics();
                <?php if ($socialItems) { ?>
                    du_socialStartBtns();
                <?php } ?>
                getJsonGeoData(runWidgetBinds, du_fatalError);
                main.du_checkParentSize();
            };
            /* WIDGET FUNCTIONS - INI */
            <?php include_once "index_script.widget.php"; ?>
            /* WIDGET FUNCTIONS - END */


            // Support Classes:
            <?php
            include "index_script.leaflet.php";
            ?>
            <?php
            /* social - INI */
            /******
             * Social
             */
            if ($socialItems) {
                include_once "index_script.social.php";
            }
            /* social - END */
            ?>
            /* checksize - INI */
            this.du_checkParentSize = function() {
                var jqMain = jq(mainEl);
                var jqPai = jq(mainEl).parent();
                <?php if ($projName["breaks"]["tablet"]) { ?>
                    if (jqPai.width() > <?php echo $projName["breaks"]["tablet"]; ?>) {
                        jqMain.removeClass("du-mobile du-tablet");
                    } else
                    <?php } ?>
                    if (jqPai.width() > <?php echo $projName["breaks"]["mobile"]; ?>) {
                        jqMain
                            .removeClass("du-mobile")
                            .addClass("du-tablet");
                    } else {
                        jqMain
                            .removeClass("du-tablet")
                            .addClass("du-mobile");
                    }
            };
            /* checksize - END */
            /* revert webview - INI */
            function du_getMainUrl() {
                /* test webviews
                let y = "https://webviews.mirror.co.uk/sport/football/news/manchester-united-paul-pogba-keane-25192165/embedded-webview/mirror-25140497#amp=1";
                let y = "https://www.mirror.co.uk/sport/football/news/manchester-united-paul-pogba-keane-25192165";
                 */
                let thisDocUrl = window.location.href;
                thisDocUrl = thisDocUrl.split("?")[0];
                thisDocUrl = thisDocUrl.split("#")[0];
                let tempDocUrl = thisDocUrl.replace("webviews", "www");
                if (thisDocUrl != tempDocUrl) {
                    thisDocUrl = tempDocUrl.split("/embedded")[0];
                }
                return thisDocUrl;
            };
            /* revert webview - END */
            <?php
            if ($baseUrl["analytics"]) {
                /* analytic functions */
            ?>
                var du_analytics = function() {
                    if (typeof <?php echo $du_myGaFunctionName; ?> == "undefined") {
                        return false;
                    }
                    <?php echo $du_myGaFunctionName; ?>("create", "<?php echo $baseUrl["analytics"]; ?>", "auto");
                    <?php echo $du_myGaFunctionName; ?>("send", "pageview");
                    return true;
                };
                var du_analyticsClick = function(data) {
                    <?php echo $du_myGaFunctionName; ?>(
                        "send",
                        "event",
                        docUrl,
                        "<?php echo $projName["seo"]; ?>",
                        data,
                        clk++
                    );
                };
            <?php
            } else {
            ?>
                var du_analytics = function() {
                    alert("missing analytics code")
                }
                var du_analyticsClick = function(data) {
                    alert("missing analytics code \n" + data)
                }
            <?php
            }
            if ($baseUrl["php_setup"]["json"]) {
                /* loading json files */
                /*
                var c = btoa(worstDate); base64 encode
                var x = atob(c); base64 decode
                */
            ?>
                var getjson = function(headerData, runOk, runKo) {
                    jq.ajax({
                        type: "POST",
                        url: "<?php echo $baseUrl["php_setup"]["json"]; ?>return<?php echo $projName["_bodyId"]; ?>.json.php",
                        contentType: "application/x-www-form-urlencoded",
                        data: headerData,
                        dataType: "json",
                        success: function(response, status) {
                            // console.log(response)
                            // getJsonGeoData(runOk, runKo);
                            runOk(response, status);

                        },
                        error: function(response, status) {
                            runKo(response, status);
                        }
                    });
                };
                
                var getJsonGeoData = function(runOk, runKo) {
                    jq.ajax({
                        type: "GET",
                        timeout: 8000,
                        /* 2 seconds timeout*/
                        url: "<?php echo $baseUrl["php_setup"]["json"]; ?>du_burglaries_map.json",
                        jsonpCallback: "runData_<?php echo $projName["seo"]; ?>_map",
                        dataType: "jsonp",
                        success: function(response, status) {
                            // console.log(response)
                            runOk(response, status);
                        },
                        error: function(response, status) {
                            runKo(response, status);
                        }
                    });
                };
                var du_functionOk = function(response, status) {
                    wait(0);
                };
                var du_functionKo = function() {
                    alert(msg.error);
                    wait(0);
                };
            <?php } ?>
            /* LOAD CSS */
            var du_loadCssFile = function(filename) {
                var head = document.getElementsByTagName("head")[0];
                var link = document.createElement("link");
                link.rel = "stylesheet";
                link.type = "text/css";
                link.href = filename;
                link.media = "all";
                head.appendChild(link);
            };
            /* JQUERY - INI */
            <?php
            /* MAIN WIDGET - JS */
            $filesToLoad = array(
                "jq" => $baseUrl["js"] . "jquery-3.6.0.min.js",
                "xtra" => array()
            );
            if ($ui) {
                $filesToLoad["xtra"] = array(
                    $baseUrl["js"] . "jquery-ui.min.js",
                    $baseUrl["js"] . "jquery.ui.touch-punch.min.js"
                );
            };
            if ($supportClass) {
                $filesToLoad["xtra"][] = $baseUrl["supportClass"];
            };
            if ($newsletter) {
                $filesToLoad["xtra"][] = $baseUrl["newsletter"];
            };
            /* add any extra file that needs loading */
            $extraFilesToLoad = array(
                $baseUrl["js"] . "leaflet.js",
            );
            $filesToLoad["xtra"] = array_merge($filesToLoad["xtra"], $extraFilesToLoad);
            /** 
             * CSS's
             */
            $filesToLoad["css"] = array(
                "##tempFinalFile##" .  $IndexApp->getCssFilename() . $localCacheBust,
                $baseUrl["js"] . "leaflet.css"
            );
            ?>
            var tempJq = {
                "jquery": false,
                "temp": false,
                "loadNewJq": false
            };
            var startJq = function() {
                if (started) {
                    return true;
                }
                started = true;
                var filesToLoad = <?php echo json_encode($filesToLoad); ?>;
                /** CSS */
                for (let index = 0; index < filesToLoad.css.length; index++) {
                    du_loadCssFile(filesToLoad.css[index]);
                }
                /** JS */
                if (typeof $ === "undefined") {
                    tempJq.loadNewJq = true;
                } else if (typeof $.fn !== "undefined") {
                    if ($.fn.jquery !== "3.5.1") {
                        tempJq.temp = $.noConflict(true);
                        tempJq.loadNewJq = true;
                    }
                } else {
                    tempJq.loadNewJq = true;
                    tempJq.temp = $;
                }
                if (tempJq.loadNewJq) {
                    filesToLoad.xtra.unshift(filesToLoad.jq);
                }
                if (filesToLoad.xtra.length > 0) {
                    loadJS(filesToLoad.xtra, function() {
                        loadJSFinal();
                    });
                } else {
                    loadJSFinal();
                }
            };
            var loadJSFinal = function() {
                if (tempJq.loadNewJq) {
                    jq = $.noConflict(true);
                } else {
                    jq = $;
                }
                if (tempJq.temp) {
                    $ = tempJq.temp;
                } else {
                    $ = jq;
                }
                if (typeof $.fn !== "undefined") {
                    jQuery = $;
                }
                onReady();
            };
            var loadJS = function(srcArray, callback) {
                var src = srcArray.shift();
                var scriptTag = document.createElement("script");
                scriptTag.src = src;
                scriptTag.async = "async";
                scriptTag.onreadystatechange = scriptTag.onload = function() {
                    var state = scriptTag.readyState;
                    if (!callback.done && (!state || /loaded|complete/.test(state))) {
                        callback.done = true;
                        if (srcArray.length > 0) {
                            loadJS(srcArray, function() {
                                callback();
                            });
                        } else {
                            callback();
                        }
                    }
                };
                document.getElementsByTagName("head")[0].appendChild(scriptTag);
            };
            /* JQUERY - END */
            /* WAIT - INI */
            var wait = function(on) {
                if (on) {
                    jq(".du-wait", mainEl).show();
                } else {
                    jq(".du-wait", mainEl).hide();
                }
            };
            /* WAIT - END */
            /* wait to start - INI */
            startJq();
            /* wait to start - END */
        };
    };
</script>