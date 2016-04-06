<?php
/*
Template Name: Passback Template
*/
?>
<!DOCTYPE html>
<body>
  <script type="text/javascript">
    var passback = undefined;
    var match = new RegExp('[?&]pb=([^&]*)').exec(window.location.search);
    if(match) {
      passback = match[1];
    } else if(location.hash.length >= 2) {
      passback = location.hash.substring(1);
    }
    var _iframe = window;
    while(_iframe.parent != top) {
      _iframe = _iframe.parent;
    }
    if(passback) {
      var name = _iframe.name;
      var passback = decodeURIComponent(passback);
      try {
        top.window.DFPGPTPassback.passback(name, passback);
      } catch(e) {}
    }
  </script>
</body>

