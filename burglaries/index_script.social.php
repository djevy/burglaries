<?php if (false) { ?><script>
        <?php } ?>
        /* social - INI */
        <?php
        $social = $socialItems["toScript"];
        $social["jqTemp"] = "";
        $social["FBappID"] = false;
        $social["via"] = false;
        ?>
        let social = <?php echo json_encode($social); ?>;
        var du_socialStartBtns = function() {
            let btns = <?php echo json_encode($socialItems["btns"]); ?>;
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
                    <?php if (true) { ?>
                    default:
                        alert("SOCIAL button missing configuration in script file");
                        break;
                    <?php } ?>
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
        /* social - END */