<?php 

session_start();
header("Content-Type: text/xml");

$jobId = $_GET['foo'];

$GOAL = 10000;
$STEP = 10;
$BUFFER = 1000;
$PERIOD = 1 * 60 * 60;

if (!isset($_SESSION['job']) || ($jobId != $_SESSION['job'])) {
    $_SESSION['job'] = $jobId;
    $_SESSION['remaining'] = $GOAL;
    $_SESSION['buffer-available'] = $BUFFER;
    $_SESSION['buffer-reset-time'] = time() + $PERIOD;
}

$remaining = $_SESSION['remaining'];
$available = $_SESSION['buffer-available'];
$bufferResetTime = $_SESSION['buffer-reset-time'];
$step = $STEP;

$now = time();

if ($remaining > 0) {
    
    if ($bufferResetTime <= $now) {
        $_SESSION['buffer-reset-time'] = $now + $PERIOD;
        $_SESSION['buffer-available'] = $BUFFER;
        $available = $BUFFER;
    }
    
    if ($available > 0) {
        if ($step > $available) {
            $step = $available;
        }
        if ($step > $remaining) {
            $step = $remaining;
        }
        $_SESSION['remaining'] = $remaining - $step;
        $_SESSION['buffer-available'] = $available - $step;
        $code = 1;
        $message = $step . ' jobs done. ' . $_SESSION['remaining'] . ' jobs remaining. Periodic limit remaining: ' . $_SESSION['buffer-available'];
    } else {
        $code = 0;
        $message = 'Periodic limit reached. Try again later.';
    }
} else {
    $code = 2;
    $message = 'ALL DONE!';
}


?>
<response>
    <code><?php echo $code ?></code>
    <message><?php echo $message ?></message>
</response>