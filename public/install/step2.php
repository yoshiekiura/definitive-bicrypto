<?php
header('Cache-Control: no-cache');

use App\Http\Controllers\Admin\UpdateController;

require '../../vendor/autoload.php';
$api = new UpdateController;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Bicrypto Stage 2 : Installer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.8.2/css/bulma.min.css" crossorigin="anonymous" />
    <style type="text/css">
        body,
        html {
            background: #F4F5F7;
        }
    </style>
</head>

<body>
    <?php
    $update_data = $api->check_update();
    ?>
    <div class="container" style="padding-top: 20px;">
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-two-fifths">
                    <center>
                        <h1 class="title" style="padding-top: 20px;">Bicrypto Stage 2 <br /> Installer</h1><br>
                    </center>
                    </center>
                    <div class="box">
                        <div class='content'>
                            <?php if ($update_data['status']) { ?>
                                <p>Installation of All Updates might take some time!</p><?php
                                                                                        $update_id = null;
                                                                                        $has_sql = null;
                                                                                        $version = null;
                                                                                        if (!empty($_POST['update_id'])) {
                                                                                            $update_id = strip_tags(trim($_POST["update_id"]));
                                                                                            $has_sql = strip_tags(trim($_POST["has_sql"]));
                                                                                            $version = strip_tags(trim($_POST["version"]));
                                                                                            echo '<progress id="prog" value="0" max="100.0" class="progress is-success" style="margin-bottom: 10px;"></progress>';
                                                                                            // Once we have the update_id we can use LBAPI's download_update() function for downloading and installing the update.
                                                                                            $api->download_update(
                                                                                                $_POST['update_id'],
                                                                                                $_POST['has_sql'],
                                                                                                $_POST['version'],
                                                                                                null, // Pass license code if you don't want to use the local .lic file
                                                                                                null, // Pass client name if you don't want to use the local .lic file
                                                                                                array(
                                                                                                    'db_host' => getenv('DB_HOST'), // Pass your database hostname for update sql import
                                                                                                    'db_user' => getenv('DB_USERNAME'), // Pass your database username for update sql import
                                                                                                    'db_pass' => getenv('DB_PASSWORD'), // Pass your database password for update sql import
                                                                                                    'db_name' => getenv('DB_DATABASE') // Pass your database name for update sql import
                                                                                                )
                                                                                            );
                                                                                        } else { ?>
                                    <form action="step2.php" method="POST">
                                        <input type="hidden" class="form-control" value="<?php echo $update_data['update_id']; ?>" name="update_id">
                                        <input type="hidden" class="form-control" value="<?php echo $update_data['has_sql']; ?>" name="has_sql">
                                        <input type="hidden" class="form-control" value="<?php echo $update_data['version']; ?>" name="version">
                                        <center>
                                            <button type="submit" class="button is-warning is-rounded">Download & Install Bicrypto</button>
                                        </center>
                                    </form>
                                <?php }
                                                                                    } else { ?>
                                <center>
                                    <div style="margin-bottom:10px">this step is completed, if you seen error that sql is not imported then go to your public_html where you have the file and you will find the sql file, download them then import them in your PhpMyAdmin.</div>
                                    <a href="https://mashdiv.gitbook.io/bicrypto/guides/"><button class="button is-link is-rounded">Go To Deployment Stage</button></a>
                                </center>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if ($update_data['status']) { ?>
                        <center>
                            <a href="./step2.php"><button class="button is-link is-rounded">Keep Going Until Download Is Gone</button></a>
                        </center>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="content has-text-centered">
        <p>Copyright <?php echo date('Y'); ?> Mashdiv, All rights reserved.</p><br>
    </div>
</body>

</html>
