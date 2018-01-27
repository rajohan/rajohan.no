<?php
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
?>

<?php
    $active = new Page_handler(); // GET ACTIVE PAGE TO SET ACTIVE BUTTON 
?>
<!-- NAVIGATION START -->
<nav class="navigation">
    <a href="index.php?page=home"><img src="img/logo_white.png" alt="Logo" class="navigation__logo"></a>
    <ul class="navigation__list">
        <li class="navigation__item">
            <a href="index.php?page=home" class="navigation__link <?php $active->set_active('home'); ?>">
                Home
            </a>
        </li>
        <li class="navigation__item">
            <a href="index.php?page=about" class="navigation__link <?php $active->set_active('about'); ?>">
                About
            </a>
        </li>
        <li class="navigation__item">
            <a href="index.php?page=services" class="navigation__link <?php $active->set_active('services'); ?>">
                Services
            </a>
        </li>
        <li class="navigation__item">
            <a href="index.php?page=projects" class="navigation__link <?php $active->set_active('projects'); ?>">
                Projects
            </a>
        </li>
        <li class="navigation__item">
            <a href="index.php?page=blog" class="navigation__link <?php $active->set_active('blog'); ?>">
                Blog
            </a>
        </li>
        <li class="navigation__item">
            <a href="index.php?page=contact" class="navigation__link <?php $active->set_active('contact'); ?>">
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