<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Other meta tags and stylesheets -->
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GFI CMS</title>
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="stylehome.css" />
    <script src="functionhome.js"></script>

    <style>
      .navbar {
        box-shadow: 0 4px 8px rgba(5, 5, 5, 5);
        position: sticky;
        top: 0;
        z-index: 999;
        transition: background-color 0.3s ease;
        height: 100px;
        font-size: 20px;
        font-family: 'Times New Roman', Times, serif;
        padding: 0 25px 0 25px;
      }

      .navbar.transparent {
        background-color: transparent;
      }

      .carousel {
        margin-top: -25px;
      }

      .fade-carousel .slides .slide-1 {
        background-image: url(burger.jpg);
      }
      .fade-carousel .slides .slide-2 {
        background-image: url(sisig.jpg);
      }
      .fade-carousel .slides .slide-3 {
        background-image: url(wings.jpg);
      }

      .content-container {
        background: #f5f5dc;
        background-image: url("https://www.transparenttextures.com/patterns/black-paper.png");
      }

      .footer {
        background-color: #111111;
        color: #ffffff;
        padding: 50px 0;
      }

      .footer h4 {
        color: #ffffff;
        font-weight: bold;
      }

      /* Custom modal size and padding */
      .modal-content {
        max-height: 600px;
        overflow-y: auto;
      }

      /* Additional styles for the modal */
      .modal-header, .modal-body {
        padding: 20px;
      }

      /* Mobile Styles */
      @media (max-width: 767px) {
        .carousel {
          width: 100%;
        }
      }
    </style>
  </head>
  <body>
    <div class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="navbar-header">
              <button class="navbar-toggle" data-target="#mobile_menu" data-toggle="collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a href="#" class="navbar-brand">
                <img class="brand-logo" src="PICTURE/clinic_picture.png" height="80px" alt="GFI LOGO" />
              </a>
              <h5>Gensantos Foundation College</h5>
            </div>

            <div class="navbar-collapse collapse" id="mobile_menu">
              <ul class="nav navbar-nav navbar-right">
                <li>
                  <a href="#" id="login-signup-btn" class="login-link">
                    <span class="glyphicon glyphicon-log-in"></span> Login
                    <span class="caret"></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="modal fade" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="loginModalLabel">Login</h4>
          </div>
          <div class="modal-body">
            <!-- Tab navigation for Student / Staff Login -->
            <ul class="nav nav-pills">
              <li class="active"><a href="#student-login" data-toggle="pill">Student Login</a></li>
              <li><a href="#staff-login" data-toggle="pill">Staff Login</a></li>
            </ul>
            <div class="tab-content">
              <!-- Student Login Tab -->
              <div id="student-login" class="tab-pane fade in active">
                <form action="student_login_process.php" method="POST">
                  <div class="form-group">
                    <label for="student-username">Username</label>
                    <input type="text" class="form-control" id="student-username" name="username" placeholder="Enter your username">
                  </div>
                  <div class="form-group">
                    <label for="student-password">Password</label>
                    <input type="password" class="form-control" name="password" id="student-password" placeholder="Enter your password">
                  </div>
                  <button type="submit" class="btn btn-success">Login</button>
                  <a href="registration.php" class="btn btn-primary">Register</a>
                </form>
              </div>
              <!-- Staff Login Tab -->
              <div id="staff-login" class="tab-pane fade">
                <form action="staff_login.process.php" method="POST">
                  <div class="form-group">
                    <label for="staff-username">Username</label>
                    <input type="text" class="form-control" id="staff-username" name="username" placeholder="Enter your username">
                  </div>
                  <div class="form-group">
                    <label for="staff-password">Password</label>
                    <input type="password" class="form-control" name="password" id="staff-password" placeholder="Enter your password">
                  </div>
                  <button type="submit" class="btn btn-success">Login</button>
                  <a href="staff_registration.php" class="btn btn-primary">Register</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <div
      class="carousel fade-carousel slide"
      data-ride="carousel"
      data-interval="4000"
      id="bs-carousel"
    >
      <!-- Overlay -->

      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#bs-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#bs-carousel" data-slide-to="1"></li>
        <li data-target="#bs-carousel" data-slide-to="2"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner">
    <div class="item slides active">
        <div class="slide-1">
            <div class="overlay"></div>
        </div>
        <div class="hero">
            <hgroup>
                <h1>Comprehensive School Clinic Services</h1>
                <h3>
                    Providing quality healthcare and support for our students' well-being.
                </h3>
            </hgroup>
            <button class="btn btn-hero btn-lg" role="button">
                Register as a Student
            </button>
        </div>
    </div>
    <div class="item slides">
        <div class="slide-2">
            <div class="overlay"></div>
        </div>
        <div class="hero">
            <hgroup>
                <h1>Personalized Student Health Care</h1>
                <h3>
                    Focused on delivering the best health services tailored to each student's needs.
                </h3>
            </hgroup>
        </div>
    </div>
    <div class="item slides">
        <div class="slide-3">
            <div class="overlay"></div>
        </div>
        <div class="hero">
            <hgroup>
                <h1>Supporting Student Health and Wellness</h1>
                <h3>
                    Ensuring a healthy learning environment for all students through dedicated care.
                </h3>
            </hgroup>
        </div>
    </div>
</div>

    </div>


    <div class="background"></div>
  


<div class="content-container">
  <div class="woolf"></div> 
	<div class="content">

		<hr>
    <h3 class="slog">Ensuring Student Health and Wellness</h3>

<p class="laman">
    <span>W</span>elcome to our School Clinic Management System, where the health and well-being of our students are our top priorities.
</p>

<p class="laman">
    Our system is designed to provide comprehensive healthcare services, manage student medical records, and offer timely medical assistance, ensuring that every student receives the care they need.
</p>

<p class="laman">
    We believe in fostering a supportive and healthy environment for all students, making their well-being our mission.
</p>

<p class="laman">
    Thank you for trusting our clinic to be a part of your educational journey, where student health and academic success go hand in hand.
</p>
	</div>
</div>
</div>




    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-md-4">
            <div class="contact-info">
              <h4>GFI - CMS</h4>
              <p>#</p>
            </div>
          </div>
          <div class="col-sm-6 col-md-4">
            <h4>Opening Hours</h4>
            <ul class="opening-hours">
              <li>Monday - Sunday: 24 Hours</li>
            </ul>
          </div>
          <div class="col-sm-6 col-md-4">
            <h4>Follow Us</h4>
            <div class="social-media-icons">
              <a href="#" class="social-media-icon"><i class="fab fa-facebook-f"></i></a>
              <a href="#" class="social-media-icon"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="container text-center">
        <div class="row">
          <div class="col-xs-12">
            <p class="privacy-links">
              <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
            </p>
            <p>&copy; 2024 <span class="eatside-resto">CMS</span>. All rights reserved.</p>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script>
      $(document).ready(function() {
        // When the "Login" button is clicked, show the modal
        $('#login-signup-btn').click(function() {
          $('#loginModal').modal('show');
        });
      });
    </script>
  </body>
</html>
