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
    $page = new Page_handler;
    $user = new Users;
    $login = new Login;

    //-------------------------------------------------
    // Get the navigation
    //-------------------------------------------------

    $db_conn = new Database;
    $stmt = $db_conn->connect->prepare("SELECT `NAME`, `URL` FROM `NAVIGATION` ORDER BY `ID` ASC");
    $stmt->execute();
    $result = $stmt->get_result();

    //-------------------------------------------------
    // Get user data
    //-------------------------------------------------

    if ($login->login_check()) {

        $user_data = $user->get_user("ID", $_SESSION['USER']['ID']);

    }

?>

<!-- NAVIGATION START -->
<nav class="navigation">
    <a href="home/"><img src="img/logo_white.png" alt="Logo" class="navigation__logo"></a>
    <ul class="navigation__list">

        <?php
        
            while ($row = $result->fetch_assoc()) {

                $name = $filter->sanitize($row['NAME']);
                $url = $filter->sanitize($row['URL']);

                echo '<li class="navigation__item">';
                echo '<a href="'.$url.'/" class="navigation__link '.$page->set_active($url).'">';
                echo $name;
                echo '</a>';
                echo '</li>';

            }

            $db_conn->free_close($result, $stmt);
            
        ?>

    </ul>
    <div class="navigation__center"></div>
    <div class="navigation__user-menu">
        <?php

            if($login->login_check()) {       

        ?>
        <div class="navigation__user-menu__nav">
            <?php 
            
                if(empty($user_data['IMG'])) {

                    $user_data['IMG'] = "img/icons/user2.svg";
                    
                }
            
            ?>

            <img src="<?php  echo $user_data['IMG']; ?>" alt="User photo" class="navigation__user-menu__nav__img"> 
            <div class="navigation__user-menu__nav__user">
                <?php echo $filter->cut_string($user_data['USERNAME'], 7); ?>&nbsp;<span class="navigation__user-menu__nav__user__arrow">&dtrif;</span>
            </div>
            <ul class="navigation__user-menu__nav__items">
                <li>
                    <a href="user/">
                        <img src="img/icons/user2.svg" alt="profile">
                        Profile
                    </a>
                </li>
                <li>
                    <a href="settings/">
                        <img src="img/icons/settings.svg" alt="profile">
                        Settings
                    </a>
                </li>
                <?php 
                    if($user_data['ADMIN'] > 0) {
                ?>
                <li>
                    <a href="admin/">
                        <img src="img/icons/admin.svg" alt="profile">
                        Admin
                    </a>
                </li>
                <?php
                    }
                ?>
                <li>
                    <a href="logout/">
                        <img src="img/icons/logout.svg" alt="profile">
                        Sign out
                    </a>
                </li>
            </ul>
        </div>
        <?php
            } else {
        ?>
        <a href="login/"><img src="img/icons/login.svg">Sign in</a>
        <a href="register/"><img src="img/icons/register.svg">Register</a>
        <?php
            }
        ?>
    </div>
    <div class="navigation__hamburger-menu">
        <button class="navigation__button navigation__button__closed">
        </button>
    </div>
</nav>
<!-- NAVIGATION END -->