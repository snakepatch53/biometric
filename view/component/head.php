<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if($informacion_r['informacion_icon'] != null and $informacion_r['informacion_icon'] != "") { ?>
    <link rel="icon" href="<?= $proyect['root'] ?>view/file/informacion_icon/<?= $informacion_r['informacion_icon'] ?>?date=<?= $dateTime ?>">
<?php } else { ?>
    <link rel="icon" href="<?= $proyect['root'] ?>view/img/logo.png">
<?php } ?>
<link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/config.css">
<link rel="stylesheet" href="<?= $proyect['root'] ?>view/library/fontawesome/css/all.min.css">
<link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/panel.css">