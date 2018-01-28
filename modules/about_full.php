<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 
    $db_conn = new Database(); // connect to database
    $filter = new Filter(); // Start filter
    $bbcode = new Bbcode(); // Start bbcode parser
    
    $stmt = $db_conn->connect->prepare("SELECT TITLE, SUB_TITLE, ABOUT FROM `ABOUT` ORDER BY `ID` DESC LIMIT 1"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result
 
    while ($row = $result->fetch_assoc()) {

        $title = $filter->sanitize($row['TITLE']);
        $sub_title = $filter->sanitize($row['SUB_TITLE']);
        $about = $bbcode->replace($filter->sanitize($row['ABOUT']));
 
    }

    $db_conn->free_close($result, $stmt);
    
?>

<!-- SECTION ABOUT START -->
<section class="section-about u-margin-top-medium u-margin-bottom-small">
    <h1 class="heading-secondary letter-spacing-medium"><?php echo $title; ?></h1>
    <h1 class="heading-tertiary"><?php echo $sub_title; ?></h1>
    <p class="section-about__text u-margin-top-medium">
        <?php
            echo $about;
        ?>
    </p>
    <div class="section-about__social">
        <a href="<?php echo $GLOBALS['facebook']; ?>" target="_blank" class="section-about__social--link">
            <img src="img/icons/facebook.svg" alt="Facebook" class="section-about__social--img">
        </a>
        <a href="<?php echo $GLOBALS['twitter']; ?>" target="_blank" class="section-about__social--link">
            <img src="img/icons/twitter.svg" alt="Twitter" class="section-about__social--img">
        </a>
        <a href="<?php echo $GLOBALS['linkedin']; ?>" target="_blank" class="section-about__social--link">
            <img src="img/icons/linkedin.svg" alt="LinkedIn" class="section-about__social--img">
        </a>
        <a href="<?php echo $GLOBALS['github']; ?>" target="_blank" class="section-about__social--link">
            <img src="img/icons/github.svg" alt="Github" class="section-about__social--img">
        </a>
        <a href="mailto:<?php echo $GLOBALS['mail']; ?>" class="section-about__social--link">
            <img src="img/icons/mail.svg" alt="Mail" class="section-about__social--img">
        </a>
    </div>
</section>
<!-- SECTION ABOUT END -->
<!-- SECTION CV START -->
<?php
    $db_conn = new Database(); // connect to database
    $filter = new Filter(); // Start filter
    $bbcode = new Bbcode(); // Start bbcode parser


    $stmt = $db_conn->connect->prepare("SELECT * FROM `CV` ORDER BY `ID` DESC LIMIT 1"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result
    
    // Set variables with the result.
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $filter->sanitize($row["NAME"]);
        $title = $filter->sanitize($row["TITLE"]);
        $address = $filter->sanitize($row["ADDRESS"]);
        $tlf = $filter->sanitize($row["TLF"]);
        $born_unix = $filter->sanitize(strtotime($row["BORN"])); // Set birth date to unix timestap to order the date differently
        $birth_date = $filter->sanitize($row["BORN"]);
        $homepage = $filter->sanitize($row["HOMEPAGE"]);
        $mail = $filter->sanitize($row["MAIL"]);
        $profil = $bbcode->replace($filter->sanitize($row["PROFILE"]));
        $education = $bbcode->replace($filter->sanitize($row["EDUCATION"]));
        $technical = $bbcode->replace($filter->sanitize($row["TECHNICAL"]));
        $work_experience = $bbcode->replace($filter->sanitize($row["WORK_EXPERIENCE"]));
        $course = $bbcode->replace($filter->sanitize($row["COURSE"]));
        $certificates = $bbcode->replace($filter->sanitize($row["CERTIFICATES"]));
        $interests = $bbcode->replace($filter->sanitize($row["INTERESTS"]));
        $img = $filter->sanitize($row["IMG"]);
        $date_unix = $filter->sanitize(strtotime($row["DATE"])); // Set date to unix timestap to order the date differently
        $user = $filter->sanitize($row["USER"]);
    }

    $db_conn->free_close($result, $stmt); // free result and close db connection

    // Calculate age
    $birth = explode("-", $birth_date);
    $age = date("Y") - $birth[0];
    if(($birth[1] > date("m")) || ($birth[1] == date("m") && date("d") < $birth[2])) {
        $age = $age - 1;
    }

    $born = date('d.m.Y', $born_unix); // Set birth date in right order from unix timestamp
    $date = date('d.m.Y', $date_unix); // Set date in right order from unix timestamp
?>
<section class="cv">
    <div class="cv__box">
        <div  class="cv__top">
            <div class="cv__img">
                <img src="<?php echo $img; ?>" alt="me">
            </div>
            <div class="cv__info">
                <div class="cv__title">
                    <h1 class="heading-secondary"><?php echo $name; ?></h1>
                    <h1 class="heading-tertiary"><?php echo $title; ?></h1>
                </div>
                <b>Age: </b><?php echo $age." (".$born.")"; ?>
                <br>
                <b>Phone: </b><?php echo $tlf; ?>
                <br>
                <b>Address: </b><?php echo $address; ?>
                <br>
                <b>E-mail: </b><a href="mailto:<?php echo $mail; ?>"><?php echo $mail; ?></a>
                <br>
                <b>Homepage: </b><a href="home/"><?php echo $homepage; ?></a>
            </div>
        </div>
        <div class="cv__bottom">
            <div class="cv__bottom__boxes">
                <div class="cv__category">Profile</div>
                <div class="cv__content">
                    <?php echo $profil; ?>
                </div>
            </div>
            <div class="cv__bottom__boxes">
                <div class="cv__category">Education</div>
                <div class="cv__content">
                    <?php echo $education; ?>
                </div>
            </div>
            <div class="cv__bottom__boxes">
                <div class="cv__category">Technical</div>
                <div class="cv__content">
                    <?php echo $technical; ?>
                </div>
            </div>
            <div class="cv__bottom__boxes">
                <div class="cv__category">Experience</div>
                <div class="cv__content">
                    <?php echo $work_experience; ?>
                </div>
            </div>
            <div class="cv__bottom__boxes">
                <div class="cv__category">Courses</div>
                <div class="cv__content">
                    <?php echo $course; ?>
                </div>
            </div>
            <div class="cv__bottom__boxes">
                <div class="cv__category">Certificates</div>
                <div class="cv__content">
                    <?php echo $certificates; ?>
                </div>
            </div>
            <div class="cv__bottom__boxes">
                <div class="cv__category">Interests</div>
                <div class="cv__content">
                    <?php echo $interests; ?>
                </div>
            </div>
            <h6>Last updated: <?php echo $date; ?> by <?php echo ucfirst($user); ?></h6>
        </div>
    </div>
</section>
<!-- SECTION END START -->