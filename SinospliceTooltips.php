<?php
$VERSION = "1.0.2";
/*
Plugin Name: Sinosplice Tooltips 1.0.2
Plugin URI: http://www.techni-orchid.com/extras/wp/sinosplicetooltips/
Description: Easily add attractive tooltips to show the pinyin of Chinese characters, glosses for Japanese characters, or any use for tooltip text you can think of.  Originally designed for and by Sinosplice.com.
Version: 1.0.2
Author: Andy Warmack
Author URI: http://www.techni-orchid.com/

Sinosplice Tooltips was conceived by John Pasden as a WordPress plugin
replacement for the custom CSS and JavaScript code he had been using
for years on Sinosplice.com.  It was originally designed to provide
pinyin readings for Chinese characters, but is flexible enough to be
adapted to a variety of uses.

Acknowledgements: 
   Trent Richardson
      http://trentrichardson.com/examples/csstooltips/
   Roel Meurders
      http://rmnl.net/wp-addquicktag-plugin-for-adding-quicktags/
   Wladimir A. Jimenez B.
      http://www.kasbeel.cl/kas2008/kasplugins/wp-kastooltip/
*/
/**
 * Sinosplice Tooltips WordPress Plugin
 *
 * FILE
 *   SinospliceTooltips.php
 *
 * DESCRIPTION
 *   Easily add attractive tooltips to show the pinyin of Chinese characters,
 *   glosses for Japanese characters, or any use for tooltip text you can
 *   think of.  Originally designed for and by Sinosplice.com.
 *
 *   Copyright (C) 2010 Sinosplice.com
 *   URL: www.sinosplice.com
 *   Contact: john@sinosplice.com
 *   Authored by: Andy Warmack
 *   Author URL: www.techni-orchid.com
 *
 *   This file is part of Sinosplice Tooltips.
 *
 *   Sinosplice Tooltips is free software: you can redistribute it and/or
 *   modify it under the terms of the GNU General Public License as published
 *   by the Free Software Foundation, either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 **/

$DIR = plugin_basename(dirname(__FILE__));
$PLUGINURL = defined('WP_PLUGIN_URL') ? WP_PLUGIN_URL . '/' . $DIR :
             get_bloginfo('wpurl') . '/wp-content/plugins/' . $DIR;

add_action('wp_head', 'wpst_wp_head'); // include headers 
add_action('admin_menu', 'wpst_admin_menu');

//
// Sinosplice stuff
//

$o = get_option('wpst_settings');
if (!$o || ($o['version'] != $VERSION)) {
   $o['theme'] = "white";
   $o['spanclass'] = "sinosplicetooltip";
   $o['originaltext'] = "yes";
   $o['addquicktag'] = "yes";
   $o['version'] = $VERSION;
}
update_option('wpst_settings',$o);

//
// AddQuicktag stuff
//

function wpst_admin_menu(){
   add_options_page('Sinosplice Tooltips', 'Sinosplice Tooltips', 9, basename(__FILE__), 'wpst_options_page');
}

function wpst_options_page(){
   global $VERSION;

   global $PLUGINURL;
   $url = $PLUGINURL . "/themes";

   if ($_POST['wpst']){
      $_POST['wpst']['version'] = $VERSION;
      update_option('wpst_settings', $_POST['wpst']);
      $message = '<div class="updated"><p><strong>Options saved.</strong></p></div>';
   }

   $o = get_option('wpst_settings');
   $t_default = "";
   $t_white = "";
   $t_gray  = "";
   $t_blue = "";
   $t_yellow = "";
   $t_black = "";
   $sc_default = "";
   $sc_tooltip = "";
   $sc_info = "";
   $sc_popup = "";
   $ot_yes = "";
   $ot_no = "";
   $aq_yes = "";
   $aq_no = "";
   if ($o['theme'] == "white")
      $t_white = "checked";
   else if ($o['theme'] == "gray")
      $t_gray = "checked";
   else if ($o['theme'] == "blue")
      $t_blue = "checked";
   else if ($o['theme'] == "yellow")
      $t_yellow = "checked";
   else if ($o['theme'] == "black")
      $t_black = "checked";
   else
      $t_default = "checked";
   if ($o['spanclass'] == "tooltip")
      $sc_tooltip = "checked";
   else if ($o['spanclass'] == "info")
      $sc_info = "checked";
   else if ($o['spanclass'] == "popup")
      $sc_popup = "checked";
   else
      $sc_default = "checked";
   if ($o['originaltext'] == "no")
      $ot_no = "checked";
   else
      $ot_yes = "checked";
   if ($o['addquicktag'] == "no")
      $aq_no = "checked";
   else
      $aq_yes = "checked";

   $bubblesize = "width=\"50px\" height=\"50px\"";
   echo <<<EOT
   <div class="wrap">
      <h2>Sinosplice Tooltips Options</h2>
      {$message}
      <form name="form1" method="post" action="options-general.php?page=SinospliceTooltips.php">
         <fieldset class="options">
            <legend>You may make changes below and save them by clicking on
               the Save Changes button.</legend>
            <br>
            Tooltip theme:<br>
               <div style="margin-left: 10px; width: 850px;">
                  <div style="float: left; width: 75px;">
                     <img src="{$url}/images/white.gif" {$bubblesize}><br>
                     <input type="radio" name="wpst[theme]"
                            value="white" $t_white> White
                  </div>
                  <div style="float: left; width: 75px;">
                     <img src="{$url}/images/gray.gif" {$bubblesize}><br>
                     <input type="radio" name="wpst[theme]"
                            value="gray" $t_gray> Gray
                  </div>
                  <div style="float: left; width: 75px;">
                     <img src="{$url}/images/blue.gif" {$bubblesize}><br>
                     <input type="radio" name="wpst[theme]"
                            value="blue" $t_blue> Blue
                  </div>
                  <div style="float: left; width: 75px;">
                     <img src="{$url}/images/yellow.gif" {$bubblesize}><br>
                     <input type="radio" name="wpst[theme]"
                            value="yellow" $t_yellow> Yellow
                  </div>
                  <div style="float: left; width: 75px;">
                     <img src="{$url}/images/black.gif" {$bubblesize}><br>
                     <input type="radio" name="wpst[theme]"
                            value="black" $t_black> Black
                  </div>
               </div>
               <div style="clear: both;"></div>
            <br>
            Tooltip span tag class
            (don't change this unless you really need to;
            it could break things!):<br>
            &nbsp;&nbsp;&nbsp; <input type="radio" name="wpst[spanclass]" value="sinosplicetooltip" $sc_default>sinosplicetooltip (default)<br>
            &nbsp;&nbsp;&nbsp; <input type="radio" name="wpst[spanclass]" value="tooltip" $sc_tooltip>tooltip<br>
            &nbsp;&nbsp;&nbsp; <input type="radio" name="wpst[spanclass]" value="info" $sc_info>info<br>
            &nbsp;&nbsp;&nbsp; <input type="radio" name="wpst[spanclass]" value="popup" $sc_popup>popup<br><br>
            Include original text in popup?<br>
            &nbsp;&nbsp;&nbsp; <input type="radio" name="wpst[originaltext]" value="yes" $ot_yes>Yes (default)<br>
            &nbsp;&nbsp;&nbsp; <input type="radio" name="wpst[originaltext]" value="no" $ot_no>No<br><br>
            Add tooltip quicktag to blog post HTML editor?<br>
            &nbsp;&nbsp;&nbsp; <input type="radio" name="wpst[addquicktag]" value="yes" $aq_yes>Enable (default)<br>
            &nbsp;&nbsp;&nbsp; <input type="radio" name="wpst[addquicktag]" value="no" $aq_no>Disable<br>
         </fieldset>
         <p class="submit">
            <input type="submit" name="Submit" value="Save Changes &raquo;" />
         </p>
      </form>
   </div>
EOT;
}

   if (strpos($_SERVER['REQUEST_URI'], 'post.php') ||
       strpos($_SERVER['REQUEST_URI'], 'post-new.php') ||
       strpos($_SERVER['REQUEST_URI'], 'page-new.php') ) {

      $o = get_option('wpst_settings');
      if ($o['addquicktag'] == "yes")
         add_action('admin_footer', 'wpst_addquicktag');

      function wpst_addquicktag() {
         $o = get_option('wpst_settings');
         $spanclass = preg_replace('![\n\r]+!', "\\n", $o['spanclass']);
         $spanclass = str_replace("'", "\'", $spanclass);
         echo <<<EOT
   <script type="text/javascript">
      <!--
         if (wpstToolbar = document.getElementById("ed_toolbar")) {
            var wpstNum, wpstBtn;
            wpstNum = edButtons.length;
            edButtons[wpstNum] = new edButton('wpst_quicktag', wpstNum,
               '<span class="{$spanclass}" title="pinyin">', '</span>', '');
            var wpstBtn = wpstToolbar.lastChild;
            while (wpstBtn.nodeType != 1) {
               wpstBtn = wpstBtn.previousSibling;
            }
            wpstBtn = wpstBtn.cloneNode(true);
            wpstToolbar.appendChild(wpstBtn);
            wpstBtn.id = 'wpst_quicktag';
            wpstBtn.title = wpstNum;
            wpstBtn.value = 'pinyin';
            wpstBtn.onclick = function() {
               if (edCanvas.selectionEnd > edCanvas.selectionStart) {
                  var pinyin =
                     prompt('Enter the pinyin.  键入拼音.','');
                  if (pinyin) {
                     var wpstNum = this.title;
                     edButtons[wpstNum].tagStart =
                        '<span class="{$spanclass}" ' +
                        'title="' + pinyin + '">';
                     edInsertTag(edCanvas, parseInt(this.title));
                  }
               } else {
                  alert('Please highlight some text first.');
                  edCanvas.focus();
               }
            }
         }
      //-->
   </script>
EOT;
      }
   }

//
// KasTooltip stuff
//

   function wpst_wp_head() {
      global $PLUGINURL;

      $o = get_option('wpst_settings');
      $theme = $o['theme'];
      $js_url = $PLUGINURL . "/js";
      $style_url = $PLUGINURL . "/style";
      $theme_url = $PLUGINURL . "/themes";
      $sc = $o['spanclass'];
      $ot = $o['originaltext'];
      echo <<<EOT
   <link rel="stylesheet" type="text/css" href="$style_url/SinospliceTooltips.css" />
   <link rel="stylesheet" type="text/css" href="$theme_url/$theme.css" />
   <script type="text/javascript" src="$js_url/SinospliceTooltips.js"></script>
   <script type="text/javascript">
      var spanclass = '$sc';
      var originaltext = '$ot';
      eST = function(){enableSinospliceTooltips()};
      if (window.addEventListener) // W3C standard
         window.addEventListener('load',eST,false)
      else if (window.attachEvent) // MSIE
         window.attachEvent('onload',eST);
   </script>
EOT;
   }
?>
