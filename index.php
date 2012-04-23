<?php
print'<div id="core_defines" style="text-align:center;background:#777;padding:5px;border:2px solid #333;z-index:100;">
      <span style="font-family:monospace;color:#eee;padding:5px;">Welcome to the core of CHROSH Engine, bellow you can see all definitions of core.</span>
      <button type="button" id="debug_core_hide" href="javascript:;" style="margin-left:46%;display:block" onClick="
        document.getElementById(\'debug_core_code\').style.display=\'none\';
        document.getElementById(\'debug_core_hide\').style.display=\'none\';
        document.getElementById(\'debug_core_show\').style.display=\'block\';" >Hide</button>
      <button type="button" id="debug_core_show" href="javascript:;" style="margin-left:46%;display:none" onClick="
        document.getElementById(\'debug_core_code\').style.display=\'block\';
        document.getElementById(\'debug_core_hide\').style.display=\'block\';
        document.getElementById(\'debug_core_show\').style.display=\'none\';" >Show</button>            
    <pre id="debug_core_code">';
include_once 'core_config.php';
pr($_SERVER );
pr('<b> __CORE_DIR__: </b> '        . __CORE_DIR__ );
pr('<b> __LIB_DIR__: </b> '         . __LIB_DIR__ );
pr('<b> __CONTROLLERS_DIR__: </b> ' . __CONTROLLERS_DIR__ );
pr('<b> __DNS__: </b> '             . __DNS__ );
pr('<b> __HERE__: </b> '            . __HERE__ );
pr('<b> __PATH__: </b> '            . __PATH__ );
pr('<b> __VIEW_EXT__: </b> '        . __VIEW_EXT__ );
pr('<b> __REWRITE_EXT__: </b> '     . __REWRITE_EXT__ );
pr('<b> __TPL_EXT__: </b> '         . __TPL_EXT__ );
pr('<b> __MONGO_SERVER__: </b> '    . __MONGO_SERVER__ );
pr('<b> __LOGGING__: </b> '         . __LOGGING__ );
pr('<b> __DEBUG__: </b> '           . __DEBUG__ );
pr('<b> __SESSION_NAME__: </b> '    . __SESSION_NAME__ );
pr('<b> __SESSION_TIMEOUT__: </b> ' . __SESSION_TIMEOUT__ );
pr('<b> __LOCALE__: </b> '          . __LOCALE__ );
pr('<b> __TIMEZONE_LOCAL__: </b> '  . __TIMEZONE_LOCAL__ );
pr('<b> __TIMEZONE_TIME__: </b> '   . __TIMEZONE_TIME__ );
print'</div>';
?>