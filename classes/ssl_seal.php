<?php
    
    ###########################################################################
    # Get url id parts from alphassl and generate url
    ###########################################################################
    class Ssl_seal {

        function generate_url() {

            $url = file_get_contents('http://seal.alphassl.com/SiteSeal/siteSeal/siteSeal/siteSeal.do?p1=rajohan.no&p2=SZ115-55&p3=image&p4=en&p5=V0000&p6=S001&https');
            preg_match_all('/ss_url_p1(.*?)=(.*?)"(.*?)"/s', $url, $url_part1);
            preg_match_all('/ss_url_p2(.*?)=(.*?)"(.*?)"/s', $url, $url_part2);
            preg_match_all('/ss_url_p3(.*?)=(.*?)"(.*?)"/s', $url, $url_part3);
            echo "https://seal.alphassl.com/SiteSeal/siteSeal/profile/profile.do?p1=".$url_part1['3']['0']."&p2=".$url_part2['3']['0']."&p3=".$url_part3['3']['0'];
        
        }

    }
    
?>