<?php

require('inc/lang.inc.php');
require('inc/functions.inc.php');

// File to watch/DL and it extention
$file = htmlspecialchars($_GET['file']);
$ext = get_file_icon(basename($file),TRUE);

// Get the next and the previous video file if current file is a video too
if($ext == "avi"):
  $listof_dir = array(); // Global used by get_nextnprev
  $nextnprev = get_nextnprev($file);
  $prev = $nextnprev['prev'];
  $next = $nextnprev['next'];
else:
  $prev = NULL;
  $next = NULL;
endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="robots" content="noindex" />
    <title>CakeBox - <?php echo $lang[LOCAL_LANG]['watch_title']; ?></title>
    <meta charset="utf-8">

    <!-- Style & ergo -->
    <link href='http://fonts.googleapis.com/css?family=Changa+One|Droid+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="ressources/style.css" type="text/css" media="screen">
    <link rel="stylesheet" href="ressources/reset.css" type="text/css" media="screen">
    <link rel="stylesheet" href="ressources/tooltips.css" type="text/css" media="screen" />
    <!-- / Style & ergo -->

    <!-- VLC Controls -->
    <script language="javascript" src="ressources/jquery.min.js"></script>
    <script language="javascript" src="ressources/jquery-vlc.js"></script>
    <link rel="stylesheet" type="text/css" href="ressources/vlc-styles.css" />
    <script language="javascript">

        function play(instance, uri) {
            VLCobject.getInstance(instance).play(uri);
        }

         var player = null;
        $(document).ready(function() {
            player = VLCobject.embedPlayer('vlc1', 600, 400, true);
        });

    </script>
    <!-- / VLC Controls -->

    <script lang="javascript">
      var lang_ok_unmark = '<?php echo $lang[LOCAL_LANG]['ok_unmark']; ?>';
      var lang_ok_mark = '<?php echo $lang[LOCAL_LANG]['ok_mark']; ?>';
    </script>
    <script src="ressources/oXHR.js"></script>

</head>
<body onload="play('vlc1', '<?php echo $file; ?>')">
        <!-- HEADER -->
        <header>
        <div id="logo">
        <a href="index.php">
          <span class="first">Cake</span>
          <span class="second">Box</span>
        </a>
        </div>
        <div id="flattr">
          <a href="http://flattr.com/thing/811178/Cakebox-votre-nouvelle-tele" target="_blank">
            <?php echo $lang[LOCAL_LANG]['support_us']; ?> <span class="cakebox">Cakebox</span> <img src="http://api.flattr.com/button/flattr-badge-large.png" alt="Flattr this" title="Flattr this" border="0" /> <span class="coeur">♥</span>
        </a>
        </div>
        </header>
        <!-- / HEADER -->

        <!-- CONTENT -->
        <section id="content">
          <h2><?php echo ustr_replace(LOCAL_DL_PATH."/","",$file ); ?></h2>

          <?php
            // If it's a video file
            if($ext == "avi"):
          ?>
              <div id="popcorn" class="littleh2">
                <?php
                  // If file is not marked as "already seen"
                  if(!file_exists("data/".basename($file))):
                ?>
                    <?php echo $lang[LOCAL_LANG]['have_you_finished']; ?>
                    <span class="mark" onclick="markfile('<?php echo basename($file); ?>');"><?php echo $lang[LOCAL_LANG]['click_remind']; ?></span>
                    <a href="#" class="update_info" style="text-decoration: underline;"><?php echo $lang[LOCAL_LANG]['what_zat']; ?>
                      <span class="tooltip">
                          <span></span>
                          <?php echo $lang[LOCAL_LANG]['popcorn_details']; ?>
                          </span>
                    </a>
                <?php
                  else:
                ?>
                    Hey, <span class="unmark"><?php echo $lang[LOCAL_LANG]['do_you_remember']; ?></span>
                    <span class="update_info" style="text-decoration: underline;cursor:pointer;" onclick="unmarkfile('<?php echo basename($file); ?>')"><?php echo $lang[LOCAL_LANG]['cancel_please']; ?></span>
                <?php
                  endif;
                ?>
              </div>
            <hr class="clear" />

            <p style="text-align:center;margin-bottom:10px;">
              <a href="https://github.com/MardamBeyK/Cakebox/wiki/Impossible-de-lire-une-vid%C3%A9o-en-streaming" target="_blank" class="help"><?php echo $lang[LOCAL_LANG]['help_watching']; ?></a>
            </p>

            <center>

                <!-- Embed VLC -->
                <div id="vlc1" style="margin-bottom:50px;">player 1</div>
                <!-- / VLC -->

                <?php
                  // Show the "previous" and "next" link under the player
                  if($prev != NULL):
                    echo '<div style="margin:40px 0px 10px 0px;">';
                    echo '<a href="watch.php?file='.$prev.'" class="next_episode">';
                    echo "← ".$lang[LOCAL_LANG]['watch_previous'];
                    echo '</a></div>';
                  endif;
                  if($next != NULL):
                    echo '<div style="margin:10px 0px 40px 0px;padding-left:30px;">';
                    echo '<a href="watch.php?file='.$next.'" class="next_episode">';
                    echo $lang[LOCAL_LANG]['watch_next']." →";
                    echo '</a></div>';
                  endif;
                ?>
            </center>
          <?php endif; ?>

          <div class="download_button">
            <a href="<?php echo $file; ?>">
              <img src="ressources/downloadfile.png" />
            </a><br/>

            <?php echo $lang[LOCAL_LANG]['right_click']; ?><br/>
            <strong><?php echo $lang[LOCAL_LANG]['size']; ?></strong> <?php echo convert_size(filesize($file)); ?>
          </div>

          <br />
          <br />

        </section>
        <!-- / CONTENT -->

  <!-- FOOTER -->
    <footer>
      <div class="padding">
        </div>
    </footer>
  <!-- / FOOTER -->

</body>
</html>
