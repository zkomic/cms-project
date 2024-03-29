<?php include "includes/admin_header.php" ?>

<?php

if (!isAdmin($_SESSION['username'])) {

    redirect("profile.php");
}

?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">

                        <?php echo $_SESSION['firstname'] ?>
                        <br>
                        <small>
                            Welcome to Admin
                        </small>
                    </h1>
                </div>
            </div>
            <!-- /.row -->


            <!-- dashboard -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                    <?php

                                    $posts_count = recordCount('posts');

                                    $posts_draft_count = recordSpecificCount('posts', 'post_status', 'draft');
                                    $posts_active_count = $posts_count - $posts_draft_count;

                                    ?>

                                    <div class='huge'><?php echo $posts_count; ?></div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                    <?php

                                    $comments_count = recordCount('comments');

                                    $comments_approved_count = recordSpecificCount('comments', 'comment_status', 'approved');
                                    $comments_unapproved_count = $comments_count - $comments_approved_count;

                                    ?>

                                    <div class='huge'><?php echo $comments_count; ?></div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                    <?php

                                    $users_count = recordCount('users');

                                    $users_admin_count = recordSpecificCount('users', 'user_role', 'admin');
                                    $users_subs_count = $users_count - $users_admin_count;

                                    ?>

                                    <div class='huge'><?php echo $users_count; ?></div>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                    <?php

                                    $category_count = recordCount('categories');

                                    ?>

                                    <div class='huge'><?php echo $category_count; ?></div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <br>
            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart1);

                    function drawChart1() {
                        var postsCount = <?php echo $posts_count; ?>;
                        var postsActiveCount = <?php echo $posts_active_count; ?>;
                        var postsDraftCount = <?php echo $posts_draft_count; ?>;

                        var data1 = google.visualization.arrayToDataTable([
                            ['', 'All Posts', 'Published', 'Not Published'],
                            ['Posts', postsCount, postsActiveCount, postsDraftCount],
                        ]);

                        var options1 = {
                            chart: {
                                title: '',
                                subtitle: '',
                            },
                        };

                        var chart1 = new google.charts.Bar(document.getElementById('chart1'));

                        chart1.draw(data1, google.charts.Bar.convertOptions(options1));
                    }
                </script>
            </div>
            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart2);

                    function drawChart2() {
                        var commentsCount = <?php echo $comments_count; ?>;
                        var commentsActiveCount = <?php echo $comments_approved_count; ?>;
                        var commentsDraftCount = <?php echo $comments_unapproved_count; ?>;

                        var data2 = google.visualization.arrayToDataTable([
                            ['', 'All Comments', 'Approved', 'Unapproved'],
                            ['Comments', commentsCount, commentsActiveCount, commentsDraftCount],
                        ]);

                        var options2 = {
                            chart: {
                                title: '',
                                subtitle: '',
                            },
                        };

                        var chart2 = new google.charts.Bar(document.getElementById('chart2'));

                        chart2.draw(data2, google.charts.Bar.convertOptions(options2));
                    }
                </script>
            </div>
            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart3);

                    function drawChart3() {
                        var usersCount = <?php echo $users_count; ?>;
                        var usersAdminCount = <?php echo $users_admin_count; ?>;
                        var usersSubsCount = <?php echo $users_subs_count; ?>;

                        var data3 = google.visualization.arrayToDataTable([
                            ['', 'All Users', 'Admins', 'Subscribers'],
                            ['Users', usersCount, usersAdminCount, usersSubsCount],
                        ]);

                        var options3 = {
                            chart: {
                                title: '',
                                subtitle: ''
                            },
                        };

                        var chart3 = new google.charts.Bar(document.getElementById('chart3'));

                        chart3.draw(data3, google.charts.Bar.convertOptions(options3));
                    }
                </script>
                <div id="chart1" style="width: 33%; height: 500px; display: inline-block;"></div>
                <div id="chart2" style="width: 33%; height: 500px; display: inline-block;"></div>
                <div id="chart3" style="width: 33%; height: 500px; display: inline-block;"></div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>