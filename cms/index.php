<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">

        <title>Rajohan.no - CMS</title>
    </head>
    <body class="wrapper">
      <nav class="nav_top">
        <div class="nav_top__left">
        Rajohan.no &#8212; Content management system
        </div>
        <div class="nav_top__right">
          <ul>
            <li class="nav_top__link">
              <span class="drop">
              Rajohan
              </span>
              <ul class="hide">
                <li class="nav_top__link--drop">
                  <a href="#">
                    <img src="img/icons/new_post.svg" class="nav_top__img">
                    Messages
                  </a>
                </li>
                <li class="nav_top__link--drop">
                  <a href="#">
                    <img src="img/icons/new_post.svg" class="nav_top__img">
                    Notifications
                  </a>
                </li>
                <li class="nav_top__link--drop">
                  <a href="#">
                    <img src="img/icons/new_post.svg" class="nav_top__img">
                    Profile
                  </a>
                </li>
                <li class="nav_top__link--drop">
                  <a href="#">
                    <img src="img/icons/view_all.svg" class="nav_top__img">
                    Logout
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
      <div class="wrapper_mid">
        <nav class="nav_left">
          <ul>
            <li class="nav_left__link">
              <a href="#">
                <img src="img/icons/dashboard.svg" class="nav_left__img">
                Dashboard
              </a>
            </li>
            <li class="nav_left__link">
              <span class="drop">
                <img src="img/icons/news.svg" class="nav_left__img">
                Posts
                <img src="img/icons/drop_down.svg" class="nav_left__img">
              </span>
              <ul class="hide">
                <li class="nav_left__link--drop">
                  <a href="#">
                    <img src="img/icons/new_post.svg" class="nav_left__img">
                    Add post
                  </a>
                </li>
                <li class="nav_left__link--drop">
                  <a href="#">
                    <img src="img/icons/view_all.svg" class="nav_left__img">
                    View all posts
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav_left__link">
              <a href="#">
                <img src="img/icons/categories.svg" class="nav_left__img">
                Categories
              </a>
            </li>
            <li class="nav_left__link">
              <a href="#">
                <img src="img/icons/comments.svg" class="nav_left__img">
                Comments
              </a>
            </li>
            <li class="nav_left__link">
              <span class="drop">
                <img src="img/icons/users.svg" class="nav_left__img">
                Users
                <img src="img/icons/drop_down.svg" class="nav_left__img">
              </span>
              <ul class="hide">
                <li class="nav_left__link--drop">
                  <a href="#">
                    <img src="img/icons/add_user.svg" class="nav_left__img">
                    Add user
                  </a>
                </li>
                <li class="nav_left__link--drop">
                  <a href="#">
                    <img src="img/icons/view_users.svg" class="nav_left__img">
                    View all users
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav_left__link">
              <a href="#">
                <img src="img/icons/user.svg" class="nav_left__img">
                Profile
              </a>
            </li>
          </ul>
        </nav>
        <div class="content">
          content
        </div>
      </div>
      <div class="footer">
        Copyright &copy; 2017-<?php echo date('Y'); ?> <a href="https://rajohan.no" class="whitelink">Rajohan.no</a>, <a href="https://w2.brreg.no/enhet/sok/detalj.jsp?orgnr=998619335" class="whitelink">Raymond Johannessen Webutvikling</a>.
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script>
      $('.drop').on("click", function() {
          $(this).siblings('ul').toggle();
      });
      </script>
    </body>
  </head>
</html>
