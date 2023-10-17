<?php
//get the file and the contents
$file = json_decode(file_get_contents('../content.json'), true);

//check if the file was submitted
if ( isset($_POST['submit']) ) {
    
    //check if file is a pdf
	if ($_FILES['pdfFile']['type'] == "application/pdf") {
        
        //set the destination file and the source file
		$source_file = $_FILES['pdfFile']['tmp_name'];
		$dest_file = "../web/anasheed_pdf/anasheed_".count($file).".pdf";
        
        //check if the file already exists
        $exists = false;
        foreach($file as $song){
            if($song == $_POST['pdffilename']){
                echo "This song is already in Anasheed";
                $exists = true;
            }
        }
        
        if(!$exists){
            //move the file to the designated destination
            move_uploaded_file( $source_file, $dest_file )
            or die ("Error!!");
            if($_FILES['pdfFile']['error'] == 0) {
                //add the song title to the content.json
                array_push($file, $_POST['pdffilename']);
                file_put_contents("../content.json", json_encode($file));
                
                //redirect to the same page
                header("Location: https://anasheed.app/upload");
            }
        }
	}
	else {
		if ( $_FILES['pdfFile']['type'] != "application/pdf") {
			echo "Error occured while uploading file : ".$_FILES['pdfFile']['name'];
		}
	}
}
?>
<html>

<head>
    <title>Anasheed - Upload</title>
    <style>
        body {
            font-family: 'Fira Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background: #4776e6;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #4776e6, #8e54e9);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #4776e6, #8e54e9);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }

        .loginarea__form {
            background: #fff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
        }

        .loginarea__form input {
            width: 100%;
            margin-bottom: 2rem;
            font-family: 'Fira Sans', sans-serif;
            padding: 0.5rem;
            box-sizing: border-box;
            border-radius: 2px;
            border-width: 0 0 1px 0;
        }

        .loginarea__form input[type="submit"] {
            background: #4776e6;
            border: 0px;
            color: #fff;
            padding: 1rem 0.5rem;
        }

        .loginarea__actions {
            margin-top: 2rem;
            font-size: 0.85rem;
            color: #fff;
            text-align: center;
        }

        .loginarea__actions a {
            color: #ffc837;
        }

        .visuallyhidden {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        .visuallyhidden.focusable:active,
        .visuallyhidden.focusable:focus {
            clip: auto;
            height: auto;
            margin: 0;
            overflow: visible;
            position: static;
            width: auto;
        }

    </style>
</head>

<body>
    <section class="loginarea" style="display: flex;align-items: center;justify-content: center;width:100%;height:100%;">
        <form class="loginarea__form" enctype="multipart/form-data" action="" method="post">
            <h1>Upload Song to Anasheed</h1>
            <input type="file" name="pdfFile" required>
            <input type="text" name="pdffilename" placeholder="Title of Song" style="text-align:center;font-size:30px;" required>
            <input type="submit" name="submit">
        </form>
    </section>
</body>

</html>
