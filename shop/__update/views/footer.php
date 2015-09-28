<?php if(defined('UNAUTHORIZED')) { ?>

<?php if($CBA_LANG == 'en') { ?>
<h1>Access denied</h1>

<p>You are not authorized to access this page.</p>

<?php } else { ?>
<h1>Hozz�f�r�s megtagadva</h1>

<p>Ennek az oldalnak a megtekint�s�hez �nnek nincs hozz�f�r�si joga, vagy nincs bejelentkezve.</p>

<?php } ?>

<div style="height:400px;">&nbsp;</div>

<?php } ?>

</div>

</div>
<?php if(($CBA_SECTION=="index") && ($CBA_LANG=="hu")) { ?>

<div class="box" id="box1">
  <h2>Akci�</h2>

  <img alt="Mi nem emelt�nk" src="img/content/2009_szeptember.jpg" />
  <p><strong>Mi nem emelt�nk!</strong></p>
  
  <p><a href="akciok.php">r�szletek &raquo;</a></p>
</div>


<div class="box" id="box2">
  <h2>�j �tlap</h2>

  <img alt="T�ltsd fel" src="img/content/2009_fitt_bar.jpg" />
  <p><strong>Meg�j�lt Fitt B�runk!</strong></p>

  <p><a href="fittbar.php">r�szletek &raquo;</a></p>
</div> 


<div class="box" id="box3">
  <h2>Netes fizet�s</h2>

  <img alt="Internetes fizet�s" src="img/content/netes_fizetes.jpg" />
  
  <p><strong>Felejtsd el a sorban �ll�st!</strong></p>
   <p>V�s�rolj otthonr�l,<br />5% kedvezm�nnyel!</p>
  
  <p><a href="online.php">r�szletek &raquo;</a></p> 
</div>

<?php if(false) { ?>
<div class="box" id="box3">
  <h2>K�pgal�ria</h2>

  <img alt="CBA Fitness" src="img/content/cba_fitness.jpg" />
  
  <p><strong>Tekintse meg</strong></p>
  
   <p>a CBA Fitness &amp; Wellness Line-t.</p>
  
  <p><a href="galeria.php">m�g t�bb k�p &raquo;</a></p>
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
  <p style="padding-bottom: 6px; font-size:9px;"><?php if($CBA_LANG == 'en') { ?>CBA Fitness and Wellness Center, Budapest Gy�mr�i Street 99.<?php } else { ?>CBA Fitness �s Wellnessk�zpont, Budapest 10. ker�let, Gy�mr�i �t 99.<?php } ?></p>
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
