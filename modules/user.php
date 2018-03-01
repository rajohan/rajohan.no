<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------
    
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Initialize classes
    //-------------------------------------------------
    
    $filter = new Filter;
    $converter = new Converter;
    $user = new Users;
    //$user_data = $user->get_user("ID", $_SESSION['USER']['ID']);
?>

<!-- SECTION USER START -->
<div class="container u-margin-bottom-medium">
    <div class="user">
        <div class="user__header">
            <div class="user__header__details">
                <img src="img/me.jpg" alt="User photo" class="user__header__details__img">
                <div class="user__header__details__info">
                    <div class="user__header__details__info__name">
                        <?php //echo $user_data['NAME']; ?>Raymond Johannessen
                    </div>
                    <div class="user__header__details__info__username">
                        @<?php //echo $user_data['USERNAME']; ?>Rajohan
                    </div>
                </div> 
            </div>
            <div class="user__header__stats">
                <div class="user__header__stats__comments">
                    <div class="user__header__stats__count">
                        154
                    </div>
                    <div class="user__header__stats__text">
                        Comments
                    </div>
                </div>
                <div class="user__header__stats__rating">
                    <div class="user__header__stats__count">
                        10.0
                    </div>
                    <div class="user__header__stats__text">
                        Rating
                    </div>
                </div>
                <div class="user__header__stats__views">
                    <div class="user__header__stats__count">
                        215
                    </div>
                    <div class="user__header__stats__text">
                        Views
                    </div>
                </div>
            </div>
        </div>
        <div class="user__info">
            <div class="user__info__details">
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Email address:
                    </span>
                    rajohan1@gmail.com
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Age:
                    </span>
                    28 (29.03.1989)
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Phone:
                    </span>
                    +47 99591387
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Address:
                    </span>
                    Steinhuggerveien 35, 1820 Spydeberg, Norway
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Webpage:
                        <a href="https://rajohan.no">rajohan.no</a>
                    </span>
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Company:
                    </span>
                    Raymond Johannessen Webutvikling
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Company role:
                    </span>
                    Web developer
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Reg date:
                    </span>
                    01.03.2018
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Access level:
                    </span>
                    Site owner
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Last seen:
                    </span>
                    01.03.2018 - 22:15
                </span>
            </div>
            <div class="user__info__bio">
                <span class="user__info__bio__title">User biography</span>
                Hello! My name is Raymond, and I'm a Norwegian-based web developer.  I am 100% self-taught in programming and have an education as an electrician. I have been very interested in data and electronics ever since I was a young kid. We got the first computer at home when I was around 10-11 years old and I bought my first own computer when I was 13. Ever since then I have spent a lot of time on my pc. I started with programming around 2004 and have coded on and off since then.
            </div>
        </div>
    </div>
</div>
<!-- SECTION USER END -->