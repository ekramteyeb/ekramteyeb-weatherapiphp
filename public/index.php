<?php
  declare(strict_types=1);

  require_once('../vendor/autoload.php');
  
  //if the app is running in localhost environment the following 2 lines of codes are needed. 
  // when push to heroku(ie. production environmnet these lines of codes should not be used)
  if ($_SERVER['SERVER_NAME'] === 'localhost'){
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
  }
  //print_r($_SERVER);

  $weather = "";
	$errorMessage = "";

	if(isset($_GET['city']) && $_GET['city']){
      $apiKey = $_ENV["APIKEY"];
      $urlContent = @file_get_contents("http://api.openweathermap.org/data/2.5/weather?appid=".$apiKey."&q=".$_GET['city']);

      if(!$urlContent ){
        $errorMessage .= "Something went wrong. Please check the city name and try again.";
      }else{

      
      // decode the content in to associative array format :helps to analyse , extract and display it to user 
      $weatherArray = Json_decode($urlContent,true);
    
      //print_r($weatherArray);
      if(isset($weatherArray['cod']) && $weatherArray['cod'] == 200){
        	
      
       		$weather .= "Now the weather in " .$_GET['city']." , country  ".$weatherArray['sys']['country']." is ".$weatherArray['weather']['0']['description'].".<br>";
      
          $weather .= "The temperature is ".(round($weatherArray['main']['temp']-273.15, 2) )."&deg;C."." Wind speed is ".($weatherArray['wind']['speed'] * 3.6)."km/hr.";
          
      }else{
      		$errorMessage .="Please enter a valid city name.There is no weather information."; 
      		
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    
    <style type="text/css">
	body{
          background: none;
      		color: white;
      		top: 0px !important; position: static !important; /* use important to give priority to ur current styling not to be overwritten by other css */
	
	}
     .goog-te-banner-frame {display:none !important}
    html { 
          
          background: url(backgroundimg.jpg) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
      		
      		
		}  
      
	#container1{
			
      margin:auto;   
      margin-top:150px;
      width:450px;
      text-align:center;
      
      	
		
	}
  #weathere{
      
      margin-top:20px;
      
      }
      
	
	
</style>
  
    
  </head>
  <body>
  
   
    <div style= 'position:fixed;z-index:3;right:10px; top:20px; height:44px;background-color:#5f5f5f;text-align:right;padding-top:9px;  ' id='google_translate_element'></div>
    
    <div class="container">
      
        
        	<div id="container1" >

          	<h1>What is The Weather?</h1>
          <form>
              <div class="form-group">
                  <label for="city">Enter the name of the city</label>
                  <input type="city" class="form-control" id="city" name="city" placeholder="Eg. London,Tokyo" />

                  <?php 
                    if(isset($_GET['city']) && $_GET['city'])
                    {echo "You have entered ".strtoupper($_GET['city']);}
                   
                  ?>

                </div> 
                <button type="submit" class="btn btn-success">Submit</button>
        </form>  


          <div id="weathere"><?php

                if($weather){

                    echo '<div class="alert alert-success" role="alert">
                          <h5>'.ucwords($_GET["city"]). ' current weather forecast : </h5>'
                      .$weather.'
                    </div>';

                }
                else if($errorMessage)
                {

                    echo '<div class="alert alert-danger" role="alert">
                      '.$errorMessage.'</div>';


                }
                else{
                  echo ''; 
                }

            ?>     	      
          </div> 







        </div>

    </div>
    <script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({pageLanguage: 'en'},      	
        
        'google_translate_element');
    }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>
