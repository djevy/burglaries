
        if (!du_burglaries_bls_widget) {
        var du_burglaries_bls_widget = function() {
            document.getElementById("du-wait-bls").className = "du-wait";
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
            var baseHtml = "<div id=\"du-main-header\" class=\"du-header\"><div class=\"du-container\"><img class=\"du-header-img\" alt=\"burglaries\" src=\"https://static.trinitymirrordataunit.com/img/burglaries/du_bls_header.png\" /><div class=\"du-text\">How many burglary cases were reported in your area? </div><div class=\"du-text\">Enter your details below to find out</div><div id=\"du-search-box\"><input type=\"text\" name=\"du-search\" id=\"du-search\" maxlength=\"15\" placeholder=\"Type your postcode\" /><button type=\"button\" id=\"du-search-go\">Search</button></div></div></div><div id=\"du-widget\"><div class=\"du-container\"><!-- <div id=\"du-comparison-bar\"></div> --><div id=\"du-mapContainer\"><div id=\"du-canvas\"></div></div><div id=\"du-slider-container\"></div><div id=\"du-table-holder\"><div id=\"du-result-table\" class=\"du-table\"><span class=\"du-table-head\"><span class=\"du-table-row\"><span class=\"du-table-cell du-row-header\"> Period </span><span class=\"du-table-cell\">Number of burglaries</span></span></span><span class=\"du-table-body\" id=\"du-table-body\"></span></div><div class=\"du-data-note du-table-footnote\" style=\"display: none;\"></div></div></div><div class=\"du-footer\"><div class=\"du-text\" id=\"du-footnote\">*Figures exclude Greater Manchester, due to incomplete data.</div><div class=\"du-container\"><ul id=\"du-social-holder\"><li class=\"du-social-box\"><a class=\"du-social-btn du-btn\" target=\"_blank\" href=\"\" title=\"\"><span></span></a></li></ul></div></div></div><div class=\"du-nlf-holder\"></div>";
                            /******** add Support Class ********/
                var du_support = false;
                /******** add Support Class ********/
                                        /******** add newsletter Class ********/
                var widgetID = "burglaries";
                var du_newsletterClass = false;
                /******** add newsletter Class ********/
                        var onReady = function() {
                mainEl = jq("#du-proj-burglaries.du-body");
                jq(window).resize(function() {
                    if (main.resizeTO) {
                        clearTimeout(main.resizeTO);
                    }
                    main.resizeTO = setTimeout(function() {
                        jq(this).trigger("du-resizeEnd-bls");
                    }, 150);
                });
                jq(window).bind("du-resizeEnd-bls", function() {
                    main.du_checkParentSize();
                });
                /* onReady for widget - INI */
                jq("#du-widget-body", mainEl).html(baseHtml);
                                    /******** add Support Class ********/
                    du_support = new du_support_fc(jq);
                    /*
                     console.log(du_support.addCommas(90999))
                     console.log(du_support.checkPostCode("dsafsdf"))
                     console.log(du_support.checkPostCode("m217pg"))
                     */
                    /******** add Support Class ********/
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
                                                        /** style -> light / dark */
                                                        /**  send to analytics **/
                                                        /**  if there"s a callback after newsletter submitted **/
                                                    };
                        /**  if there"s a default newsletter for the widget **/
                                                    du_newsletterOptions.nl = "iya";
                                                du_newsletterClass = new du_newsletter(du_newsletterOptions);
                    }
                    /******** add NEWSLETTER ********/
                
                /* onReady for widget - END */
                /* inicio  */
                /*
                 var address = "**** ***";
                 if (typeof btoa == "function") {
                    address = btoa(address);
                 }
                 var headerData = {
                    type: "burglaries",
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
                                    du_socialStartBtns();
                                getJsonGeoData(runWidgetBinds, du_fatalError);
                main.du_checkParentSize();
            };
            /* WIDGET FUNCTIONS - INI */
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
                                    /* move to where applies */
                    /******** add newsletter ********/
                    if (du_newsletterClass) {
                        du_newsletterClass.showForm();
                        du_newsletterClass.addPostcode(postcode);
                    }
                    /***************************/
                    du_usePostcode((jq("#du-search", mainEl).val()));
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

                            if (du_newsletterClass) {
                    du_newsletterClass.showForm();
                }
            
            wait(0);
        };


        var du_error = function(e) {
            alert(e);
            wait(0);
        };
        var du_fatalError = function(err) {
            var message = du_msg.error;

            
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
                    type: "burglaries",
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

                            if (du_newsletterClass) {
                    du_newsletterClass.addPostcode(oldSearch);
                }
            
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
                    jq(`#du-crimes-${id}`).append('<img class="du-icon du-icon-crime" src="https://static.trinitymirrordataunit.com/img/burglaries/du_bls_key_icon.png" alt="Key">')
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
                        <img id="du-slider-background" alt="burglaries" src="https://static.trinitymirrordataunit.com/img/burglaries/du_bls_slider.png" />
                        <div id="du-slider-text"><span>Least</span><span>Most</span></div>

                        <div id="du-slider-handle" class="du-slider-handle">

                            <div id="du-slider-banner"><img class="du-slider-logo" alt="burglaries" src="https://static.trinitymirrordataunit.com/img/burglaries/du_bls_icon.png" /></div>
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
        /* WIDGET FUNCTIONS - END */            /* WIDGET FUNCTIONS - END */


            // Support Classes:
            
        var du_map, du_geoLayer, du_tileLayer, du_userIcon = false;
        var du_markers = [];
        var polygonLayer = [];
        var osm = {
            'tl': 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'at': '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            'z': 19
        };

        function du_mapLoad(data) {
            du_map = L.map('du-canvas').setView([54.5, -3], 5);
            if (!du_tileLayer) {
                du_tileLayer = L.tileLayer(osm.tl, {
                    attribution: osm.at,
                    maxZoom: osm.z
                })
            }
            du_map.addLayer(du_tileLayer);
            du_geoData(data);
            icons();
        }

        function du_geoData(data) {
            if (du_geoLayer) {
                du_map.removeLayer(du_geoLayer);
                du_geoLayer = false;
            }

            du_geoLayer = L.geoJson(data, {
                style: du_setMapStyle,
                onEachFeature: du_mapOnEachFeature
            }).addTo(du_map);
        }

        function du_setMapStyle() {
            var opacity = 0.4
            return {
                weight: 2,
                color: "#000",
                opacity: opacity,
                fillColor: "#de6e18",
                fillOpacity: opacity
            }
        }

        function du_mapOnEachFeature(feature, layer) {
            layer.on('click', function(e) {
                // removeMarker();
                clickedLayer = feature.properties.LAD;
                // console.log(clickedLayer)
                // addArea(true, clickedLayer);
            });
        }

        function icons() {
            removeMarker()
            var data = {
                user: `https://static.trinitymirrordataunit.com/img/burglaries/du_bls_icon.png`,
                iSize: [30, 30],
                iAnchor: [15, -15]
            }

            var iconOptions = L.Icon.extend({
                options: {
                    iconSize: data.iSize,
                    iconAnchor: data.iAnchor
                }
            });
            du_userIcon = new iconOptions({
                iconUrl: data.user
            });
        }

        function addMarker(lat, long, toolText, data) {
            var popup = L.popup()
                .setContent(`<b>${toolText.name}</b>
                            <p>Reported burglaries in 2021-22: <span class="du-bold-data">${toolText["2021-22"]}</span></p> 
                            <p>Reported burglaries in 2020-21: <span class="du-bold-data">${toolText["2020-21"]}</span></p> 
                            <p>Rank: <span class="du-bold-data">${ordinal_suffix_of(toolText.rank)}</span></p> 
                            `);

            var marker = L.marker([lat, long], {
                    icon: du_userIcon
                })
                .addTo(du_map)
            marker.bindPopup(popup, {
                permanent: true,
                className: "du-popup",
                area: toolText.name,
                rank: toolText.rank,
                data: data,
                "2020-21": toolText["2020-21"],
                "2021-22": toolText["2021-22"]
            }).on('click', clickZoom);
            du_markers.push(marker)
            // setMapView(lat, long)
        }

        function removeMarker() {
            du_markers.forEach(marker => {
                du_map.removeLayer(marker);
            });
            du_markers = [];
        }

        function setMapView(Lat, Long) {
            // du_map.setView([Lat, Long], 10);
            du_map.fitBounds([Lat, Long]);
            // du_map.setMaxBounds([Lat, Long]);
        }

        function clickZoom(e) {
            du_map.setView(e.target.getLatLng(), 11);
            // console.log(e.target)
            du_animateSlider(e.target._popup.options.area, e.target._popup.options.data);
            du_buildTable(e.target._popup.options.area, e.target._popup.options.data)
            jq("#du-2020-21", mainEl).text(e.target._popup.options["2020-21"]);
            jq("#du-2021-22", mainEl).text(e.target._popup.options["2021-22"]);
        }

        function addSearch(area) {
            var correctOrder = [];
            // console.log(Array.isArray(area))
            area.forEach(set => {
                correctOrder.push([set[1], set[0]])
            })
            var polygon = L.polygon(
                correctOrder
            ).setStyle({color: '#363b59'}).addTo(du_map);

            polygonLayer.push(polygon);
        }

        function removePolygon() {
            polygonLayer.forEach(layer => {
                du_map.removeLayer(layer);
            });
            polygonLayer = [];
        }                    /* social - INI */
                let social = {"message":"I just used the Burglaries interactive on ","hash":"reachDataUnit,Burglaries","jqTemp":"","FBappID":false,"via":false};
        var du_socialStartBtns = function() {
            let btns = ["Facebook","Twitter","WhatsApp"];
            let addedButtons = false;
            social.FBappID = du_socialGetFBappID();
            social.via = du_socialGetTwitterVia();
            social.jqTemp = jq(".du-social-box", mainEl).clone();
            jq(".du-social-box", mainEl).remove();
            for (const btnKey in btns) {
                if (!btns.hasOwnProperty(btnKey)) {
                    continue;
                }
                const thisBtn = btns[btnKey];
                if (
                    thisBtn == "Facebook" &&
                    !social.FBappID
                ) {
                    continue;

                }
                let newBtn = du_socialCreateBtn(thisBtn);
                if (newBtn) {
                    addedButtons = true;
                    jq("#du-social-holder", mainEl).append(newBtn);
                }
            }
            if (addedButtons) {
                jq("#du-social-holder", mainEl)
                    .addClass("du-ok");
            } else {
                jq("#du-social-holder", mainEl)
                    .remove();
            }
        }
        var du_socialCreateBtn = function(btnType) {
            let jqNewBtn = social.jqTemp.clone();
            let options = du_socialCreateBtnOptions(btnType);
            jq("a", jqNewBtn)
                .attr({
                    "id": options.id,
                    "title": options.title,
                    "href": options.href
                })
                .on("click", function() {
                    du_analyticsClick(jq(this).attr("id"));
                })
                .find("span")
                .text(options.title);

            return jqNewBtn;
        }
        var du_socialCreateBtnOptions = function(btnType) {
            let thisTitle = "Share on " + btnType;
            switch (btnType) {
                case "Twitter":
                    finalHref = "https://twitter.com/intent/tweet?" +
                        "text=" + encodeURIComponent(social.message) +
                        "&url=" + encodeURIComponent(docUrl);
                    if (
                        typeof social.hash != "undefined" &&
                        social.hash
                    ) {
                        finalHref += "&hashtags=" + encodeURIComponent(social.hash);
                    }
                    if (
                        typeof social.via != "undefined" &&
                        social.via
                    ) {
                        finalHref += "&via=" + encodeURIComponent(social.via);
                    }
                    break;
                case "Facebook":
                    finalHref = "https://www.facebook.com/dialog/feed?" +
                        "&app_id=" + social.FBappID +
                        "&link=" + encodeURIComponent(docUrl) +
                        "&redirect_uri=" + encodeURIComponent(docUrl);
                    break;
                case "WhatsApp":
                    finalHref = "https://api.whatsapp.com/send?" +
                        "&text=" + encodeURIComponent(
                            social.message +
                            docUrl
                        );
                    break;
                                        default:
                        alert("SOCIAL button missing configuration in script file");
                        break;
                                }
            return {
                "title": thisTitle,
                "href": finalHref,
                "id": "du-btn-social-" + du_support.classFriendly(btnType)
            }
        }
        var du_socialGetTwitterVia = function() {
            var res = false;
            switch (true) {
                case (!!jq("meta[name='twitter:site']").attr("value")):
                    res = jq("meta[name='twitter:site']").attr("value");
                    if (res) {
                        res = res.replace('@', '');
                    }
                    break;
            }
            return res;
        }
        var du_socialGetFBappID = function() {
            var res = false;
            switch (true) {
                case (!!jq("meta[property='fb:app_id']").attr("content")):
                    res = jq("meta[property='fb:app_id']").attr("content");
                    break;
                case (!(typeof TMCONFIG == 'undefined' || typeof TMCONFIG.facebook == 'undefined' || typeof TMCONFIG.facebook.appId == 'undefined')):
                    res = TMCONFIG.facebook.appId;
                    break;
            }
            return res;
        }
        /* social - END */            /* checksize - INI */
            this.du_checkParentSize = function() {
                var jqMain = jq(mainEl);
                var jqPai = jq(mainEl).parent();
                                    if (jqPai.width() > 618) {
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
                            var du_analytics = function() {
                    alert("missing analytics code")
                }
                var du_analyticsClick = function(data) {
                    alert("missing analytics code \n" + data)
                }
                            var getjson = function(headerData, runOk, runKo) {
                    jq.ajax({
                        type: "POST",
                        url: "https://www.trinitymirrordataunit.com/burglaries/return_bls.json.php",
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
                        url: "https://www.trinitymirrordataunit.com/burglaries/du_burglaries_map.json",
                        jsonpCallback: "runData_burglaries_map",
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
                var filesToLoad = {"jq":"https:\/\/static.trinitymirrordataunit.com\/js\/jquery-3.6.0.min.js","xtra":["https:\/\/static.trinitymirrordataunit.com\/js\/jquery-ui.min.js","https:\/\/static.trinitymirrordataunit.com\/js\/jquery.ui.touch-punch.min.js","https:\/\/static.trinitymirrordataunit.com\/js\/du_support_fc_script.min.js","https:\/\/static.trinitymirrordataunit.com\/js\/du_newsletter.min.js","https:\/\/static.trinitymirrordataunit.com\/js\/leaflet.js"],"css":["https://static.trinitymirrordataunit.com/img/burglaries/du_burglaries.min.css","https:\/\/static.trinitymirrordataunit.com\/js\/leaflet.css"]};
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
