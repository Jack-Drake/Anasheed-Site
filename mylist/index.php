<?php
//retrieve the content.json file
$file = file_get_contents("../content.json");

//parse the file into an associative array aka be able to use names
$songs_list = json_decode($file, true);

$mylist = "";
?>
<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="../css/materialize.css">
    <link rel="stylesheet" href="https://unpkg.com/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    
    <!-- Compiled and minified JavaScript -->
    <script src="../js/materialize.js"></script>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- STYLE TAG -->
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        #pdf-js-viewer {
            width: 100%;
            height: 90%;
        }

        #viewsong {
            width: 100% !important;
            height: 100% !important;
            top: 0% !important;
        }

        .modal {
            max-height: 100% !important;
        }
        
        .song_box:hover{
            background-color:whitesmoke;
        }
        .song_box{
            border:2px solid #f8f9fa;
        }
    </style>

    <!-- SEO INFORMATION -->
    <link rel="icon" type="image/ico" href="../images/favicon-32x32.png">
    <title>Anasheed - My List</title>
</head>

<body>
    <!-- NAVIGATION MENU -->
    <header id="navigation_menu">
        <nav class="nav-extended" style="background-color:#0376bc;">
            <div class="nav-wrapper">
                <a href="../" class="brand-logo"><img style="width:5rem;padding-left:10px;" src="../images/Anasheed-favicon-white.png"></a>
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="../mylist">My List</a></li>
                    <!--<li><a href="../contact">Contact</a></li>-->
                </ul>
            </div>
        </nav>
        <ul id="slide-out" class="sidenav">
            <li style="text-align:center;margin-bottom:-2rem;"><img style="width:5rem;" src="../images/Anasheed-favicon-outline.png"></li>
            <li>
                <div class="divider"></div>
            </li>
            <li><a href="../">Home</a></li>
            <li><a href="../mylist">My List</a></li>
            <li><a href="../contact">Contact</a></li>
        </ul>
    </header>

    <main>
        <div class="container">
            <h4>My List</h4>
        </div>
        <!-- SONGS DIV -->
        <div id="songs_div" class="container" style="margin-top:5rem;">
            <!-- ALL SONGS ROW DIV - HIDDEN WHEN SEARCHING -->
            <?php
                if(isset($_COOKIE['loc']) && !empty($_COOKIE['loc'])){
                    echo '<div id="all_songs"><ul id="songs_larger_ul">';
                    $mylist = explode(',', $_COOKIE['loc']);
                    //var_dump($mylist);

                    for($i = 0; $i < count($mylist) - 1; $i++){
                        echo "<li><div class='song_box' style='padding:10px!important;margin-bottom:10px;'>
                                <div>
                                    <div class='row' style='margin-bottom:0;margin-left:0;padding:0;text-align:center;width:100%;height:100%;'>
                                        <div class='col s1' style='height:100%;'>
                                            <a class='' style='color:black;font-size:25px;text-decoration:none;'><i style='cursor:move;' class='handle ti ti-drag-drop'></i></a>
                                        </div>
                                        <div class='col s1' style='height:100%;cursor:pointer;'>
                                            <a style='color:black;font-size:25px;text-decoration:none;' id='" . $mylist[$i] . "' onclick='removeSongCookie(" . $mylist[$i] . ")'><i style='cursor:pointer;' class='ti ti-trash'></i></a>
                                        </div>
                                        <div class='col s1' style='height:100%;cursor:pointer;'>
                                            <a style='color:black;font-size:25px;text-decoration:none;' class='modal-trigger' onclick='setSong(" . $mylist[$i] . ")' href='#viewsong'><i style='cursor:pointer;' class='ti ti-eye'></i></a>
                                        </div>
                                        <div class='col s9' style='height:100%;text-align:right;'>
                                            <a style='color:black;padding:0;font-size:25px;'>".$songs_list[$mylist[$i]]."</a>
                                        </div>
                                    </div>
                                </div>
                            </div></li>";
                    }
                    
                    echo "</ul></div>";
                }else{
                    echo "<div class='container' style='color:gray;text-align:center;'>
                            <h5>Your My List is empty, begin by adding a song</h5>
                          </div>";
                }
            ?>
        </div>

        <!-- MODAL FOR DISPLAYING THE SONG -->
        <div id="viewsong" class="modal modal-fixed-footer" style="">
            <div class="modal-content" id="head_modal" style="text-align:center;overflow:hidden;padding:0;">
                <div class="row" style="margin-bottom:-10px;">
                    <div class="col s1" style="padding-top:20px;">
                        <button class="modal-close btn-flat" style="text-align:left!important;"><i class="material-icons" style="font-size:2rem;">close</i></button>
                    </div>
                    <div class="col s11">
                        <h4 style="text-align:right;padding:15px;" id="song_title">Song Title</h4>
                    </div>
                </div>
                <hr>
                <iframe id="pdf-js-viewer" src="" title="webviewer" frameborder="0"></iframe>
            </div>
            <div class="modal-footer" id="controls" style="">
                <!-- LEFT SIDE OF FOOTER MODAL -->
                <div class="row">
                    <div class="col s6" style="text-align:left;">
                        <button value="#" onclick="setSong(this.value);" id="previous_song" class="btn-flat" style="text-align:center!important;"><i class="material-icons" style="font-size:3rem;">chevron_left</i></button>
                    </div>
                    <div class="col s6" style="text-align:right;">
                        <button value="#" onclick="setSong(this.value);" id="next_song" class="btn-flat" style="text-align:center!important;"><i class="material-icons" style="font-size:3rem;">chevron_right</i></button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER DIV -->
    <footer class="page-footer" style="background-color:#0376bc;">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">Anasheed</h5>
                    <p class="grey-text text-lighten-4">The best place to find your favorite Nasheed.<br>Let us know if we are missing something by<br>contacting us.</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Links</h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="../">Home</a></li>
                        <li><a class="grey-text text-lighten-3" href="../mylist">My List</a></li>
                        <li><a class="grey-text text-lighten-3" href="../contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © <?php echo date('Y'); ?> Copyright Anasheed
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        //hide for modal
        document.getElementById('pdf-js-viewer').onclick = function(){
            //hide elements if not hidden
            if(document.getElementById('head_modal').style.display == "block" && document.getElementById('controls').style.display == "block"){
               document.getElementById('head_modal').style.display = "none";
               document.getElementById('controls').style.display = "none";
            }else{
                document.getElementById('head_modal').style.display = "block";
                document.getElementById('controls').style.display = "block";
            }
        };

        //set up the cookie to not get corrupted by google analyitcs
        window['ga-disable-UA-XXXXXXXX-X'] = true;

        //set the expiration value to be 14 days after setting the list
        var today = new Date();
        var expire = new Date();
        expire.setTime(today.getTime() + 3600000 * 24 * 14);

        //file for songs
        var file = '<?php echo json_encode($songs_list); ?>';
        var decoded_file = JSON.parse(file);

        //cookie for songs
        var cookie_array = getCookie('loc').split(",");
        cookie_array[0] = cookie_array[0].substr(4);

        //getCookie------------------------------------------------------------------------
        //
        // this function retrieves any cookies
        //
        //---------------------------------------------------------------------------------
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            return decodedCookie;
        }

        //removeSongCookie----------------------------------------------------------------------
        //
        // this function removes the cookie data for a specific song
        //
        //---------------------------------------------------------------------------------
        function removeSongCookie(loc) {
            //update the button
            document.getElementById(loc).innerHTML = "Add Song";
            document.getElementById(loc).style.backgroundColor = "#0376bc";
            document.getElementById(loc).setAttribute('onclick', 'setCookie(this, "' + loc + '");');

            //remove the number
            var cookieArray = (getCookie("loc").substring(4)).split(',');
            //console.log(cookieArray);
            var cookieString = "";

            //remove the song number and set the new cookie
            for (var i = 0; i < cookieArray.length - 1; i++) {
                //console.log(cookieString);
                //if the number patches then it remove it
                if (cookieArray[i] != loc) {
                    cookieString += cookieArray[i] + ",";
                }
            }

            //update the cookie
            console.log(cookieString);
            document.cookie = "loc=" + cookieString + "; " + "expires=" + expire.toGMTString() + "; path=/";

            //refresh the page
            location.reload();
        }

        //SETSONG--------------------------------------------------------------------------
        //
        // this function sets the song for modal that will display the text
        // the function takes in the number of the song from the content.json file order
        //---------------------------------------------------------------------------------
        function setSong(songNum) {
            if (songNum != "#") {
                //add a column
                document.getElementById('song_title').innerHTML = decoded_file[songNum];
                document.getElementById('pdf-js-viewer').src = "/web/viewer.html?file=/web/anasheed_pdf/anasheed_" + songNum + ".pdf";

                //get the previous values of the song num
                //alert(songNum);
                var temp_num = cookie_array.indexOf("" + songNum);
                //alert(songNum);

                if (temp_num <= 0) {
                    document.getElementById('previous_song').value = "#";
                } else {
                    document.getElementById('previous_song').value = cookie_array[temp_num - 1];
                }

                if (temp_num >= cookie_array.length - 2) {
                    document.getElementById('next_song').value = "#";
                } else {
                    document.getElementById('next_song').value = cookie_array[temp_num + 1];
                }
            }
        }
        
        //Sortable--------------------------------------------------------------------------
        //
        // this function sets the sortable to rearrange the songs
        // 
        //---------------------------------------------------------------------------------
        $('#songs_larger_ul').sortable({
            handle: ".handle",
            start: function(e, ui) {
                // creates a temporary attribute on the element with the old index
                $(this).attr('data-previndex', ui.item.index());
            },
            update: function(e, ui) {
                // gets the new and old index then removes the temporary attribute
                var newIndex = ui.item.index();
                var oldIndex = "" + $(this).attr('data-previndex');
                $(this).removeAttr('data-previndex');
                
                console.log(oldIndex);
                console.log(newIndex);
            }
        });

        //for side navigation menu
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.sidenav');
            var instances = M.Sidenav.init(elems);
        });
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            var instances = M.Modal.init(elems, {
                dismissible: false
            });
        });

    </script>
</body>

</html>
