<?php if(defined('UNAUTHORIZED')) { ?>

<?php if($CBA_LANG == 'en') { ?>
<h1>Access denied</h1>

<p>You are not authorized to access this page.</p>

<?php } else { ?>
<h1>Hozzáférés megtagadva</h1>

<p>Ennek az oldalnak a megtekintéséhez Önnek nincs hozzáférési joga, vagy nincs bejelentkezve.</p>

<?php } ?>

<div style="height:400px;">&nbsp;</div>

<?php } ?>

</div>

</div>
<?php if(($CBA_SECTION=="index") && ($CBA_LANG=="hu")) { ?>

<div class="box" id="box1">
  <h2>Akció</h2>

  <img alt="Mi nem emeltünk" src="img/content/2009_szeptember.jpg" />
  <p><strong>Mi nem emeltünk!</strong></p>
  
  <p><a href="akciok.php">részletek &raquo;</a></p>
</div>


<div class="box" id="box2">
  <h2>Új étlap</h2>

  <img alt="Töltsd fel" src="img/content/2009_fitt_bar.jpg" />
  <p><strong>Megújúlt Fitt Bárunk!</strong></p>

  <p><a href="fittbar.php">részletek &raquo;</a></p>
</div> 


<div class="box" id="box3">
  <h2>Netes fizetés</h2>

  <img alt="Internetes fizetés" src="img/content/netes_fizetes.jpg" />
  
  <p><strong>Felejtsd el a sorban állást!</strong></p>
   <p>Vásárolj otthonról,<br />5% kedvezménnyel!</p>
  
  <p><a href="online.php">részletek &raquo;</a></p> 
</div>

<?php if(false) { ?>
<div class="box" id="box3">
  <h2>Képgaléria</h2>

  <img alt="CBA Fitness" src="img/content/cba_fitness.jpg" />
  
  <p><strong>Tekintse meg</strong></p>
  
   <p>a CBA Fitness &amp; Wellness Line-t.</p>
  
  <p><a href="galeria.php">még több kép &raquo;</a></p>
</div>
<?php } ?>
<?php } ?>

<div id="sponsors">
  <ul>
    <li><span>Gatorade</span><img alt="Powerade" src="img/Powerade.jpg" /></li>
    <li><span>Rexona</span><img alt="Rexona" src="img/Rexona.jpg" /></li>
    <li><span>Nadine Sport</span><img alt="Nadine Sport" src="img/nadine.jpg" /></li>
    <li><span>Harmony</span><img alt="Harmony" src="img/harmony.jpg" /></li>

  </ul>
  <p style="padding-bottom: 6px; font-size:9px;"><?php if($CBA_LANG == 'en') { ?>CBA Fitness and Wellness Center, Budapest Gyömrõi Street 99.<?php } else { ?>CBA Fitness és Wellnessközpont, Budapest 10. kerület, Gyömrõi út 99.<?php } ?></p>
</div>

<div id="footer">
  <a href="http://www.anaiz.hu" target="_blank"><span>Webdesign</span><img alt="webdesign: anaiz" src="img/webdesign.jpg" /></a>
</div>

<?php if(!defined('BW_NOSTAT')) { ?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2721418-3";
urchinTracker();
</script>
<?php } ?>
</body>
</html>
