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

    $db_conn = new Database;
    $filter = new Filter;
    $bbcode = new Bbcode;
    $converter = new Converter;

    //-------------------------------------------------
    // Get the cv
    //-------------------------------------------------

    $stmt = $db_conn->connect->prepare("SELECT * FROM `CV` ORDER BY `ID` DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {

        $name = $filter->sanitize($row["NAME"]);
        $title = $filter->sanitize($row["TITLE"]);
        $address = $filter->sanitize($row["ADDRESS"]);
        $tlf = $filter->sanitize($row["TLF"]);
        $born = $filter->sanitize($row["BORN"]);
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

    }

    $db_conn->free_close($result, $stmt);

    $age = $converter->age($born);
    $born = $converter->date($born);

?>

<!-- SECTION CV START -->
<section class="cv u-margin-top-small">
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
        </div>
    </div>
</section>
<!-- SECTION CV END -->