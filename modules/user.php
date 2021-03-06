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
    $page = new Page_handler;
    $view = new Views;
    $bbcode = new Bbcode;
    $login = new Login;
    
    //-------------------------------------------------
    // Get user data
    //-------------------------------------------------
    
    $profile = $page->get_user(); // Set user equal to last url parameter. 0 if last url parameter is invalid or empty.

    if($profile !== 0) {

        $user_data = $user->get_user("ID", $profile);

        if((empty($user_data)) || ($user_data['ID'] === 0)) {

            $user_data = $user->get_user("USERNAME", $profile);

        }

    }
    else if(($profile === 0) && ($login->login_check())) {

        $user_data = $user->get_user("ID", $_SESSION['USER']['ID']);

    }

?>
<!-- SECTION USER START -->
<div class="container u-margin-bottom-medium">
    <?php

        if(empty($user_data)) {

            echo "The user profile you are trying to view does not exist";
            
        } else {
        
            //-------------------------------------------------
            // Add profile view to db to db if its a new user
            //-------------------------------------------------

            $view->add_user_profile_view($user_data['ID']);

            //-------------------------------------------------
            //  Get views count
            //-------------------------------------------------

            $db_conn = new Database;
            $view_count = $db_conn->count('USER_PROFILE_VIEWS', 'WHERE USER_ID = ?', 'i', array($user_data['ID']));

    ?>
    <div class="user">
        <div class="user__header">
            <div class="user__header__details">
                <?php
                    if(empty($user_data['IMG'])) {
                        $user_data['IMG'] = "img/icons/user2.svg";
                    }
                ?>
                <img src="<?php echo $user_data['IMG']; ?>" alt="User photo" class="user__header__details__img">
                
                <div class="user__header__details__info">
                    <div class="user__header__details__info__name">
                        <?php 

                            if((empty($user_data['FIRST_NAME'])) && (empty($user_data['LAST_NAME']))) {
                                $user_data['FIRST_NAME'] = "N/A";
                                $user_data['LAST_NAME'] = "";
                            }

                            if($user_data['HIDE_FIRST_NAME'] === "1") {
                                $user_data['FIRST_NAME'] = "";
                            }

                            if($user_data['HIDE_LAST_NAME'] === "1") {
                                $user_data['LAST_NAME'] = "";
                            }

                            if(($user_data['HIDE_FIRST_NAME'] === "1") && ($user_data['HIDE_LAST_NAME'] === "1")) {

                                echo "Name hidden";

                            } else {

                                echo ucfirst($user_data['FIRST_NAME'])." ".ucfirst($user_data['LAST_NAME']); 

                            }
                        
                        ?>
                    </div>
                    <div class="user__header__details__info__username">
                        @<?php echo $user_data['USERNAME']; ?>
                    </div>
                    <div class="user__header__details__info__social-media" <?php if((empty($user_data['FACEBOOK'])) && (empty($user_data['TWITTER'])) && (empty($user_data['LINKEDIN'])) && (empty($user_data['GITHUB']))) { echo 'style="display: none;"'; } ?>>
                        <?php if(!empty($user_data['FACEBOOK'])) { ?>
                            <a href="<?php echo $user_data['FACEBOOK']; ?>" target="_blank">
                                <img src="img/icons/facebook.svg" alt="Facebook" class="user__header__details__info__social-media__img">
                            </a>
                        <?php } ?>
                        <?php if(!empty($user_data['TWITTER'])) { ?>
                            <a href="<?php echo $user_data['TWITTER']; ?>" target="_blank">
                                <img src="img/icons/twitter.svg" alt="Twitter" class="user__header__details__info__social-media__img">
                            </a>
                        <?php } ?>
                        <?php if(!empty($user_data['LINKEDIN'])) { ?>
                            <a href="<?php echo $user_data['LINKEDIN']; ?>" target="_blank">
                                <img src="img/icons/linkedin.svg" alt="LinkedIn" class="user__header__details__info__social-media__img">
                            </a>
                        <?php } ?>
                        <?php if(!empty($user_data['GITHUB'])) { ?>
                            <a href="<?php echo $user_data['GITHUB'] ?>" target="_blank">
                                <img src="img/icons/github.svg" alt="Github" class="user__header__details__info__social-media__img">
                            </a>
                        <?php } ?>
                    </div> 
                </div>    
            </div>
            <div class="user__header__stats">
                <div class="user__header__stats__comments">
                    <div class="user__header__stats__count">
                        <?php 

                            $db_conn = new Database;
                            $comments =  $db_conn->count('COMMENTS', 'WHERE `POSTED_BY_USER` = ?', 'i', array($user_data['ID']));

                            echo $comments;

                        ?>
                    </div>
                    <div class="user__header__stats__text">
                        Comments
                    </div>
                </div>
                <div class="user__header__stats__rating">
                    <div class="user__header__stats__count">
                        <?php echo $user->rating($user_data['ID']); ?>
                    </div>
                    <div class="user__header__stats__text">
                        Rating
                    </div>
                </div>
                <div class="user__header__stats__views">
                    <div class="user__header__stats__count">
                        <?php echo $view_count; ?>
                    </div>
                    <div class="user__header__stats__text">
                    <?php 
                    
                    if($view_count === 1) { 

                        echo "View";

                    } else {

                        echo "Views";

                    }

                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="user__info">
            <div class="user__info__details">
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Email address:
                        <?php 

                            if($user_data['HIDE_EMAIL'] === "1") {

                                echo "</span>hidden";

                            } else {

                        ?>
                        <a href="mailto: <?php echo $user_data['EMAIL']; ?>"><?php echo $user_data['EMAIL']; ?></a>
                     </span>
                    <?php
                        }
                    ?>
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Gender:
                    </span>
                    <?php 

                        if(empty($user_data['GENDER'])) {

                            $user_data['GENDER'] = "N/A";

                        } 

                        echo ucfirst($user_data['GENDER']);

                    ?>
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Age:
                    </span>
                    <?php 
                        if($user_data['HIDE_BORN'] === "1") {

                            echo "hidden";

                        } else {

                            if(empty($user_data['BORN'])) {

                                echo "N/A";

                            } else {

                                $age = $converter->age($user_data['BORN']);
                                $born = $converter->date($user_data['BORN']);

                                echo $age." (".$born.")"; 

                            }

                        }

                    ?>
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Phone:
                    </span>
                    <?php 

                        if($user_data['HIDE_PHONE'] === "1") {

                            echo "hidden";

                        } else {

                            if(empty($user_data['BORN'])) {

                                $user_data['PHONE'] = "N/A";

                            }

                            echo $user_data['PHONE'];
                            
                        }
                        
                    ?>
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Address:
                    </span>
                    <?php 
                    
                        if($user_data['HIDE_ADDRESS'] === "1") {

                            echo "hidden";
                            
                        } else {

                            if(empty($user_data['ADDRESS'])) {

                                $user_data['ADDRESS'] = "N/A";

                            }

                            echo ucfirst($user_data['ADDRESS']); 

                        }

                    ?>
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Country:
                    </span>
                    <?php 

                        if(empty($user_data['COUNTRY'])) {

                            $user_data['COUNTRY'] = "N/A";

                        }

                        echo ucfirst($user_data['COUNTRY']); 

                    ?>
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Webpage:
                        <?php

                            if(empty($user_data['WEBPAGE'])) {

                                echo "</span> N/A";

                            } else {

                                echo "<a href='".$user_data['WEBPAGE']."' target='_blank'>".$user_data['WEBPAGE']."</a></span>";

                            }

                        ?>
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Company:
                    </span>
                    <?php 

                        if(empty($user_data['FIRMNAME'])) {

                            $user_data['FIRMNAME'] = "N/A";

                        }

                        echo ucfirst($user_data['FIRMNAME']); 
                    
                    ?>
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Company role:
                    </span>
                    <?php 

                        if(empty($user_data['FIRM_ROLE'])) {

                            $user_data['FIRM_ROLE'] = "N/A";

                        }

                        echo ucfirst($user_data['FIRM_ROLE']); 
                    
                    ?>
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Reg date:
                    </span>
                    <?php 
                        $reg_date = $converter->date($user_data['REG_DATE']);
                        echo $reg_date; 
                    ?>
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Access level:
                    </span>
                    <?php 
                        
                        echo $converter->admin($user_data['ADMIN']);
                    
                    ?>
                </span>
                <span class="user__info__details__item">
                    <span class="user__info__details__item__title">
                        Last seen:
                    </span>
                    <?php
                    
                        $last_seen = $user->last_seen($user_data['ID']);

                        if($last_seen !== "N/A") {

                            $last_seen = $converter->date_time($last_seen);

                        }
                        
                        echo $last_seen;

                    ?>
                </span>
            </div>
            <div class="user__info__bio">
                <span class="user__info__bio__title">
                    User biography
                </span>
                <div class="user__info__bio__text">
                    <?php 
                        
                        $db_conn = new Database;
                        $stmt = $db_conn->connect->prepare("SELECT `BIO` FROM `USERS` WHERE `ID` = ?");
                        $stmt->bind_param("i", $user_data['ID']);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {

                            $bio = $row['BIO'];

                        }

                        $db_conn->free_close($result, $stmt);

                        if(empty($bio)) {

                            $bio = "N/A";

                        }

                        echo $bbcode->replace($filter->sanitize_code($bio)); 

                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
        }
    ?>
</div>
<!-- SECTION USER END -->