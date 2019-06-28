<!DOCTYPE html>
<html>
    <head>
        <title><?= $title ?></title>

        <!-- Google Charts -->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    

        <?php require('templates/admin/statsCharts.php'); ?>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
        
    <body>
        <!-- Back to top button anchor -->
        <div id="header"></div>

        <?php
        //display the right menu depending on the user role
        if (isset($checkUserRole['groupId']) && $checkUserRole['groupId'] == 1) {
            require('admin/menuAdmin.php');
        } else {
            require('front/menu.php');
        }
        ?>
            <?= $content ?>

            <!-- Footer -->
            <footer id="footer">
                <div class="container">
                    <!-- Grid row-->
                    <div class="row text-center d-flex justify-content-center">
                        <div class="col-md-12 ">
                            <h5 class="text-uppercase font-weight-bold">
                                <a href="index.php?action=about">A propos</a> &emsp; 
                                <a data-toggle="modal" data-target="#contactModal">Contact</a> &emsp;
                                <a href="index.php?action=legalNotice">Mentions légales</a>
                            </h5>
                        </div>                    
                    </div> 
                </div>
                <!-- Back to top -->
                <a href="#header" onclick="$('html,body').animate({scrollTop:0},'slow');return false;"><i class="fas fa-arrow-circle-up"></i></a>
                <!-- Copyright -->
                <div class="footer-copyright text-center py-3">
                    <span>&copy;<script>document.write(new Date().getFullYear());</script> Alexis Gautier | Template en partie réalisé par <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </span>
                </div>    
            </footer>

        <?php require('templates/front/contactView.php'); ?>

        <!-- My scripts -->
        <script src="./public/js/main.min.js"></script>

    </body>
</html>