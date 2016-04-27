<!DOCTYPE html>
<html lang="en">
<?php         session_start();?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title>Shavent</title>
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
    <!-- Bootstrap core CSS--> 
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <style type="text/css">
    .slideshow { height: 232px; width: 232px; margin: auto }
    .slideshow img { padding: 15px; border: 1px solid #ccc; background-color: #eee; }
    </style>
    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">
    <script>
        var currentPictId=0;
        var username;
        function generateMainView(param){
            var div = document.createElement("div");
            switch (param){
                case 1:
                div.innerHTML= "<form method='post' action='Scripts/addEvent.php'>"+
                                "<fieldset class='subscription_form' >"+ 
                                    "<legend>Veuillez rentrer les informations de l'évènement</legend>"+
                                    "<label for='event_name' style='margin:10px'>Nom de l'évènement</label>"+
                                    "<input type='text' name='event_name' id='event_name' autofocus required/><br/>"+
                                    "<label for='date' style='margin:10px'>Date de début</label>"+
                                    "<input type='date' name='date' id='date' required/><br/>"+
                                    "<label for='duree' style='margin:10px'>Durée de l'évènement</label>"+
                                    "<input type='text' name='duree' id='duree' required/><br/>"+                                 
                                    "<label for='event_location' style='margin:10px'>Lieu de l'évènement</label>"+
                                    "<input type='text' name='event_location' id='event_location' required/><br/>"+
                                "</fieldset>"+
                                "<input type='submit' value='Envoyer' style='margin:10px'></code>"+
                               "</form>";
                case 2:
                case 3:    
            }
            document.getElementById("mainview").innerHTML="";
            var mainview = document.getElementById("mainview");
            mainview.appendChild(div);
        }
            </script>
    <script type="text/javascript" charset="utf-8">
        function resizeImage(maxW,maxH,id){
                var imageW = image.width;
                var imageH = image.height;
                if (imageH>maxH || imageW> maxW){
                var deltaH = imageH-maxH;
                var deltaW = imageW-maxW;
                    if (deltaW>deltaH){
                        var ratio = imageW/maxW;
                    }else{
                        var ratio = imageH/maxH;
                    }
                    imageH = imageH/ratio;
                    imageW = imageW/ratio;
                }
                image.height=imageH;
                image.width=imageW;
        } 
        function generatePreviewImage(param){
            this.render=function(imageName){
                var winH= window.innerHeight;
                var winW= window.innerWidth;
                var maxWinH = winH*.8;
                var maxWinW = winW*.8;
                var imgPath=imageName;
                var eventId="<?php echo $_GET['id'];?>"
                var dialogoverlay = document.getElementById('dialog_overlay');
                dialogoverlay.style.display = "block";
                dialogoverlay.style.height = winH + "px";
                dialogoverlay.onclick="closePreview()";
            	var dialog = document.getElementById('container');
                dialog.style.display = 'table';
				var prevContainer = document.getElementById('previewContainer');
                var img = document.createElement("img");
                var arrowLeft = document.getElementById('arrowLeft');
                var arrowRight = document.getElementById('arrowRight');
				img.innerHTML='<img id="imagePreview" src="'+imgPath+'"/>';
                prevContainer.appendChild(img);
				img.id="imagePreview";
				img.src = imgPath;
				img.style.maxHeight=maxWinH+"px";
				img.style.maxWidth=maxWinW+"px";
                img.style.display = "block";
            }
        }
        function slideRight(){
        var eventId="<?php echo $_GET['id'];?>"
        var imagePath=document.getElementById('imagePreview').src;
        var prevContainer = document.getElementById('previewContainer');
        previewContainer.removeChild(document.getElementById('imagePreview'));
        var img = document.createElement("img");
        var winH= window.innerHeight;
        var winW= window.innerWidth;
        var maxWinH = winH*.8;
        var maxWinW = winW*.8;
        $.ajax({url:'getNextImPath.php',
                        type:'post',
                        data:{path:imagePath,id:eventId},
                        success:function(data){
                            img.innerHTML='<img id="imagePreview" src="'+data+'"/>';
                            prevContainer.appendChild(img);
                            img.id="imagePreview";
                            img.src = data;
                            img.style.maxHeight=maxWinH+"px";
                            img.style.maxWidth=maxWinW+"px";
                            img.style.display = "block";
                        }
                    }
                )
        }
        function slideLeft(){
        var eventId="<?php echo $_GET['id'];?>"
        var imagePath=document.getElementById('imagePreview').src;
        var prevContainer = document.getElementById('previewContainer');
        previewContainer.removeChild(document.getElementById('imagePreview'));
        var img = document.createElement("img");
        var winH= window.innerHeight;
        var winW= window.innerWidth;
        var maxWinH = winH*.8;
        var maxWinW = winW*.8;
        $.ajax({url:'getPrevImPath.php',
                        type:'post',
                        data:{path:imagePath,id:eventId},
                        success:function(data){
                            img.innerHTML='<img id="imagePreview" src="'+data+'"/>';
                            prevContainer.appendChild(img);
                            img.id="imagePreview";
                            img.src = data;
                            img.style.maxHeight=maxWinH+"px";
                            img.style.maxWidth=maxWinW+"px";
                            img.style.display = "block";
                        }
                    }
                )
        }
        $(document).ready(function(e) {
            $("#container").click(function(event){
                switch (event.target.getAttribute("id")){
                    case 'imagePreview':
                        return false;
                        break;
                    case 'arrowLeft':
                        slideLeft();
                        break;
                    case 'arrowRight':
                        slideRight();
                        break;
                    default:
                closePreview();
                }
            });
        });   
		function closePreview(){
	    var dialogoverlay = document.getElementById('dialog_overlay');
            var previewContainer = document.getElementById('previewContainer');
            var dialog=document.getElementById('container');
            dialogoverlay.style.display= 'none';
            dialog.style.display= 'none';
            previewContainer.removeChild(document.getElementById('imagePreview'));
	}
        var preview = new generatePreviewImage();

    </script>
    <style type="text/css">
	
        #dialog_overlay{
            display: none;
            width: 100%;
            height: 100%;
            position: fixed;
            top:0;
            left: 0;
            background: #000;
            z-index: 800;
            opacity: .8;
        }
        
        #container{
            display: none;
            height: 100%;
            width: 100%;
            position: fixed;
            table-layout: fixed;
            top:0;
            left: 0;
            z-index: 900;
        }
	#container #previewContainer{
               display: inline-block;
               max-height: 100%;
               max-width: 100%;
               vertical-align: middle;
	}
        
        #container #previewContainer #arrowLeft{
               height:100px;
               left:20px;
               top:47%;
               position: absolute;   
        }
        
        #container #previewContainer #arrowRight{
               height:100px;
               right:20px;
               top:47%;
               position: absolute;
        }
        
        #middleContainer {
            display:table-cell;
                    text-align: center;
                    vertical-align: middle;
                    width: 100%;
        }
		
	
		
    </style>
    <?php
    
    function createTab(){
        $username=$_SESSION['nom_utilisateur'];
         // Connexion à la base de données
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dbusers;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        
        $reqevent=$bdd->query("SELECT * FROM ".$username."");
        while($event=$reqevent->fetch(PDO::FETCH_ASSOC)){
        $evName=$bdd->query("SELECT Event_ID FROM ".$username."");
            echo "<li class='event'>".
                 "<a href='event.php?id=".$event['Event_ID']."'>".$event['Name']."</a>";
        }
    }
    function checkEventPerm(){  
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dbusers;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    
    $eventid=$_GET['id'];
    //echo $eventid."</br>";
    $username=$_SESSION['nom_utilisateur'];
    $evName=$bdd->query("SELECT * FROM ".$username."");
    $perm_granted=false;
    while($event=$evName->fetch(PDO::FETCH_ASSOC)){
        if($event["Event_ID"]==$eventid){
             $perm_granted=true;
             return $perm_granted;
            }
    } 
    }
    function make_thumb($src, $dest, $desired_width) {
      /* read the source image */
      $source_image = imagecreatefromjpeg($src);
      $width = imagesx($source_image);
      $height = imagesy($source_image);

      /* find the “desired height” of this thumbnail, relative to the desired width  */
      $desired_height = floor($height * ($desired_width / $width));

      /* create a new, “virtual” image */
      $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

      /* copy source image at a resized size */
      imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

      /* create the physical thumbnail image to its destination */
      imagejpeg($virtual_image, $dest);
    } 
    
    function createMainView(){
        ini_set("gd.jpeg_ignore_warning", true);
        $permission=checkEventPerm();
        if($permission){
            $eventid=$_GET['id'];
            $username=$_SESSION['nom_utilisateur'];
            try {
                $bdd = new PDO('mysql:host=localhost;dbname=dbevent;charset=utf8', 'root', '');
             } catch (Exception $e) {
               die('Erreur : ' . $e->getMessage());
            }
            $req=$bdd->query("SELECT * FROM ".$eventid."");
            $counter=0;
            $rows = $req->rowCount();
            if(!$rows==0){
                while($event=$req->fetch(PDO::FETCH_ASSOC)){
                    echo '<img id="thumb__'.$counter.'" src="'.$event["PathThumb"].'" onClick="preview.render(\''.$event["Path"].'\')"/>';
                    $counter=$counter+1;
                }
            }else{echo "<h3 style='margin:10px'>Pas d'images dans le dossier</h3>";}
        }else{
            echo "vous n'avez pas la permission d'afficher ce contenus";
        }
    }
    function display_image(){
        list($width, $height, $type, $attr)=getimagesize($imgpath);
        echo '<img src="'.$imgpath.'" style="height:'.$height.';width:'.$width.'"/>';
    }
    function generateDownBut(){
    $eventid=$_GET['id'];
    $path='Events/QR/'.$eventid.'.png';
    /**/
    echo "<a href='$path' download><button>Download!</button></a>";
    }
    ?>
  </head>
  <body>
      <div id='dialog_overlay'></div>
      <div id='container' class="container">
          <div id='middleContainer' class='middleContainer'>
            <div id='previewContainer' class="previewContainer">
                <img id='arrowLeft' src='assets/img/arrowLeft.png'>
                <img id='arrowRight' src='assets/img/arrowRight.png'>
            </div>
          </div>
      </div>
      
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">SP<i class="fa fa-circle"></i>T</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="index.php">HOME</a></li>
            <li><a href="about.html">ABOUT</a></li>
            <li><a data-toggle="modal" data-target="#myModal" href="#myModal"><i class="fa fa-envelope-o"></i></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	<div id="headermembre">
		<div class="container">
			<div class="row centered">
				<div class="col-lg-8 col-lg-offset-2">
				<h1>Shavent</h1>
				</div>
			</div><!-- row -->
		</div><!-- container -->
	</div><!-- headerwrap -->

        <div id="container_member">
            <div id="mainview" class="column">
                <?php createMainView()?>
            </div>
            <div id="eventlist" class="column">
                <div id="listevent" class="column">
                    <ul class="eventlistbar">
                        <?php createTab() ?>
                        <li class="add_event"><a id="add_event" onClick="generateMainView(1)"><img id="add_event_icon" src="assets/img/add.png" alt=""/> Ajouter un évènement</a></li>
                    </ul>
                </div>
            </div>
            <div id="right" class="column">
                <?php generateDownBut()?>
            </div>
	</div>
        <!-- FOOTER -->
	<div id="f">
		<div class="container">
			<div class="row centered">
				<a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-dribbble"></i></a>
			</div><!-- row -->
		</div><!-- container -->
	</div><!-- Footer -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
</body>
</html>
