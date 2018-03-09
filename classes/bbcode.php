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
        // Method to replace html with bbcodes
        //-------------------------------------------------

        function html_to_bbcode($data) {
            
            $find = array(

                    '~&nbsp;~i',
                    '~\<b\>|\<b [ A-z0-9=":;.\-]{0,}\>~i',
                    '~\<\/b\>~i',
                    '~\<li\>|\<li [ A-z0-9=":;.\-]{0,}\>~i',
                    '~\<\/li\>~i',
                    '~\<br\>|\<br [ A-z0-9=":;.\-]{0,}\>~i',
                    '~\<ul\>|\<ul [ A-z0-9=":;.\-]{0,}\>~i',
                    '~\<\/ul\>~i',
                    '~\<ol\>|\<ol [ A-z0-9=":;.\-]{0,}\>~i',
                    '~\<\/ol\>~i',
                    '~\<p\>|\<p [ A-z0-9=":;.\-]{0,}\>~i',
                    '~\<\/p\>~i',
                    '~\<i\>|\<i [ A-z0-9=":;.\-]{0,}\>~i',
                    '~\<\/i\>~i',
                    '~\<u\>|\<u [ A-z0-9=":;.\-]{0,}\>~i',
                    '~\<\/u\>~i',
                    '~\<div .*class="text-editor__image__box" .*style=".*(width:[ A-z0-9]{1,};|height:[ A-z0-9]{1,};).*(width:[ A-z0-9]{1,};|height:[ A-z0-9]{1,};).*"[ A-z0-9=":;.\-]{0,}\>([\s\S]*?)\<img .*src="((?:http|https?):\/\/.*?\.(?:jpg|jpeg|gif|png|bmp|svg))"[ A-z0-9=":;.\-]{0,}\>([\s\S]*?)\<\/div\>~i',
                    '~\<div\>|\<div [ A-z0-9=":;.\-]{0,}\>~i',
                    '~\<\/div\>~i',
                    '~\<strike\>|\<strike [ A-z0-9=":;.\-]{0,}\>~i',
                    '~\<\/strike\>~i',
                    '~\<a .*href="((?:ftp|http|https?):\/\/[A-z0-9.\-]{1,})"[ A-z0-9=":;.\-]{0,}\>(.*?)\<\/a\>~i',
                    '~\<a .*href="((?:mailto?):[ A-z0-9.\-@]{1,})"[ A-z0-9=":;.\-]{0,}\>(.*?)\<\/a\>~i',
                    '~\<img src="((?:http|https?):\/\/.*?\.(?:jpg|jpeg|gif|png|bmp|svg))"\>~i',
                    '~\<img src="img\/icons\/emoticons\/(smile\.svg|wink\.svg|kiss\.svg|unsure\.svg|cry\.svg|tongue\.svg|grin\.svg|grumpy\.svg|astonished\.svg|afraid\.svg|nerd\.svg|sunglasses\.svg|angry\.svg|frowny\.svg|love\.svg|confused\.svg|dejected\.svg|laugh\.svg|big_eyes\.svg|silent\.svg)" class="emoticon" style="[A-z0-9\-: ;\.]{0,}margin-bottom: -0.3rem; width: 1.7rem; height: 1.7rem;[A-z0-9\-: ;\.]{0,}"\>~i'
                
                );
                
    
                $replace = array(

                    ' ',
                    '[b]',
                    '[/b]',
                    '[li]',
                    '[/li]',
                    '[br]',
                    '[ul]',
                    '[/ul]',
                    '[ol]',
                    '[/ol]',
                    '[p]',
                    '[/p]',
                    '[i]',
                    '[/i]',
                    '[u]',
                    '[/u]',
                    '$3[img $1 $2]$4[/img]$5',
                    '[br]',
                    '',
                    '[strike]',
                    '[/strike]',
                    '[url=$1]$2[/url]',
                    '[url=$1]$2[/url]',
                    '[img]$1[/img]',
                    '[emoticon]$1[/emoticon]'
  
                );
    
                return preg_replace($find,$replace,$data);
    
        }

        //-------------------------------------------------
        // Method to replace bbcodes with html
        //-------------------------------------------------

        function replace($data) {
            
            $find = array(

                '~\[b\]~i',
                '~\[\/b\]~i',
                '~\[li\]~i',
                '~\[\/li\]~i',
                '~\[br\]~i',
                '~\[ul\]~i',
                '~\[\/ul\]~i',
                '~\[ol\]~i',
                '~\[\/ol\]~i',
                '~\[p\]~i',
                '~\[\/p\]~i',
                '~\[i\]~i',
                '~\[\/i\]~i',
                '~\[u\]~i',
                '~\[\/u\]~i',
                '~\[strike\]~i',
                '~\[\/strike\]~i',
                '~\[table\]~i',
                '~\[\/table\]~i',
                '~\[tr\]~i',
                '~\[\/tr\]~i',
                '~\[td\]~i',
                '~\[\/td\]~i',
                '~\[quote\]~i',
                '~\[\/quote\]~i',
                '~\[code\]~i',
                '~\[\/code\]~i',
                '~\[size=(.*?)\]~i',
                '~\[\/size\]~i',
                '~\[color=((?:[a-zA-Z]|#[a-fA-F0-9]{3,6})+)\]~i',
                '~\[\/color\]~i',
                '~\[url\]((?:ftp|http|https?):\/\/.*?)\[\/url\]~i',
                '~\[url=((?:ftp|http|https?):\/\/.*?)\](.*?)\[\/url\]~i',
                '~\[url=((?:mailto?):.*?)\](.*?)\[\/url\]~i',
                '~\[img\]((?:http|https?):\/\/.*?\.(?:jpg|jpeg|gif|png|bmp|svg))\[\/img\]~i',
                '~\[img (.*)\]((?:http|https?):\/\/.*?\.(?:jpg|jpeg|gif|png|bmp|svg))\[\/img\]~i',
                '~\[emoticon\]([A-z0-9\-\.]{1,})\[\/emoticon\]~i',
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
                '<strike>',
                '</strike>',
                '<table>',
                '</table>',
                '<tr>',
                '</tr>',
                '<td>',
                '</td>',
                '<span class="quote">',
                '</span>',
                '<pre>',
                '</pre>',
                '<span style="font-size:$1px;">',
                '</span>',
                '<span style="color:$1;">',
                '</span>',
                '<a href="$1" target="_blank">$1</a>',
                '<a href="$1" target="_blank">$2</a>',
                '<a href="$1">$2</a>',
                '<img src="$1" alt="$1" style="float:left; margin:1rem; margin-right: 2rem;"><br>',
                '<img src="$2" alt="$2" style="$1 float:left; margin:1rem; margin-right: 2rem;"><br>',
                '<img src="img/icons/emoticons/$1" alt="$1" class="emoticons">'


            );

            return preg_replace($find,$replace,$data);

        }

    }
    
?>