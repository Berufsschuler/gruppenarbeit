<?php
  $count = isset($_COOKIE['cookieCount']) ? intval($_COOKIE['cookieCount']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Competitive Cookie Clicker</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <div id="mainOne">
      <canvas id="canvas1"></canvas>
      <header>
        <div class="hname">
          <h1><c style="color: #9c8809">CCookie </c>Clicker</h1>
        </div>
        <div class="hicon">
          <div class="hpicture"></div>
        </div>
      </header>

      <div class="centerText">
        <h1>
          Click the <m style="color: #9c8809">Cookie</m>. Climb the
          <m style="color: #9c8809">Ladder</m>.<br />
          Win <m style="color: #9c8809" ;>Prices.</m> Get
          <m style="color: #9c8809">Addicted</m>.
        </h1>
      </div>

      <div class="login_container">
        <div class="loginHolder">
          <div class="cpicture"></div>
          <h1 style="margin: 5px"><br>Login</h1>
          <div class="cpicture"></div>
          <form action="index.html" method="post">
            <div class="form-holder">
              <input type="email" class="input_input" name="email" placeholder="Enter E-Mail"/>
            </div>
            <div class="form-holder">
              <input type="password" class="input_input" name="password" placeholder="Enter Password"/>
            </div>
            <div class="form-holder">
              <input type="submit" class="input_input_button"name="submitButton" value="Log in"/>
            </div>
            <div>
              <a class="form-holder_2" href="register.php"><br>No Account? - Sign Up</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="mainTwo">
      <div id="preview">
          <div id="previewGIF">
            <video 
              src="/gruppenarbeit/videos/40_prozent.mp4"
              autoplay
              muted
              loop
              playsinline
              style="width: 100%; height: auto; border-radius: 10px 10px 0px 0px;"
            ></video>
          </div>
        </div>
        <div id="GIFinformation">
          The <c style="color: #9c8809">Competitive Cookie Clicker </c>is a thrilling online game 
          that combines the addictive mechanics of traditional 
          cookie clicker games with competitiveness. 
        </div>
      </div>
    </div>
    <div id="mainThree">
      <div class="leaderboard-section">
      <h1 id="ClimbUpTheLadder">CLIMB UP THE&nbsp;<span style="color:#9c8809">LADDER!</span></h1>

        <div class="leaderboard">
          <div class="entry">
            <span class="rank">1</span>
            <span class="name">SteelFort</span>
            <span class="points">245 270 Cookies</span>
          </div>

          <div class="entry highlight">
            <span class="rank">2</span>
            <span class="name">Nagrarok</span>
            <span class="points">221 564 Cookies</span>
            <span class="rank-arrow">▲</span>
          </div>

          <div class="entry">
            <span class="rank">3</span>
            <span class="name">MissRubis</span>
            <span class="points">201 054 Cookies</span>
          </div>

          <div class="entry">
            <span class="rank">4</span>
            <span class="name">RaptorTwo</span>
            <span class="points">180 874 Cookies</span>
          </div>
        </div>
      </div>
    </div>
    <div id="mainFour">
      <h1 id="winPricesTitle"><m style="color: #9c8809">WIN </m>&nbspPRICES!!!</h1>
      <div id="prices">
          <div id="merch_04">
            <p><b>2nd Place!</b></p>
            <div id="merch_04_img"></div>
            <p><b>COMPETETIVE COOKIE - Cap</b></p>
          </div>
          <div id="merch_01" style="margin-bottom: 30px;">
            <p style="color: #9c8809; text-shadow: 0px 2px black;" id="firstPlaceGift"><b>1st Place!</b></p>
            <div  id="merch_01_img"></div>
            <p><b>CCCLICKER - T-Shirt</b></p>
          </div>
          <div id="eblem_01">
            <p><b>3rd Place!</b></p>
            <div id="eblem_01_img"></div>
            <p><b>COOKIE RIDING CURSOR - Profile Eblem</b></p>
          </div>
      </div>
    </div>
    <div id="mainFive">
      <h1 id="tryOutTitle"><span style="color:#9c8809">TRY</span>&nbsp;IT OUT!</h1>
      <div id="tryCookie" style="width:300px; height:300px; background-image:url('./img/cookie_1.png'); background-size:cover; cursor:pointer;"></div>
      <div id="tryCookieCounter" style="font-size:30px;">Counter: <?php echo $count; ?></div>
    </div>



    <footer class="main-footer">
      <div class="fname">
        <h1><c style="color: #9c8809">CCookie </c>Clicker</h1>
      </div>
      <div id="creators">Made by: Aleksandar Tesinic & Paul Heigl</div>
      <div class="ficon">
        <div class="fpicture"></div>
      </div>
    </footer>

    <script src="cookiesFallingBackground.js"></script>
    <script src="cookieClickTest.js"></script>
  </body>
</html>
