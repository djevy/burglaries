<?php if (false) { ?><script>
        <?php } ?>
        /* widget related - INI */
        /* widget related - END */
        /* WIDGET FUNCTIONS - INI */
        var du_sliderRange = false;
        var du_sliderData = {};
        var currentMarker;

        var runWidgetBinds = function(response) {
            if (!response && response.length <= 0) {
                du_fatalError()
                return;
            }


            // console.log("Main Data:", du_mainData)

            jq("#du-search", mainEl).keypress(function(e) {
                if (e.which == 13) {
                    jq("#du-search-go", mainEl).click();
                    jq(this).blur();
                }
            });
            jq("#du-search-go", mainEl).click(function() {
                var postcode = jq("#du-search", mainEl).val();
                <?php if ($newsletter) { ?>
                    /* move to where applies */
                    /******** add newsletter ********/
                    if (du_newsletterClass) {
                        du_newsletterClass.showForm();
                        du_newsletterClass.addPostcode(postcode);
                    }
                    /***************************/
                    du_usePostcode((jq("#du-search", mainEl).val()));
                <?php } ?>
                // du_analyticsClick("clicked: " + postcode);
                // alert(jq("#du-search", mainEl).val());

                clicked = false;
                clickedLayer = false;
            });
            jq(".du-banner", mainEl).css("visibility", "visible");
            /* .css() instead of .show(), might fail if css not loaded yet */
            jq("#du-widget .du-container", mainEl).css("display", "block");
            jq("#du-results", mainEl).css("display", "block");

            // console.log(response)
            du_mapLoad(response);
            // console.log("Main Data:", du_mainData)

            wait(0);
        };
        var addArea = function(clicked, clickLa) {
            // console.log(du_mainData["areas"])
            if (du_mainData["areas"] !== undefined) {
                // console.log(du_postcodeData.code.la)
                areas = du_mainData["areas"];
                // console.log(areas)
            } else {
                du_error(du_msg.data);
            }
            // console.log(areas)

            Object.keys(areas).forEach(area => {
                area = areas[area]
                // console.log(area)
                // console.log(area.Lat, area.Long)
                addMarker(area.Lat, area.Long, {
                        name: area["HoC Name"],
                        "2020-21": area["2020-21"],
                        "2021-22": area["2021-22"],
                        rank: area["Rank"],
                        rate: area["Rate per 1000"]
                    },
                    area)
            });
            clicked = false;
        }
        var du_updateArea = function(res, code) {
            du_postcodeData = {
                code: code,
                res: res
            };


            jq("#du-widget .du-container", mainEl).fadeIn();
            du_support.du_scrollPage(jq("#du-widget", mainEl).offset().top, 1000);

            <?php if ($newsletter) { ?>
                if (du_newsletterClass) {
                    du_newsletterClass.showForm();
                }
            <?php } ?>

            wait(0);
        };


        var du_error = function(e) {
            alert(e);
            wait(0);
        };
        var du_fatalError = function(err) {
            var message = du_msg.error;

            <?php if ($local) { ?>
                console.log(err.responseText);
            <?php } ?>

            jq("#du-header .du-text, #du-search-box,#du-widget", mainEl).remove();
            jq("#du-row-error", mainEl).show();
            wait(0);
        };

        var du_usePostcode = function(address) {
            address = du_support.checkPostCode(du_support.du_myTrim(address));

            oldSearch = address;

            if (address) {
                // du_analyticsClick(address.split(" ")[0]);
                jq("#du-search", mainEl).val(address);
                wait(1);

                if (typeof used[address] != "undefined") {
                    du_validateData(used[address], address);
                    return;
                }

                var add = address;
                if (typeof btoa == "function") {
                    add = btoa(address);
                }

                var headerData = {
                    type: "<?php echo $projName["seo"]; ?>",
                    vers: "2022",
                    info: address
                };

                getjson(headerData, du_validateData, du_fatalError);
            } else {
                du_error(du_msg.postcode);
            }
        };
        var du_validateData = function(res, address) {
            if (typeof res.error != "undefined") {
                du_error(res.error);
                return false;
            }
            if (typeof res == "undefined") {
                du_error(du_msg.error);
                return false;
            }
            if (typeof res["res"] == "undefined" || res["res"] == null || !res["res"]) {
                du_error(du_msg.error);
                return false;
            }
            if (typeof res["code"] == "undefined" || res["code"] == null || !res["code"]) {
                du_error(du_msg.error);
                return false;
            }

            <?php if ($newsletter) { ?>
                if (du_newsletterClass) {
                    du_newsletterClass.addPostcode(oldSearch);
                }
            <?php } ?>

            used[oldSearch] = res;
            du_updateArea(res.res, res.code);

            du_mainData = res.res
            // console.log(du_mainData)
            // console.log(du_postcodeData.code.la)

            removeMarker();
            removePolygon();
            addArea();

            // console.log(res.code)
            currentLAD = res.code["la"];
            highlightSearch()

        };
        var highlightSearch = function() {
            var layers = du_geoLayer._layers;
            Object.keys(layers).forEach(layer => {
                layer = layers[layer]
                // console.log(layer.feature.properties.LAD)
                if (layer.feature.properties.LAD == currentLAD) {
                    addSearch(layer.feature.geometry.coordinates[0]);
                    setMapView(layer._bounds._northEast, layer._bounds._southWest);
                }
            });
        }
        var ordinal_suffix_of = function(i) {
            var j = i % 10,
                k = i % 100;
            if (j == 1 && k != 11) {
                return du_support.addCommas(i) + "st";
            }
            if (j == 2 && k != 12) {
                return du_support.addCommas(i) + "nd";
            }
            if (j == 3 && k != 13) {
                return du_support.addCommas(i) + "rd";
            }
            return du_support.addCommas(i) + "th";
        }
        var du_buildTable = function(area, data) {
            // console.log(data)
            var keyImage = function(keys, id) {
                for (i = 0; i < keys; i++) {
                    jq(`#du-crimes-${id}`).append('<img class="du-icon du-icon-crime" src="<?php echo $IndexApp->formatImageUrl("img", "du" . $projName["_bodyId"] . "_key_icon.png"); ?>" alt="Key">')
                }
            }
            jq("#du-table-holder").show();
            jq("#du-table-body").empty();
            jq("#du-table-body").append(`                            
                    <span class="du-table-row"><span class="du-table-cell du-row-header">Jun 2021 May 2022</span><span class="du-table-cell du-data-crimes" id="du-crimes-2021-22"></span><span class="du-table-cell du-data-qty">${data["2021-22"]}</span></span>
                    <span class="du-table-row"><span class="du-table-cell du-row-header">Jun 2020 May 2021</span><span class="du-table-cell du-data-crimes" id="du-crimes-2020-21"></span><span class="du-table-cell du-data-qty">${data["2020-21"]}</span></span>
            `)
            keyImage(data["2021-22"], "2021-22");
            keyImage(data["2020-21"], "2020-21");
        }

        var du_animateSlider = function(area, data) {
            var percentChange = function(num) {
                if(num < 0) {
                    return "decrease";
                } else {
                    return "increase";
                }
            }
            jq("#du-slider-container").empty();
            jq("#du-slider-container").append(`                
                <div class="du-section du-section-slider">
                    <div class="du-text du-bottom-line""><span class="du-slider-title">${area}</span></div>
                    <div class="du-text">This area has seen a <span class="du-bold-data">${Math.abs(data.Change*100).toFixed(1)}%</span> <span>${percentChange(data.Change)}</span> in reported burglaries in 2021-22 compared to 2020-21. It is ranked <span class="du-bold-data">${ordinal_suffix_of(data.Rank)}</span> out of 6,854 in terms of reported burglaries. </div>
                    <div class="du-slider">
                        <img id="du-slider-background" alt="<?php echo $projName["headerAlt"]; ?>" src="<?php echo $IndexApp->formatImageUrl("img", "du" . $projName["_bodyId"] . "_slider.png"); ?>" />
                        <div id="du-slider-text"><span>Least</span><span>Most</span></div>

                        <div id="du-slider-handle" class="du-slider-handle">

                            <div id="du-slider-banner"><img class="du-slider-logo" alt="<?php echo $projName["headerAlt"]; ?>" src="<?php echo $IndexApp->formatImageUrl("img", "du" . $projName["_bodyId"] . "_icon.png"); ?>" /></div>
                            <div id="du-slider-line"></div>
                            <div id="du-slider-dot"></div>
                        </div>
                    </div>
                </div>`)


            var max = 1;
            var min = 6854;
            var minRange = 0 - (jq("#du-slider-banner", mainEl).innerWidth() / 2)
            // console.log(minRange)
            var maxRange = jq("#du-slider-background", mainEl).innerWidth() - (jq("#du-slider-banner", mainEl).innerWidth() / 2);
            // console.log(maxRange)
            var sliderPos = du_support.du_calculatePosPercentage(data.Rank, min, max, minRange, maxRange);
            // console.log(sliderPos)
            jq("#du-slider-handle", mainEl).css("left", du_sliderRange.min);
            // console.log(data)
            setTimeout(function() {
                jq("#du-slider-handle", mainEl).animate({
                    left: sliderPos + "px"
                }, {
                    duration: 2000,
                    easing: 'swing'
                });
            }, 500);

        };
        /* WIDGET FUNCTIONS - END */