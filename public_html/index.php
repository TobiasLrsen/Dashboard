 <?php
   $dns = "mysql:host=sql.itcn.dk;dbname=tobi48822.SKOLE;charset=utf8";
   $username = "tobi4882.SKOLE";
   $password = "52b1TbWy5P";
   
   $db = new PDO($dns, $username, $password);
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="600">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500" rel="stylesheet">
    <!-- <script src="main.js"></script> -->
</head>
<body>
    
<section class="wrapper">
    <div class="logo"><img src="img/logo/logo.svg" alt="logo" /></div>
    <div class="info">
        <!-- <div class="clock">8.17</div> -->
        <div class="date"><span id="tellDate"></span> <span id="telltime"></span></div>

        <script>
            window.setInterval(function() {
        var clock = new Date().toLocaleTimeString('da-DK', {
          hour12: false,
          hour: 'numeric',
          minute: 'numeric',
          
        });

        var today = new Date();
        var date = today.getDate();
        var month = today.getMonth() + 1; //January is 0!
        var days = ['Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag', 'Søndag'];
        var day = days[today.getDay()-1];

        if (date < 10) {
        date = '0' + dd;
        }

        if (month < 10) {
        month = '0' + month;
        }

        today = day + ' ' + date + '/' + month;
        
        document.getElementById('telltime').innerHTML = clock;
        document.getElementById('tellDate').innerHTML = today;
      }, 1000);
        </script>
    </div>

    <section class="graphics">
        <img src="<?php 
            $getMedieSql = "SELECT * FROM medie WHERE iMedieID = 1"; // 1 for video 2 for billede
            $getMedie = $db->prepare($getMedieSql);
            $getMedie->execute();
            $rowMedie = $getMedie->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($rowMedie as $rowMedieData) {
                echo $rowMedieData['vcFile'];
            }

        ?>" /> 

    <iframe width="100%" height="100%" src="<?php echo $rowMedieData['vcFile'] ?>?autoplay=1&mute=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe>



        
    </section>
    
    <section class="news">
    <?php
        $newsSelect = "SELECT * " . 
        "FROM news " .
        "WHERE iDeleted = 0 " . 
        "ORDER BY daCreated";

        $getNews = $db->prepare($newsSelect);
      $getNews->execute();
      $row = $getNews->fetchAll(PDO::FETCH_ASSOC);
    
      foreach ($row as $rowData) {
      echo '<div class="news__feed">' .
            '<h2 class="news__feed-title">'. $rowData['vcTitle'] .'</h2>' .
            '<span class="hr"></span>'.
            '<div class="news__feed-content">'.
                '<p>'.
                    $rowData['txContent'] .
                '</p>'.
            '</div>'.
        '</div>';
      }
    ?>
        
    </section>
    <section class="overview">
        <div class="card-header">
            <div class="color"></div>
            <div class="">Klasse navn</div>
            <div class="">Lokale</div>
            <div class="">Fag</div>
            <div class="center">Start tid</div>
        </div>
<?php
        try {
    //   $sql = "SELECT * FROM mh_activity WHERE daTime > UNIX_TIMESTAMP() LIMIT 10";
      $sql = "SELECT a.*, s.vcFriendlyName FROM mh_activity a " .
                        "LEFT JOIN mh_subject s " .
                        "ON a.vcSubject = s.vcName " .
                        "WHERE daTime > UNIX_TIMESTAMP() " .
                        "ORDER BY a.daTime LIMIT 16";
      $getContent = $db->prepare($sql);
      $getContent->execute();
      $row = $getContent->fetchAll(PDO::FETCH_ASSOC);

        
    foreach ($row as $rowData) {
        $time = date("H:i – d/m", $rowData['daTime']);
        $strClass = $rowData['vcClass'];
        $team = '';

        if (substr($strClass,0,1) === "a") {
            $team = "Efteruddannelse";
        } else if (substr($strClass,0,3) === "iiw") {
            $team = "Brobygning";
            $classColor = 'extra';
        } else if (strstr($strClass, "h1we")) {
            $team = "Webudvikler H1";
            $classColor = 'web';
        } else if (strstr($strClass , "gwe")) {
            $team = "Webudvikler GF2";
            $classColor = 'web';
        } else if (strstr($strClass, "h1mg")) {
            $team = "Mediegrafiker H1";
            $classColor = 'grafikker';
        } else if (strstr($strClass, "h2mg")) {
            $team = "Mediegrafiker H2";
            $classColor = 'grafikker';
        } else if (strstr($strClass, "h3mg")) {
            $team = "Mediegrafiker H3";
            $classColor = 'grafikker';
        } else if (strstr($strClass, "4mg")) {
            $team = "Mediegrafiker H4";
            $classColor = 'grafikker';
        } else if (strstr($strClass, "h5mg")) {
            $team = "Mediegrafiker H5";
            $classColor = 'grafikker';
        } else if (strstr($strClass, "gmg")) {
            $team = "Mediegrafiker GF2";
            $classColor = 'grafikker';
        }
         else if (strstr($strClass, "gdm")) {
            $team = "Digital media GF2";
            $classColor = 'dm';
        } else if (strstr($strClass, "ggr")) {
            $team = "Grafisk tekniker GF2";
            $classColor = 'trykkere';
        } else if (strstr($strClass, "h1gr")) {
            $team = "Grafisk tekniker H1";
            $classColor = 'trykkere';
        } else if (strstr($strClass, "h0gr")) {
            $team = "Grafisk tekniker H0";
            $classColor = 'trykkere';
        } else if (strstr($strClass, "h2gr")) {
            $team = "Grafisk tekniker H2";
            $classColor = 'trykkere';
        } else if (strstr($strClass, "h3gr")) {
            $team = "Grafisk tekniker H3";
            $classColor = 'trykkere';
        } else if (strstr($strClass, "h4gr")) {
            $team = "Grafisk tekniker H4";
            $classColor = 'trykkere';
        } else if (strstr($strClass, "fiw")) {
            $team = "gf1";
            $classColor = 'extra';
        } else if (strstr($strClass, "fmiw")) {
            $team = "gf1";
            $classColor = 'extra';
        } else {
            $team = $strClass;
            $classColor = 'extra';
        }
        

        echo '<div class="card">';
        echo '<div class="color ' . $classColor . '"></div>';
        echo '<div class="class">'. $team .'<span> '. $rowData["vcClass"] .'</span></div>';
        echo '<div class="class__room">'. $rowData["vcClassroom"] .'</div>';
        echo '<div class="class__fag">'. $rowData["vcSubject"] .'</div>';
        echo '<div class="class__time">' . $time . '</div>';
        echo '</div>';
        

    }
    //   foreach ($row as $rowData) {
    //     $site = @get_headers($rowData['link']);
    //     // var_dump($site);

    //       if(!$site || $site[0] == 'HTTP/1.1 404 Not Found') {
    //         $siteExist = false;
    //       } else {
    //         $siteExist = true;
    //       }
    //     $status = ($siteExist == true) ? 'fa-check' : 'fa-times';
    //     $statusColor = ($siteExist == true) ? 'color: #00a7b5;' : 'color: #ff789e;';
    //     $striped = preg_replace('#^https?://#', '', $rowData['link']);


    //     echo '<li>';
    //     echo '<div class="status" style="'. $statusColor .'"><i class="fas '. $status .'"></i></div>';
    //     echo '<p class="link"><a href="' . $rowData['link'] . '" target="_blank">' . $striped .'</a></p>';
    //     echo '<div class="edit"><i class="fas fa-pen"></i></div>';
    //     echo '<form class="remove" method="POST"><input type="hidden" name="id" value="'. $rowData['id'] .'"/><button type="submit" name="remove"><i class="fas fa-times"></i></button></form>';
    //     echo '</li>';
    //     //
    //     echo '<article class="editLink">';
    //     echo '<form>';
    //     echo '<input type="text" placeholder="http://example.com" />';
    //     echo '<button type="submit">Save</button>';
    //     echo '</form>';
    //     echo '</article>';
    //   }
    } catch(PDOException $error) {
      echo $error;
    }

?>
        <!-- <div class="card">
            <div class="color grafikker"></div>
            <div class="class">
                Webudvikler
                <span></span>
            </div>
            <div class="class__room">Vores lokale</div>
            <div class="class__time">14:00 - 15:00</div>
        </div>
        <div class="card fri">
            <div class="color trykkere"></div>
            <div class="class">
                Trykkere
                <span>H1WE201805</span>
            </div>
            <div class="class__room"></div>
            <div class="class__time">Fri</div>
        </div>
        <div class="card">
                <div class="color gf2web"></div>
                <div class="class">
                    GF 2 webudvikler
                    <span>H1WE201805</span>
                </div>
                <div class="class__room">H125</div>
                <div class="class__time">13:00 - 14:00</div>
        </div>
        <div class="card">
                <div class="color gf2grafikker"></div>
                <div class="class">
                    GF 2 grafikker
                    <span>H1WE201805</span>
                </div>
                <div class="class__room">H165</div>
                <div class="class__time">13:00 - 14:00</div>
        </div>
        <div class="card">
                <div class="color gf1"></div>
                <div class="class">
                    GF 1
                    <span>H1WE201805</span>
                </div>
                <div class="class__room">H225</div>
                <div class="class__time">13:00 - 14:00</div>
        </div>
        <div class="card fri">
                <div class="color grafikker"></div>
                <div class="class">
                    Webudvikler
                    <span>H1WE201805</span>
                </div>
                <div class="class__room"></div>
                <div class="class__time">Fri</div>
            </div>
            <div class="card">
                <div class="color trykkere"></div>
                <div class="class">
                    Trykkere
                    <span>H1WE201805</span>
                </div>
                <div class="class__room">H225</div>
                <div class="class__time">13:00 - 14:00</div>
            </div>
            <div class="card">
                    <div class="color gf2web"></div>
                    <div class="class">
                        GF 2 webudvikler
                        <span>H1WE201805</span>
                    </div>
                    <div class="class__room">H125</div>
                    <div class="class__time">13:00 - 14:00</div>
            </div> -->
    </section>
    <div class="map">
        <div class="map1">
            <img src="img/kortTekstVVV.svg" alt="hej" />
        </div>
        <div class="map2">
            <img src="img/kortoverstue.svg" alt="hej2" />
        </div>
        <div class="map3">
            <img src="img/kortoverfQrsteEtage.svg" alt="hej2" />
        </div>
    </div>

</section>
<!-- <script>
function getdata() {
    fetch("getActivities.php")
        .then(response => {
            return response.json();
        })
        .then(data => {
            console.log(data);
        });
    }

setInterval(getdata, 1000);
</script> -->
</body>
</html>