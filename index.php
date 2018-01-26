<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900">
        <link rel="stylesheet" href="css/style.css">

        <title>Rajohan.no - Design V2</title>
    </head>
    <body>
        <button class="back-to-top">
            <svg viewBox="0 0 100 100">
                <path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 0) rotate(90)"></path>
            </svg>
        </button>
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
                    <a href="#" id="header__button" class="btn btn--primary u-margin-top-medium">See tutorials</a>
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
        <!-- NAVIGATION START -->
        <nav class="navigation">
            <img src="img/logo_white.png" alt="Logo" class="navigation__logo">
            <ul class="navigation__list">
                <li class="navigation__item">
                    <a href="#" class="navigation__link navigation__link--active">
                        Home
                    </a>
                </li>
                <li class="navigation__item">
                    <a href="#" class="navigation__link">
                        About
                    </a>
                </li>
                <li class="navigation__item">
                    <a href="#" class="navigation__link">
                        Services
                    </a>
                </li>
                <li class="navigation__item">
                    <a href="#" class="navigation__link">
                        Projects
                    </a>
                </li>
                <li class="navigation__item">
                    <a href="#" class="navigation__link">
                        Blog
                    </a>
                </li>
                <li class="navigation__item">
                    <a href="#" class="navigation__link">
                        Contact
                    </a>
                </li>
            </ul>
            <div class="navigation__hamburger-menu">
                <button class="navigation__button">
                </button>
            </div>
        </nav>
        <!-- NAVIGATION END -->
        <!-- SECTION ABOUT START -->
        <section class="section-about u-margin-top-medium u-margin-bottom-medium">
            <h1 class="heading-secondary letter-spacing-medium">About me</h1>
            <h1 class="heading-tertiary">Web developer &amp; designer</h1>
            <p class="section-about__text u-margin-top-medium">
                Hello! My name is Raymond, and I'm a Norwegian-based web developer. I'm working remotely on projects for clients all over the world.
                I have a diverse set of skills. Ranging from design to HTML, CSS/SASS and Javascript/jQuery. All the way to PHP and custom CMS systems and Linux server administration.
                <br><br>
                I provide a single source high quality solution for enforcing your business existence online. 
                My services include web development, programming, content development and web hosting. 
                From simple one page websites, all the way to custom built content management systems from scratch.
            </p>
            <div class="section-about__cta">
                <a href="#" class="btn btn--secondary u-margin-top-medium">More about me</a>
                <a href="#" class="btn btn--secondary u-margin-sides-medium u-margin-top-medium">View services</a>    
                <a href="#" class="btn btn--secondary u-margin-top-medium">Contact me</a>  
            </div>
            <div class="section-about__social">
                <a href="https://www.facebook.com/raymond.johannessen.5" target="_blank" class="section-about__social--link">
                    <img src="img/icons/facebook.svg" alt="Facebook" class="section-about__social--img">
                </a>
                <a href="https://twitter.com/Rajohan" target="_blank" class="section-about__social--link">
                    <img src="img/icons/twitter.svg" alt="Twitter" class="section-about__social--img">
                </a>
                <a href="https://www.linkedin.com/in/rajohan/" target="_blank" class="section-about__social--link">
                    <img src="img/icons/linkedin.svg" alt="LinkedIn" class="section-about__social--img">
                </a>
                <a href="https://github.com/rajohan" target="_blank" class="section-about__social--link">
                    <img src="img/icons/github.svg" alt="Github" class="section-about__social--img">
                </a>
                <a href="mailto:mail@rajohan.no" class="section-about__social--link">
                    <img src="img/icons/mail.svg" alt="Mail" class="section-about__social--img">
                </a>
            </div>
        </section>
        <!-- SECTION ABOUT END -->
        <!-- SECTION WHY ME START -->
        <section class="section-why-me u-margin-top-medium">
            <h1 class="heading-primary heading-primary--sub2 u-center-text">
                Why choose me?
            </h1>
            <p class="section-why-me__text u-margin-top-medium">
            There are many benefits to working with a freelance web developer. 
            When I’m working on a project, I’ll be the main point of contact at all times avoiding any communication delays that might occur with larger companies.
            <br><br>
            I have an unfair advantage over most of the competition when it comes to prices. 
            While they need to pay for their office, their staff, their advertising and many other business expenses. I don’t. 
            Which means you avoid paying large overheads. 
            By choosing me, you can be sure that you’re only paying for your website, and not the company picnic.
            <br><br>
            I can complete your project at a rapid pace &ndash; in less time than the typical bureaucratic company can. 
            Most design agencies can take months to build a website for you. 
            Meanwhile, you are missing out on customer orders, website traffic, search engine indexing, and greater visibility on the web from social media links to your website.
            </p>
            <a href="#" class="btn btn--primary u-margin-top-medium">Contact me today!</a>  
        </section>
        <!-- SECTION WHY ME END -->
        <!-- SECTION PROJECTS START -->
        <section class="projects">
            <h1 class="heading-secondary heading-secondary--white letter-spacing-medium u-margin-top-medium">Projects</h1>
            <h1 class="heading-tertiary letter-spacing-small">My latest projects</h1>
            <div class="projects__container">
                <div class="projects__box">
                    <img src="img/projects/natours.png" alt="Natours" class="projects__img">
                    <h3 class="u-margin-top-small">Webpage &ndash; Natours</h3>
                    Exciting tours for adventurous people. This page was made for learning purposes. This site should work in all browsers.
                    <span class="u-margin-top-small">
                        <a href="#" class="projects__view whitelink">View project <span>&roarr;</span></a>
                    </span>
                </div>
                <div class="projects__box">
                    <img src="img/projects/nexter.png" alt="Nexter" class="projects__img">
                    <h3 class="u-margin-top-small">Webpage &ndash; Nexter</h3>
                    Your home, your freedom. This page was made for learning purposes. Because this site is made with new technology it will not work in Internet explorer.
                    <span class="u-margin-top-small">
                        <a href="#" class="projects__view whitelink">View project <span>&roarr;</span></a>
                    </span>
                </div>
                <div class="projects__box">
                    <img src="img/projects/trillo.png" alt=">Trillo" class="projects__img">
                    <h3 class="u-margin-top-small">Webpage &ndash; Trillo</h3>
                    Your all-in-one booking app. This page was made for learning purposes. Because this site is made with new technology it will not work in Internet explorer.
                    <span class="u-margin-top-small">
                        <a href="#" class="projects__view whitelink">View project <span>&roarr;</span></a>
                    </span>
                </div>
            </div>
            <a href="#" class="btn btn--primary u-margin-top-medium u-margin-bottom-medium">See more projects</a>  
        </section>
        <!-- SECTION PROJECTS END -->
        <!-- SECTION SERVICES START -->
        <section class="services u-margin-top-medium">
            <h1 class="heading-secondary letter-spacing-medium">Services</h1>
            <h1 class="heading-tertiary  u-margin-bottom-medium">An overview of my services</h1>
            <div class="services__container">
                <div class="services__box">
                    <img src="img/icons/webdesign.svg" alt="Web design" class="services__icon">
                    <h3>Web design</h3>
                    <p class="services__text">
                    The design of a website is important because it affects how quickly visitors can find what they are looking for.  
                    If it is difficult or frustrating, the visitor will leave and try on another site and that is a lost opportunity.  
                    </p>
                </div>
                <div class="services__box">
                <img src="img/icons/code.svg" alt="Web development" class="services__icon">
                <h3>Website development</h3>
                    <p class="services__text">
                    Website development is a way to make people aware of your business, understand why your products are relevant, and see which of your company's qualities that set it apart from the competitors. 
                    </p>
                </div>
                <div class="services__box">
                <img src="img/icons/support.svg" alt="Support" class="services__icon">
                <h3>Support</h3>
                    <p class="services__text">
                        Support is really important, a streamlined process that helps develop the project and maintain its relevance. 
                        That is why I'm ready to provide you with my support 24 hours a day, 7 days a week. You can always rely on me.
                    </p>
                </div>
                <div class="services__box">
                <img src="img/icons/seo.svg" alt="Search engine optimization" class="services__icon">
                <h3>Search engine optimization</h3>
                    <p class="services__text">
                    In today’s competitive market, SEO is more important than ever. Search engines serve millions of users per day looking for answers or solutions to their problems.
                    SEO can help your business grow and meet the business goals.
                    </p>
                </div>
            </div>
            <div class="services__cta">
                <a href="#" class="btn btn--secondary u-margin-top-medium u-margin-bottom-medium">View all services</a> 
            </div> 
        </section>
        <!-- SECTION SERVICES END -->
        <!-- SECTION LATEST NEWS START -->
        <section class="latest-news">
            <h1 class="heading-secondary letter-spacing-medium u-margin-top-medium">LATEST</h1>
            <h1 class="heading-tertiary">News &amp; tutorials </h1>
            <div class="latest-news__wrapper">
                <div class="latest-news__box">
                    <img src="img/news/news3.png" alt="Latest news" class="latest-news__img">
                    <div class="latest-news__text">
                        <h3>Lorem ipsum</h3>
                        Lorem ipsum dolor sit amet, vim ea dolorem scribentur. Cum ea erant denique, tation persius eruditi at nec. Mel iudico luptatum ut.
                        <span class="u-margin-top-small">
                            <a href="#" class="latest-news__read-more">Read more <span>&roarr;</span></a>
                        </h3>
                    </div>
                </div>
                <div class="latest-news__box">
                    <img src="img/tutorials/guide1.jpg" alt="Latest tutorial" class="latest-news__img">
                    <div class="latest-news__text">
                        <h3>vim ea dolorem scribentur</h3>
                        Vim ea dolorem scribentur.  Mel iudico luptatum ut. Duo atqui evertitur id, et vidit tollit vix. Cum ea erant denique, Lorem ipsum dolor sit amet. 
                        <span class="u-margin-top-small">
                            <a href="#" class="latest-news__read-more">Read more <span>&roarr;</span></a>
                        </h3>
                    </div>
                </div>
                <div class="latest-news__box">
                    <img src="img/tutorials/guide3.jpg" alt="Latest tutorial" class="latest-news__img">
                    <div class="latest-news__text">
                        <h3>vim ea dolorem scribentur</h3>
                        Vim ea dolorem scribentur.  Mel iudico luptatum ut. Duo atqui evertitur id, et vidit tollit vix. Cum ea erant denique, Lorem ipsum dolor sit amet. 
                        <span class="u-margin-top-small">
                            <a href="#" class="latest-news__read-more">Read more <span>&roarr;</span></a>
                        </span>
                    </div>
                </div>
            </div>
            <a href="#" class="btn btn--secondary u-margin-top-medium u-margin-bottom-medium">See all news/tutorials</a> 
        </section>
        <!-- SECTION LATEST NEWS END -->
        <!-- SECTION CONTACT ME START -->
        <section class="contact-me">
            <h1 class="heading-secondary heading-secondary--white letter-spacing-medium u-margin-top-medium">Contact me</h1>
            <h1 class="heading-tertiary">And get answer within 24 hours!</h1>
            <div class="contact-me__container">
                <form class="contact-me__form" method="post">
                    <fieldset class="required required__grey">
                        <div id="contact-me__name-img" class="contact-me__input-img">
                        </div>
                        <input placeholder="Your name" name="contact-me__name"  id="contact-me__name" class="contact-me__input" type="text" tabindex="1">
                    </fieldset>
                    <fieldset class="required required__grey">
                        <div id="contact-me__mail-img" class="contact-me__input-img">
                        </div>
                        <input placeholder="Your email address" name="contact-me__mail" id="contact-me__mail" class="contact-me__input" type="text" tabindex="2">
                    </fieldset>
                    <fieldset class="not-required not-required__grey">
                        <div id="contact-me__firmname-img" class="contact-me__input-img">
                        </div>
                        <input placeholder="Company name (optional)" name="contact-me__firmname" id="contact-me__firmname" class="contact-me__input" type="text" tabindex="3">
                    </fieldset>
                    <fieldset class="not-required not-required__grey">
                        <div id="contact-me__tel-img" class="contact-me__input-img">
                        </div>
                        <input placeholder="Your telephone number (optional)" name="contact-me__tel" id="contact-me__tel" class="contact-me__input" type="text" tabindex="4">
                    </fieldset>
                    <fieldset class="not-required not-required__grey">
                        <div id="contact-me__webpage-img" class="contact-me__input-img">
                        </div>
                        <input placeholder="Your web page (optional)" name="contact-me__webpage" id="contact-me__webpage" class="contact-me__input" type="text" tabindex="5">
                    </fieldset>
                    <fieldset class="required required__grey">
                        <div id="contact-me__subject-img" class="contact-me__input-img">
                        </div>
                        <input placeholder="Subject" id="contact-me__subject" name="contact-me__subject" class="contact-me__input" type="text" tabindex="6">
                    </fieldset>
                    <fieldset class="required required__grey">
                        <div id="contact-me__message-img" class="contact-me__input-img"> 
                        </div>
                        <textarea placeholder="Your message..." id="contact-me__message" class="contact-me__textarea" name="contact-me__message" tabindex="7"></textarea>
                    </fieldset>
                    <fieldset>
                        <button type="submit" name="contact-me__submit" class="btn btn--tertiary u-margin-top-medium u-margin-bottom-medium">Send message</button>
                    </fieldset>
                </form>
            </div>
        </section>
        <!-- SECTION CONTACT ME END -->
        <!-- SECTION FOOTER START -->
        <footer class="footer">
            <a href="#">SSL Certificate</a> &ndash; <a href="#">Legal policies</a> &ndash; <a href="#">Sitemap</a>
            <br> 
            <a href="https://www.copyrighted.com/website/uSpDm4NTL5wPLq0d?url=https%3A%2F%2Frajohan.no%2F" target="_blank">Copyrighted.com registered &amp; protected</a> © 2017-<?php echo date('Y'); ?> <a href="https://rajohan.no">Rajohan.no</a>, <a href="https://w2.brreg.no/enhet/sok/detalj.jsp?orgnr=998619335" target="_blank">Raymond Johannessen Webutvikling.</a>
        </footer>
        <!-- SECTION FOOTER END -->
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/script.js"></script>
        <script src="js/img_carousel.js"></script>
        <script src="js/contact_me.js"></script>
    </body>
  </head>
</html>