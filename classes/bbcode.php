<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // BBcode parser
    //-------------------------------------------------
    
    class Bbcode {

        //-------------------------------------------------
        // Method to replace bbcodes with html
        //-------------------------------------------------

        function replace($data) {
            
            $find = array(
            '~\[b\]~s',
            '~\[/b\]~s',
            '~\[li\]~s',
            '~\[/li\]~s',
            '~\[br\]~s',
            '~\[ul\]~s',
            '~\[/ul\]~s',
            '~\[ol\]~s',
            '~\[/ol\]~s',
            '~\[p\]~s',
            '~\[/p\]~s',
            '~\[i\]~s',
            '~\[/i\]~s',
            '~\[u\]~s',
            '~\[/u\]~s',
            '~\[table\]~s',
            '~\[/table\]~s',
            '~\[tr\]~s',
            '~\[/tr\]~s',
            '~\[td\]~s',
            '~\[/td\]~s',
            '~\[quote\]~s',
            '~\[/quote\]~s',
            '~\[size=(.*?)\]~s',
            '~\[/size\]~s',
            '~\[color=((?:[a-zA-Z]|#[a-fA-F0-9]{3,6})+)\]~s',
            '~\[/color\]~s',
            '~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
            '~\[url=((?:ftp|https?)://.*?)\](.*?)\[/url\]~s',
            '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
            );

            $replace = array(
            '<b>',
            '</b>',
            '<li>',
            '</li>',
            '<br>',
            '<ul>',
            '</ul>',
            '<ol>',
            '</ol>',
            '<p>',
            '</p>',
            '<i>',
            '</i>',
            '<u>',
            '</u>',
            '<table>',
            '</table>',
            '<tr>',
            '</tr>',
            '<td>',
            '</td>',
            '<pre>',
            '</'.'pre>',
            '<span style="font-size:$1px;">',
            '</span>',
            '<span style="color:$1;">',
            '</span>',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>',
            '<img src="$1" alt="" />'
            );

            return preg_replace($find,$replace,$data);

        }

    }
    
?>