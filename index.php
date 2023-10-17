<?php
error_reporting(0);
//retrieve the content.json file
$file = file_get_contents("content.json");

//parse the file into an associative array aka be able to use names
$songs_list = json_decode($file, true);

//compares the i to the cokkie values 1 by one
function check_i_with_cookie($i){
    if(isset($_COOKIE['loc'])){
        $cookie = explode(',', $_COOKIE['loc']);

        for($j = 0; $j < count($cookie) - 1; $j++){
            if($cookie[$j] == $i){
                return false;
            }
        }
    }
    return true;
}
?>
<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="css/materialize.css">
    <!-- Compiled and minified JavaScript -->
    <script src="js/materialize.js"></script>

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
            height: 100%;
        }

        #viewsong {
            width: 100% !important;
            height: 100% !important;
            top: 0% !important;
        }

        .modal {
            max-height: 100% !important;
        }
        
        @media only screen and (max-width: 800px) {
            .mobile_div{
                padding-top:10px;
                clear:both!important;
            }
        }

    </style>

    <!-- SEO INFORMATION -->
    <link rel="icon" type="image/ico" href="images/favicon-32x32.png">
    <title>Anasheed - Home</title>
</head>

<body>
    <!-- NAVIGATION MENU -->
    <header id="navigation_menu">
        <nav class="nav-extended" style="background-color:#0376bc;">
            <div class="nav-wrapper">
                <a href="../" class="brand-logo"><img style="width:5rem;padding-left:10px;" src="images/Anasheed-favicon-white.png"></a>
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="../mylist">My List</a></li>
                    <!--<li><a href="../contact">Contact</a></li>-->
                </ul>
            </div>
        </nav>
        <ul id="slide-out" class="sidenav">
            <li style="text-align:center;margin-bottom:-2rem;"><img style="width:5rem;" src="images/Anasheed-favicon-outline.png"></li>
            <li>
                <div class="divider"></div>
            </li>
            <li><a href="../">Home</a></li>
            <li><a href="mylist/">My List</a></li>
            <li><a href="contact/">Contact</a></li>
        </ul>
    </header>

    <main>
        <!-- TOGGLE GRID VIEW OR LIST VIEW -->
        <div class="container-fluid" style="float:right;padding:15px;" id="gridlist">
            <!-- List View -->
            <svg onclick="switchViews(1)" id="list_view" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="#0376bc" fill="none" stroke-linecap="round" stroke-linejoin="round">
               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
               <line x1="9" y1="6" x2="20" y2="6"></line>
               <line x1="9" y1="12" x2="20" y2="12"></line>
               <line x1="9" y1="18" x2="20" y2="18"></line>
               <line x1="5" y1="6" x2="5" y2="6.01"></line>
               <line x1="5" y1="12" x2="5" y2="12.01"></line>
               <line x1="5" y1="18" x2="5" y2="18.01"></line>
            </svg>
            
            <!-- Grid View -->
            <svg onclick="switchViews(2)" id="grid_view" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-grid" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
               <rect x="4" y="4" width="6" height="6" rx="1"></rect>
               <rect x="14" y="4" width="6" height="6" rx="1"></rect>
               <rect x="4" y="14" width="6" height="6" rx="1"></rect>
               <rect x="14" y="14" width="6" height="6" rx="1"></rect>
            </svg>
        </div>
        
        <!-- SEARCH DIV -->
        <div id="search_div">
            <div class="row" style="margin-top:5rem;">
                <div id="search" class="col s8" style="float:none!important;margin:auto">
                    <input style="text-align:center;" oninput="update_rows();" id="search_field" placeholder="Search">
                </div>
            </div>
        </div>
        
        <!-- SONGS DIV -->
        <div id="songs_div" class="container">
            <!-- ALL SONGS ROW DIV - HIDDEN WHEN SEARCHING -->
            <div class="row" id="all_songs">
                <div id="list_view_div">
                <?php
                    //loop and make the list_view
            for($i = count($songs_list) - 1; $i >= 0; $i--){
                echo "
                <div class='col s12' style='margin-bottom:.5rem;'>
                        <div class='card' style='padding:10px!important;'>
                            <div class='card-content' style='padding: 10px;vertical-align: middle;'>
                                <h5 style='text-align:right;display:inline-block;float:right;margin:0;padding: 0;'>".$songs_list[$i]."</h5>
                                    <div class='mobile_div'>
                                    <a class='btn-flat waves-effect modal-trigger' style='background-color:#0376bc;color:white;margin:0px;' onclick='setSong(\"" . $i . "\")' href='#viewsong'>View Song</a>
                                    ";
                                    
                       if(check_i_with_cookie($i)){             
                            echo "
                                    <a class='btn-flat waves-effect' style='background-color:#0376bc;color:white;margin:0;' id='" . $i . "' onclick='setCookie(\"" . $i . "\");'>Add to Mylist</a>
                                    ";
                       }else{
                            echo "
                                    <a class='btn-flat waves-effect' style='background-color:red;color:white;margin:0;' id='" . $i . "' onclick='removeSongCookie(\"" . $i . "\");'>Remove</a>
                                    ";
                       }
                           echo"
                                </div>
                            </div>
                        </div>
                     </div>
                ";
                
            }
                    
                    ?>
                    </div>
                    <div id='grid_view_div' style="display:none;">
                    <?php
                    
            for($i = count($songs_list) - 1; $i >= 0; $i--){
                echo '<div class="col s12 m4 l3" style="text-align:center;margin-bottom:30px;"><iframe style="height:380px;" class="pdf-js-viewer-grid" src="/anasheed_V2/pdf_viewer_no_zoom/index.html?songnumber='. $i .'" title="webviewer" frameborder="0"></iframe><h6 style="font-weight:500;margin-bottom:10px;">'.$songs_list[$i].'</h6><a class="btn-flat waves-effect modal-trigger" style="background-color:#0376bc;color:white;margin:0px;" onclick=\'setSong("' . $i . '")\' href="#viewsong">View Song</a>';
                
                       if(check_i_with_cookie($i)){             
                            echo "
                                    <a class='btn-flat waves-effect' style='background-color:#0376bc;color:white;margin:0;' id='" . $i . "' onclick='setCookie(\"" . $i . "\");'>Add to Mylist</a>
                                    ";
                       }else{
                            echo "
                                    <a class='btn-flat waves-effect' style='background-color:red;color:white;margin:0;' id='" . $i . "' onclick='removeSongCookie(\"" . $i . "\");'>Remove</a>
                                    ";
                       }
                           echo"</div>";
                
            }
            ?>
                </div>
            </div>
            <!-- SEARCHED SONGS ROW DIV - HIDDEN WHEN NOT SEARCHING -->
            <div class="row" id="searched_query">

            </div>
        </div>

        <!-- MODAL FOR DISPLAYING THE SONG -->
        <div id="viewsong" class="modal modal-fixed-footer" style="">
            <div class="modal-content" style="text-align:center;overflow:hidden;padding:0;">
                <h4 style="text-align:right;padding:15px;" id="song_title">Song Title</h4>
                <hr>
                <iframe id="pdf-js-viewer" src="" title="webviewer" frameborder="0"></iframe>
            </div>
            <div class="modal-footer" style="text-align:left;">
                <!-- LEFT SIDE OF FOOTER MODAL -->
                <button class="modal-close btn-flat" style="text-align:left!important;"><i class="small material-icons">close</i></button>
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
    <script>
        //set up the cookie to not get corrupted by google analyitcs
        window['ga-disable-UA-XXXXXXXX-X'] = true;
        
        //set the expiration value to be 14 days after setting the list
        var today = new Date();
        var expire = new Date();
        expire.setTime(today.getTime() + 3600000 * 24 * 14);
        
        //search field
        var search_field = document.getElementById('search_field');

        //file for songs
        var file = '<?php echo json_encode($songs_list); ?>';
        var decoded_file = JSON.parse(file);
        
        //get the parameter and switch to grid if applicable
        if(getParameterByName('view') == 'grid'){
            switchViews(2);
        }
        
        //setCookie----------------------------------------------------------------------
        //
        // this function saves the cookie
        //
        //---------------------------------------------------------------------------------
        function setCookie(loc) {
            //changes innerhtml
            document.getElementById(loc).innerHTML = "Remove";
            document.getElementById(loc).style.backgroundColor = "red";
            document.getElementById(loc).setAttribute('onclick', 'removeSongCookie("' + loc + '");');

            //cookie to string
            var cookieString = getCookie("loc").substring(4);
            var cookieArray = cookieString.split(',');
            
            console.log(loc);
            
            //checks the cookie for repetitiveness
            for (var i = 0; i < cookieArray.length; i++) {
                
                //if the location already exists then dont update the cookie
                if (cookieArray[i] == loc) {
                    console.log(cookieArray[i] == loc);
                    return;
                }
            }
            
            console.log(loc);
            //add the song number to the cookieString
            cookieString += loc + ",";
            
            //set the cookie
            document.cookie = "loc=" + cookieString + "; " + "expires=" + expire.toGMTString() +"; path=/";
        }

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

        //UPDATE_ROWS----------------------------------------------------------------------
        //
        // this function updates the rows according to the letters typed: called via oninput
        //
        //---------------------------------------------------------------------------------
        function update_rows() {
            var query = search_field.value;
            if (query.replace(/\s/g, '') == "") {
                //show all the rows
                document.getElementById('all_songs').style.display = "block";

                //hide all the search results
                document.getElementById('searched_query').style.display = "none";
            } else {
                //hide all the songs and display the searched query results
                document.getElementById('all_songs').style.display = "none";
                document.getElementById('searched_query').style.display = "block";

                //display all the songs with this query
                var inner_searched_query_div = "";
                for (var i = 0; i < decoded_file.length; i++) {
                    if (decoded_file[i].includes(query)) {
                        //add it to the search div
                        console.log(query);
                        inner_searched_query_div += "<div class='col s12' style='margin-bottom:.5rem;'><div class='card' style='padding:10px!important;'><div class='card-content' style='padding: 10px;vertical-align: middle;'><h5 style='text-align:right;display:inline-block;float:right;margin:0;padding: 0;'>" + decoded_file[i] + "</h5><div class='mobile_div'><a class='btn-flat waves-effect modal-trigger' style='background-color:#0376bc;color:white;margin:0px;margin-right:4px;' onclick='setSong(" + i + ")' href='#viewsong'>View Song</a><a class='btn-flat waves-effect' style='background-color:#0376bc;color:white;margin:0;'>Add to Mylist</a></div></div></div></div>";
                    }
                }
                document.getElementById("searched_query").innerHTML = inner_searched_query_div;
            }
        }

        //removeSongCookie----------------------------------------------------------------------
        //
        // this function removes the cookie data for a specific song
        //
        //---------------------------------------------------------------------------------
        function removeSongCookie(loc) {
            //update the button
            document.getElementById(loc).innerHTML = "Add to Mylist";
            document.getElementById(loc).style.backgroundColor = "#0376bc";
            document.getElementById(loc).setAttribute('onclick', 'setCookie("' + loc + '");');
            
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
            document.cookie = "loc=" + cookieString + "; " + "expires=" + expire.toGMTString() +"; path=/";
        }

        //SETSONG--------------------------------------------------------------------------
        //
        // this function sets the song for modal that will display the text
        // the function takes in the number of the song from the content.json file order
        //---------------------------------------------------------------------------------
        function setSong(songNum) {
            //add a column
            document.getElementById('song_title').innerHTML = decoded_file[songNum];
            document.getElementById('pdf-js-viewer').src = "pdf_viewer_with_zoom/index.html?songnumber=" + songNum + "";
        }

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
        
        //switchViews--------------------------------------------------------------------------
        //
        // switch views from grid view to list view and vice versa
        //---------------------------------------------------------------------------------
        function switchViews(num){
            var id1 = "list_view";
            var id2 = "grid_view";
            
            //change colors of the id to match the selected item
            if(num == "1"){
                //make them the blue color
                document.getElementById(id1).setAttribute('stroke',"#0376bc");
                
                //change the other element to gray color
                document.getElementById(id2).setAttribute('stroke', "currentColor");
                
                //hide the grid view
                document.getElementById('grid_view_div').style.display = 'none';
                document.getElementById('list_view_div').style.display = 'block';
                
                //set the url with the grid query
                if(getParameterByName('view') == 'grid'){
                    location.replace(window.location.href);
                }
            }else if(num == "2"){
                //make button grayscale
                document.getElementById(id1).setAttribute('stroke', "currentColor");
                
                //make them the blue color
                document.getElementById(id2).setAttribute('stroke',"#0376bc");
                
                //hide the list view
                document.getElementById('list_view_div').style.display = 'none';
                document.getElementById('grid_view_div').style.display = 'block';
                
                //set the url with the grid query
                if(getParameterByName('view') != 'grid'){
                    location.replace(window.location.href + "?view=grid");
                }
            }
        }
        
        //getParameterByName--------------------------------------------------------------------------
        //
        // get the parameter from the name of the query
        //---------------------------------------------------------------------------------
        function getParameterByName(name, url = window.location.href) {
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }
    </script>
</body>

</html>
