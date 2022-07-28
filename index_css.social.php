<?php if (false) { ?><style>
        <?php } ?>

        /******
        * Social
        */
        div#du-body.du-body #du-social-holder {
            display: none;
        }

        div#du-body.du-body #du-social-holder.du-ok {
            display: block;
        }

        div#du-body.du-body #du-social-holder .du-social-box {
            display: inline-block;
            margin: 1em 0.3em 0;
        }

        div#du-body.du-body #du-social-holder .du-social-box .du-social-btn {
            /*
            background: no-repeat scroll 0 0 <?php /* echo $colors["main"]; */ ?>;
            */
            background: no-repeat scroll 0 0 transparent;
            background-image: url("<?php echo $IndexApp->formatImageUrl("def_img", "du_social_sprite.png"); ?>");
            color: #fff;
            text-decoration: none;
            display: block;
            -webkit-border-radius: 7px;
            -moz-border-radius: 7px;
            border-radius: 7px;
            font-size: 15px;
            padding: 0;
            height: 57px;
            width: 55px;
        }

        div#du-body.du-body #du-social-holder .du-social-box #du-btn-social-facebook {
            /* background-color: #4267B2; */
            background-position: 0 0;
        }

        div#du-body.du-body #du-social-holder .du-social-box #du-btn-social-twitter {
            /* background-color: #1D9BF0; */
            background-position: 0 -120px;
        }

        div#du-body.du-body #du-social-holder .du-social-box #du-btn-social-whatsapp {
            /* background-color: #25D366; */
            background-position: 0 -180px;
        }

        div#du-body.du-body #du-social-holder .du-social-box .du-social-btn span {
            display: none;
        }