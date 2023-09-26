<?php
/**
 * @version	$Id: h5audio.php 2023-09-17 14:00 (1.0)
 * @author      Andreas Witez
 * @authorUrl   witez.net
 * @email       andreas@witez.net
 * @copyright	Copyright (C) 2023 Andreas Witez. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//jimport('joomla.plugin.plugin');

/**
 * h5audio plugin class.
 *
 * @package		Joomla.Plugin
 * @subpackage	Content.pagenavigation
*/

// Google Analytics 4 compatible!

class plgContenth5audio extends JPlugin
{
    //public function onContentPrepare($context, &$article, &$params, $page = 0)
    public function onContentPrepare($context, &$article, &$params, $limitstart)
    {             
        //{h5audio|file=test|width=200}
        $regex = '/{h5audio\s*.*?}/si';    
        preg_match_all( $regex, $article->text, $matches );
        for($x=0; $x<count($matches[0]); $x++)
        {
            $baseUrl = $this->params->get('baseurl');
            $playerWidth = $this->params->get('width', 200);
            
            
            
            $tmpStr = $matches[0][$x];            
            $tmpStr = str_replace("{h5audio|", "" , $tmpStr);
            $tmpStr = str_replace("}", "" , $tmpStr);
            $tmpStr = explode("|", $tmpStr);
            $itIsText = false;
            for($y=0; $y<sizeof($tmpStr); $y++) 
            {
                $tmpParams = explode("=", $tmpStr[$y]);
                switch (strtolower($tmpParams[0])) 
                {
                    case 'file':
                        $playFile = $tmpParams[1];
                        if(str_replace(" ", "" , $playFile) <> $playFile)
                            $itIsText = true;
                        break;
                    case 'width':
                        $playerWidth = $tmpParams[1];
                        if(str_replace(" ", "" , $playerWidth) <> $playerWidth)
                            $itIsText = true;
                        break;
                }//swith                                
            } //for   
		//"<source src=\"".$baseUrl.$playFile.".ogg\" type=\"audio/ogg\">".
		    $replace = 	"<div style=\"width:".$playerWidth."px;max-width:100%;display:block;margin:5px;\"><audio style=\"width:100%\" preload=\"auto\" controls=\"\" tabindex=\"0\" onplay=\"gtag('event', 'audioPlayer', {'action': 'play', 'file': '".$playFile.".mp3'});\">".
                    	"<source src=\"".$baseUrl.$playFile.".mp3\" type=\"audio/mp3\">".
                    	"<p>Your browser doesn't support HTML5 audio.</p>".
                    	"</audio></div>";
                                   
            $count_def = 1;   
            if($itIsText != true) {
                $article->text = str_replace($matches[0][$x], $replace, $article->text, $count_def);           
            } 
            
        }//for
    }//public function h5audio_content
}//class plgContenth5audio extends JPlugin
?>