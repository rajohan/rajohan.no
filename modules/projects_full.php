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
    $pagination = new Pagination;
    $converter = new Converter;
    
    //-------------------------------------------------
    //  Set offset value 
    //-------------------------------------------------

    $offset = ($pagination->valid_page_number($pagination->get_page_number(), "BLOG") - 1) * 1; // Set the page number to generate offset (* + number of items per site)

    //-------------------------------------------------
    //  Get the projects
    //-------------------------------------------------

    $stmt = $db_conn->connect->prepare("SELECT NAME, CATEGORY, DESCRIPTION, IMAGE, URL, SKILLS, CREATED_DATE, CLIENT FROM `PROJECTS` ORDER BY `ID` DESC LIMIT $offset, 1");
    $stmt->execute();
    $result = $stmt->get_result();

?>

<!-- SECTION PROJECTS FULL START -->
<section class="projects-full u-margin-bottom-medium">
    <h1 class="heading-secondary heading-secondary letter-spacing-medium u-margin-top-medium">Projects</h1>
    <h1 class="heading-tertiary letter-spacing-small">All my projects</h1>
    <div class="projects-full__box u-margin-top-medium">
        <?php 

            while ($row = $result->fetch_assoc()) {

                $name = $filter->sanitize($row['NAME']);
                $category = $filter->sanitize($row['CATEGORY']);
                $description = $filter->sanitize($row['DESCRIPTION']);
                $img = $filter->sanitize($row['IMAGE']);
                $url = $filter->sanitize($row['URL']);
                $skills = $filter->sanitize($row['SKILLS']);
                $date = $filter->sanitize($row['CREATED_DATE']);
                $client = $filter->sanitize($row['CLIENT']);

                $date = $converter->date($date);

                echo '<div class="projects-full__item">
                        <div class="projects-full__item--left">
                            <img src="img/projects/'.$img.'" alt="'.$name.'" class="projects-full__img">
                        </div>
                        <div class="projects-full__item--right">
                            <h3 class="projects-full__title">'.ucfirst($category).' &ndash; '.ucfirst($name).'</h3>
                            <div class="projects-full__info"><span class="u-bold-text">Date:</span> '.$date.'<br> <span class="u-bold-text">Client:</span> '.ucfirst($client).'<br> <span class="u-bold-text">Skills:</span> '.ucfirst($skills).'</div>
                            <div class="projects-full__description">'.$description.'</div>
                            <span class="u-margin-top-small">
                                <a href="'.$url.'" target="_blank" class="projects-full__view">View project <span>&roarr;</span></a>
                            </span>
                        </div>
                    </div>';

            }

            $db_conn->free_close($result, $stmt);

            //-------------------------------------------------
            // Pagination
            //-------------------------------------------------

            echo '<div class="pagination u-margin-top-medium u-margin-bottom-medium">';
            $pagination->output_pagination(1, "BLOG"); // Output the pagination
            echo '</div>';
        ?>
    </div>
</section>
<!-- SECTION PROJECTS FULL START -->