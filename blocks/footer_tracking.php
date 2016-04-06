<!-- Comscore -->
<script>
	var _comscore = _comscore || [];
	_comscore.push({ c1: "2", c2: "19587797" });
	(function() {
		var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;
		s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
		el.parentNode.insertBefore(s, el);
	})();
</script>
<noscript><img src="http://b.scorecardresearch.com/p?c1=2&c2=19587797&cv=2.0&cj=1" /></noscript>

<!-- Quantcast -->
<script type="text/javascript">
	var _qevents = _qevents || [];
	(function() {
	var elem = document.createElement('script');
	elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
	elem.async = true;
	elem.type = "text/javascript";
	var scpt = document.getElementsByTagName('script')[0];
	scpt.parentNode.insertBefore(elem, scpt);
	})();
	_qevents.push({
	qacct:"p-sRxQ0qKU4hQu4"
	});
</script>
<noscript><div style="display:none;"><img src="//pixel.quantserve.com/pixel/p-sRxQ0qKU4hQu4.gif" border="0" height="1" width="1" alt="Quantcast"/></div></noscript>

<!-- audience360 -->
<script>
   (function() {
       var d=document,h=d.getElementsByTagName('head')[0],s=d.createElement('script'),sc = 'https:' == document.location.protocol ? 'https://' : 'http://';
   s.type='text/javascript';
   s.async=true;
   s.src=sc+'s.dpmsrv.com/dpm_dc685e2c3fd7a3a63944383a54aa249ea27f5fdd.min.js';
   h.appendChild(s);
   })();
</script>

<!-- Sitescout -->
<?php $url = $_SERVER['REQUEST_URI']; if (is_front_page()) { ?>
<script type="text/javascript">var ssaUrl = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'pixel.sitescout.com/iap/5220dc176177712a';new Image().src = ssaUrl;</script>
<?php } elseif (strpos($url,'news/')) { ?>
<script type="text/javascript">var ssaUrl = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'pixel.sitescout.com/iap/b3f709fd42bfae60';new Image().src = ssaUrl;</script>
<?php } elseif (strpos($url,'playlists/')) { ?>
<script type="text/javascript">var ssaUrl = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'pixel.sitescout.com/iap/2139cc0600486434';new Image().src = ssaUrl;</script>
<?php } elseif (strpos($url,'whats-worth-watching/')) { ?>
<script type="text/javascript">var ssaUrl = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'pixel.sitescout.com/iap/86e21956a5649a01';new Image().src = ssaUrl;</script>
<?php } elseif (strpos($url,'newsletter')) { ?>
<script type="text/javascript">var ssaUrl = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'pixel.sitescout.com/iap/29f2d93249a829a0';new Image().src = ssaUrl;</script>
<?php } else { ?>
<?php } ?> 

<!-- Chartbeat -->
<script type='text/javascript'>
    var _sf_async_config={};
    /** CONFIGURATION START **/
    _sf_async_config.uid = 62629;
    _sf_async_config.domain = 'tvinsider.com';
    _sf_async_config.useCanonical = true;
    //_sf_async_config.sections = 'Change this to your Section name';  //CHANGE THIS
    _sf_async_config.authors = '<?php echo $this_author; ?>';    //CHANGE THIS
    /** CONFIGURATION END **/
    (function(){
      function loadChartbeat() {
        window._sf_endpt=(new Date()).getTime();
        var e = document.createElement('script');
        e.setAttribute('language', 'javascript');
        e.setAttribute('type', 'text/javascript');
        e.setAttribute('src', '//static.chartbeat.com/js/chartbeat.js');
        document.body.appendChild(e);
      }
      var oldonload = window.onload;
      window.onload = (typeof window.onload != 'function') ?
         loadChartbeat : function() { oldonload(); loadChartbeat(); };
    })();
</script>
