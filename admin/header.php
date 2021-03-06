<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Briefing</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel = "icon" href ="../icon.png" type = "image/x-icon">
    <meta http-equiv="refresh" content="300">
</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="manage_briefing.php">Homepage</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbarCollapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="rejected_list.php">Rejected List</a></li>
                    <li>
                        <div class="dropdown" style="margin-top: 10px;">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                Briefing/ De-briefing History
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="history_briefing.php">Briefing History(F-20387)</a></li>
                                <li><a href="history_debrief_visit.php">De-Brief Visit History(F-20388)</a></li>
                                <li><a href="history_debrief_training.php">De-Brief Training History(F-20389)</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="manage_users.php">Manage Users</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"
                           style="text-transform: uppercase;"><?php echo "Welcome : " .'<b>' .$_SESSION['name'] .'</b>'; ?> <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="reset_password_admin.php">Change Password</a></li>
                            <li><a href="?status=logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

