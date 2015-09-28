<!doctype html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <table>
<?php
require_once 'inc/bwSettings.php';
require_once 'inc/bwComponent.php';
require_once 'inc/bwDatabase.php';
require_once 'inc/bwDataset.php';
require_once 'inc/bwRemoteServices2.php';

$cikkek = $remote->getCikklista();
foreach ($cikkek as $cikk):
?>
            <tr>
                <td><?php echo $cikk['id'] ?></td>
                <td><?php echo $cikk['nev'] ?></td>
                <td><?php echo $cikk['bruttoar'] ?></td>
            </tr>
<?php endforeach; ?>
        </table>
    </body>
</html>

