<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <!-- Website Design By: www.happyworm.com -->
    <title>Demo : jPlayer as video playlist</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <link href="https://www.jplayer.org/css/jPlayer.css" rel="stylesheet" type="text/css" />
    <link href="https://www.jplayer.org/js/prettify/prettify-jPlayer.css" rel="stylesheet" type="text/css" />
    <link href="_css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="https://www.jplayer.org/latest/lib/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jplayer.org/latest/dist/jplayer/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="https://www.jplayer.org/latest/dist/add-on/jplayer.playlist.min.js"></script>
    <script type="text/javascript" src="https://www.jplayer.org/latest/dist/add-on/jquery.jplayer.inspector.min.js"></script>
    <script type="text/javascript" src="https://www.jplayer.org/js/themeswitcher.js"></script>
    <script type="text/javascript">
        //<![CDATA[
        $(document).ready(function() {

            new jPlayerPlaylist({
                jPlayer: "#jquery_jplayer_1",
                cssSelectorAncestor: "#jp_container_1"
            }, [{
                    title: "Big Buck Bunny Trailer",
                    artist: "Blender Foundation",
                    free: true,
                    m4v: "http://www.jplayer.org/video/m4v/Big_Buck_Bunny_Trailer.m4v",
                    ogv: "http://www.jplayer.org/video/ogv/Big_Buck_Bunny_Trailer.ogv",
                    webmv: "http://www.jplayer.org/video/webm/Big_Buck_Bunny_Trailer.webm",
                    poster: "http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png"
                },
                {
                    title: "Finding Nemo Teaser",
                    artist: "Pixar",
                    m4v: "http://www.jplayer.org/video/m4v/Finding_Nemo_Teaser.m4v",
                    ogv: "http://www.jplayer.org/video/ogv/Finding_Nemo_Teaser.ogv",
                    webmv: "http://www.jplayer.org/video/webm/Finding_Nemo_Teaser.webm",
                    poster: "http://www.jplayer.org/video/poster/Finding_Nemo_Teaser_640x352.png"
                },
                {
                    title: "Incredibles Teaser",
                    artist: "Pixar",
                    m4v: "http://www.jplayer.org/video/m4v/Incredibles_Teaser.m4v",
                    ogv: "http://www.jplayer.org/video/ogv/Incredibles_Teaser.ogv",
                    webmv: "http://www.jplayer.org/video/webm/Incredibles_Teaser.webm",
                    poster: "http://www.jplayer.org/video/poster/Incredibles_Teaser_640x272.png"
                }
            ], {
                swfPath: "https://www.jplayer.org/latest/dist/jplayer",
                supplied: "webmv, ogv, m4v",
                useStateClassSkin: true,
                autoBlur: false,
                smoothPlayBar: true,
                keyEnabled: true
            });


            new jPlayerPlaylist({
                jPlayer: "#jquery_jplayer_2",
                cssSelectorAncestor: "#jp_container_2"
            }, [{
                    title: "Cro Magnon Man",
                    mp3: "http://www.jplayer.org/audio/mp3/TSP-01-Cro_magnon_man.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/TSP-01-Cro_magnon_man.ogg"
                },
                {
                    title: "Your Face",
                    mp3: "http://www.jplayer.org/audio/mp3/TSP-05-Your_face.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/TSP-05-Your_face.ogg"
                },
                {
                    title: "Cyber Sonnet",
                    mp3: "http://www.jplayer.org/audio/mp3/TSP-07-Cybersonnet.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/TSP-07-Cybersonnet.ogg"
                },
                {
                    title: "Tempered Song",
                    mp3: "http://www.jplayer.org/audio/mp3/Miaow-01-Tempered-song.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/Miaow-01-Tempered-song.ogg"
                },
                {
                    title: "Hidden",
                    mp3: "http://www.jplayer.org/audio/mp3/Miaow-02-Hidden.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/Miaow-02-Hidden.ogg"
                },
                {
                    title: "Lentement",
                    free: true,
                    mp3: "http://www.jplayer.org/audio/mp3/Miaow-03-Lentement.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/Miaow-03-Lentement.ogg"
                },
                {
                    title: "Lismore",
                    mp3: "http://www.jplayer.org/audio/mp3/Miaow-04-Lismore.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/Miaow-04-Lismore.ogg"
                },
                {
                    title: "The Separation",
                    mp3: "http://www.jplayer.org/audio/mp3/Miaow-05-The-separation.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/Miaow-05-The-separation.ogg"
                },
                {
                    title: "Beside Me",
                    mp3: "http://www.jplayer.org/audio/mp3/Miaow-06-Beside-me.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/Miaow-06-Beside-me.ogg"
                },
                {
                    title: "Bubble",
                    free: true,
                    mp3: "http://www.jplayer.org/audio/mp3/Miaow-07-Bubble.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/Miaow-07-Bubble.ogg"
                },
                {
                    title: "Stirring of a Fool",
                    mp3: "http://www.jplayer.org/audio/mp3/Miaow-08-Stirring-of-a-fool.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/Miaow-08-Stirring-of-a-fool.ogg"
                },
                {
                    title: "Partir",
                    free: true,
                    mp3: "http://www.jplayer.org/audio/mp3/Miaow-09-Partir.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/Miaow-09-Partir.ogg"
                },
                {
                    title: "Thin Ice",
                    mp3: "http://www.jplayer.org/audio/mp3/Miaow-10-Thin-ice.mp3",
                    oga: "http://www.jplayer.org/audio/ogg/Miaow-10-Thin-ice.ogg"
                }
            ], {
                swfPath: "https://www.jplayer.org/latest/dist/jplayer",
                supplied: "oga, mp3",
                wmode: "window",
                useStateClassSkin: true,
                autoBlur: false,
                smoothPlayBar: true,
                keyEnabled: true
            });

            $("#jplayer_inspector_1").jPlayerInspector({
                jPlayer: $("#jquery_jplayer_1")
            });
            $("#jplayer_inspector_2").jPlayerInspector({
                jPlayer: $("#jquery_jplayer_2")
            });
        });
        //]]>
    </script>

    <!-- Flattr -->
    <script type="text/javascript">
        /* Flattr code for jPlayer.org */
        (function() {
            var s = document.createElement('script'),
                t = document.getElementsByTagName('script')[0];
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'http://api.flattr.com/js/0.6/load.js?mode=auto';
            t.parentNode.insertBefore(s, t);
        })();
    </script>
    <!-- End Flattr -->
</head>

<body class="demo" onload="prettyPrint();">
    <div id="container">
        <div id="content_main">
            <section>
                <div id="jp_container_1" class="jp-video jp-video-270p" role="application" aria-label="media player">
                    <div class="jp-type-playlist">
                        <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                        <div class="jp-gui">
                            <div class="jp-video-play">
                                <button class="jp-video-play-icon" role="button" tabindex="0">play</button>
                            </div>
                            <div class="jp-interface">
                                <div class="jp-progress">
                                    <div class="jp-seek-bar">
                                        <div class="jp-play-bar"></div>
                                    </div>
                                </div>
                                <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                                <div class="jp-controls-holder">
                                    <div class="jp-controls">
                                        <button class="jp-previous" role="button" tabindex="0">previous</button>
                                        <button class="jp-play" role="button" tabindex="0">play</button>
                                        <button class="jp-next" role="button" tabindex="0">next</button>
                                        <button class="jp-stop" role="button" tabindex="0">stop</button>
                                    </div>
                                    <div class="jp-volume-controls">
                                        <button class="jp-mute" role="button" tabindex="0">mute</button>
                                        <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value"></div>
                                        </div>
                                    </div>
                                    <div class="jp-toggles">
                                        <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                                        <button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
                                        <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                                    </div>
                                </div>
                                <div class="jp-details">
                                    <div class="jp-title" aria-label="title">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                        <div class="jp-playlist">
                            <ul>
                                <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                                <li>&nbsp;</li>
                            </ul>
                        </div>
                        <div class="jp-no-solution">
                            <span>Update Required</span>
                            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
</body>
<script>
    ! function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
            p = /^http:/.test(d.location) ? 'http' : 'https';
        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = p + '://platform.twitter.com/widgets.js';
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, 'script', 'twitter-wjs');
</script>
<script type="text/javascript" src="/js/prettify/prettify-jPlayer.js"></script>

</html>