<?php
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
?>

<!-- HEADER START -->
<div class="header__placeholder">
    <header class="header">
        <div class="header__logo-box">
            <img src="img/logo_white.png" alt="Logo" class="header__logo">
        </div>
        <div class="header__text-box">
            <h1 class="heading-primary u-center-text">
                <span id="header__title" class="heading-primary--main">
                    Learn the basics
                </span>
                <span id="header__text" class="heading-primary--sub">
                    HTML, CSS, JavaScript, jQuery and PHP tutorials
                </span>
            </h1>
            <a href="blog/" id="header__button" class="btn btn--primary u-margin-top-medium">See tutorials</a>
        </div>
        <button class="header__img-switcher header__img-switcher--prev">
            <svg viewBox="0 0 100 100">
                <path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path>
            </svg>
        </button>
        <button class="header__img-switcher header__img-switcher--next">
            <svg viewBox="0 0 100 100">
                <path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 100) rotate(180)"></path>
            </svg>
        </button>
        <div class="header__circles">
            <div id="header__switcher-1" data="1" class="header__circle-switcher header__circle-switcher--active">
                &nbsp;
            </div>
            <div id="header__switcher-2" data="2" class="header__circle-switcher">
                &nbsp;
            </div>
            <div id="header__switcher-3" data="3" class="header__circle-switcher">
                &nbsp;
            </div>
            <div id="header__switcher-4" data="4" class="header__circle-switcher">
                &nbsp;
            </div>
        </div>
    </header>
</div>
<!-- HEADER END -->