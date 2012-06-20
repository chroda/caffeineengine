<?php
/**
 * The functions in this script were produced as if needed, 
 * can serve many or one projects in particular.
 * 
 * @author Christian Marcell (chroda) <christianmarcell@gmail.com>
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @version 1.3
 * 
 * @TODO Organizar os tipos, dependentes e etc.
 * Padronizar e organizar todos os phpDocs do script.. ELAIA!
 * ......(abrindo o arquivo..7 de abril de 2012..quando será que vou organizar?)
 * 
 * ...20 de junho e ainda nada.. =/
 * 
 */

ob_start();

/**
 * This is a debug function, originaly from CakePHP.
 * @name pr
 * @param $_target - var, you print this
 * @param $_debug - boolean, if true, uses var_dump, if false, uses print_r
 * @param $_jsPlus - boolean, need js plus to hide the printed code?
 * @access public
 * @version 2.5
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @author Christian Marcell (chroda) <christianmarcell@gmail.com>
 * @return mixed
 * @package CaffeineEngine
 * @link http://pastebin.com/SSZe16qx
 */
function pr( $_target, $_debug=false, $_jsPlus=false)
{
  $_hide = 'Esconder DEBUG';
  $_show = 'Mostrar DEBUG';
  $_style = 'style="text-align:justify;font-size:11px;padding:4px;border:1px solid #ddd;background:#fefefe;color:#444;"';
  if ( $_jsPlus === true){
    print '<div '.$_style.'>
      <button type="button" id="debug_hide" href="javascript:;" style="display:block" onClick="
        document.getElementById(\'debug_code\').style.display=\'none\';
        document.getElementById(\'debug_hide\').style.display=\'none\';
        document.getElementById(\'debug_show\').style.display=\'block\';" >'.$_hide.'</button>
      <button type="button" id="debug_show" href="javascript:;" style="display:none" onClick="
        document.getElementById(\'debug_code\').style.display=\'block\';
        document.getElementById(\'debug_hide\').style.display=\'block\';
        document.getElementById(\'debug_show\').style.display=\'none\';" >'.$_show.'</button>            
    <pre id="debug_code">';
      if ( $_debug === true){ var_dump( $_target ); }else{ print_r( $_target ) ;}  
    print '</pre></div>';
  }else{
    print '<pre '.$_style.'>';
      if ( $_debug === true){ var_dump( $_target ); }else{ print_r( $_target ) ;}
    print '</pre>';
  }
}

/**
 * exibe a url aonde foi chamada
 */
function here( $_return = false ){
	$_hereArray = explode( '/', __HERE__ );
  $_lastArray = count( $_hereArray )-1;
  //valid for index
  if ( empty( $_hereArray[$_lastArray] ) ){ $_hereArray[$_lastArray] = 'dashboard'; }
  $_herePath = implode( '/', $_hereArray );
  if ( $_return === true ){ return $_herePath; }
  print $_herePath;
}

/**
 * cria uma senha aleatória
 */
function randomPass( $_length = 6, $_hasUppercases = false, $_hasNumbers = false, $_return = false ){
  $_lowercases = 'abcdefghijklmnopqrstuvwxyz';
  $_uppercases = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $_numbers    = '1234567890';
  
  $acceptedCharecters = $_lowercases;
  if ( $_hasUppercases ) { $acceptedCharecters .= $_uppercases; }
  if ( $_hasNumbers ) { $acceptedCharecters .= $_numbers; }
  
  $length = strlen($acceptedCharecters);
  $pass='';
  for ($i=1;$i<=$_length;$i++){
    $randomization = mt_rand(1, $length);
    $pass .= $acceptedCharecters[$randomization-1];
  }
  if ( $_return == true){
    return $pass; 
  } echo $pass;
}

/**
 * Simple search a pattern in a array os string.
 * @author Christian Marcell (chroda) <christianmarcell@gmail.com>
 * @param $_target - Busca um padrão e armazena em array
 * @return array or string
 * @name searchPattern
 * @link http://pastebin.com/S36rh8DR
 */
function searchPattern( $_pattern, $_target ) {
  !is_array($_target) ? $_target = array($_target) : null;
  return preg_grep($_pattern, $_target );
}

/**
 * tarefa - phpDoc
 * any explain ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param $_link - boolean, ??? 
 * @param $_return - bolean, ???
 * @param $_ext - string, ???
 * @name location
 * @return ????
 */
function location($_link=false, $_return = false, $_ext='none')
{
  $_dns  = __DNS__;
  $_path = __PATH__;

  if($_ext=='none')
  {
    $_ext  = __REWRITE_EXT__;
  } elseif($_ext==false){
    $_ext = '';
  } else {
    $_ext  = $_ext;
  }
  
  if($_link['0']=='/'){
    for($i=1;$i<=strlen($_link);$i++) @$_tmp .= $_link[$i];
    $_link = $_tmp;
  }

  if($_SERVER['SERVER_PORT'] != 80) {
    $_port = ":{$_SERVER['SERVER_PORT']}";
  } else {
    $_port = '';
  }

  $_url  = "http://".str_replace('//','/',"{$_dns}{$_port}{$_path}{$_link}{$_ext}");

  if($_return==false) {
    echo $_url;
  } else {
    return $_url;
  }
}

/**
 * This function has specific use in a project, and need a other function, "location()" to work.
 * @author Christian Marcell (chroda) <christianmarcell@gmail.com>
 * @param $_target - Retorna url externa, ou url interna
 * @return string
 * @name httpQuery
 * @see location($_link=false, $_return = false, $_ext='none')
 * @link http://pastebin.com/ub5V53ZF
 */
function httpQuery( $_target ) {
  $_founded = preg_grep('/http(s)?:\/\//', array($_target) );
  $_founded ? $_return = $_founded[0] : $_return = location( $_target, true );
  return $_return;
}

/**
 * @author Christian Marcell (chroda) <christianmarcell@gmail.com> 
 * @name urlRedirect
 * @return nothing! But, if url its the not desired, redirect to url desired. 
 * @param $_HTTP_HOST Needed $_SERVER['HTTP_HOST'] value to compare with HostName desired.
 * @param $_REQUEST_URI Needed $_SERVER['REQUEST_URI'] value to compare with Request Uri desired.
 * @example set $_HTTP_HOST with mysite.com and set $_REQUEST_URI with /admin/ 
 * and whem you access mysite.com/admin, this function redirect you to admin.mysite.com
 * @link http://pastebin.com/0ghM3FaL
 */
function urlRedirect( $_HTTP_HOST, $_REQUEST_URI ){
  if($_SERVER['HTTP_HOST'] === $_HTTP_HOST && $_SERVER['REQUEST_URI'] === $_REQUEST_URI){
    header('Location: http://'.str_replace('/', '', $_REQUEST_URI).'.'.$_HTTP_HOST);
  }
}

/**
 * This function is originally produced by the Gravatar, 
 * however, was needed more than met, so I created the code below
 * 
 * How Works:
 * Made a tag img, you can choice, made a full tag, for this I checks Gravatar account if the account exists, 
 * gets the name and id and uses the image of the account, 
 * these name and id, turn in img tags -> alt='name' id='id', 
 * if not exists, use the default image and alt, id tags.
 * 
 * @author Gravatar source: http://gravatar.com/site/implement/images/php/
 * @author Christian Marcell <christianmarcell@gmail.com>
 * @name Get Gravatar
 * @version 3.2
 * @param string $_email The email address
 * @param string $_s Size in pixels, defaults to 80px [ 1 - 512 ]
 * @param bolean $_checkAcc If true, check the acc of hash
 * @param string $_d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $_r Maximum rating (inclusive) [ g | pg | r | x ]
 * @return Full img tag with alt and id parameters
 * @link http://pastebin.com/JBL8LDUZ
 */
function getGravatar($_email, $_s = 80, $_checkAcc = false, $_d = 'mm', $_r = 'r' ) {
  $_url = 'http://www.gravatar.com/';
  $_hash = md5( strtolower( trim( $_email ) ) );
  $_parameters ='?s='.$_s.'&amp;d='.$_d.'&amp;r='.$_r;
  $_imgsource = 'class="avatar" src="'.$_url.'avatar/'.$_hash.$_parameters.'"';
  if ($_checkAcc === true) {$_getContents = @file_get_contents($_url.$_hash.'.php'); 
    if ($_getContents) {
      $_gravatar_data = unserialize( $_getContents );
      $_gravatar_id = $_gravatar_data['entry'][0]['id'];
      $_gravatar_name = strtolower(str_replace(' ', '-', @$_gravatar_data['entry'][0]['name']['formatted']));
      echo '<img alt="'.$_gravatar_name.'_gravatar" id="'.$_gravatar_id.'" '.$_imgsource.' />';
    }else{
      $_gravatar_id = '';
      $_gravatar_name = 'no_img';    
      echo '<img alt="'.$_gravatar_name.'_gravatar" id="'.$_gravatar_id.'" '.$_imgsource.'/>';
    }
  }else{echo '<img alt="gravatar_of_'.$_email.'" '.$_imgsource.' />';}
}

/**
 * @author Christian Marcell <christianmarcell@gmail.com>.
 * @name flip Date.
 * @category basic functions.
 * @return date param $_date flipped(in reverse order).
 * @param Date     $_date   A date to flip (change order).
 * @param String   $_de     Delimiter Explode, '-' as default value.
 * @param String   $_di     Delimiter Inplode, '/' as default value.
 * @example fd(date('Y-m-d'));         return the value "d/m/Y".
 * @example fd(date('d/m/Y'),'/','-'); return the value "Y-m-d".
 * @example fd(date('d/m/Y'),'/');     return the value "Y/m/d".
 * @link http://pastebin.com/AENEc1yZ
 */
function flipDate($_date, $_de = '-', $_di = '/') {
  $_date = explode($_de, $_date);
  $_date = array_reverse($_date);
  $_date = implode($_di, $_date);
  return $_date;
}

/**
 * The user in session is admin or not.
 * @author Michel Wilhelm <michelwilhelm@gmail.com> 
 * @return bolean, user in session, is admin or not.
 * @name is_admin
 */
function is_admin() {
  if( isset($_SESSION['user']['admin']) ) {
    return true;
  } else {
    return false;
  }
}

/**
 * A time function for benchmark tests.
 * @author Christian Marcell (chroda) <christianmarcell@gmail.com>
 * @param $startTime - colocar uma var com microtime no começo do script.
 * @param $return - retorna ou imprime?
 * @param $endTime - chamar esta function no final do script.
 * @deprecated - I using another function for this. (But this still working).
 * @return float microtime
 * @name benchmarkTime
 * @link http://pastebin.com/Fb0wHvKC
 */
function benchmarkTime($startTime, $return = false, $endTime = null ) {
  is_null($endTime) ? $endTime = microtime() : null;
  $result = $endTime - (float)$startTime;
  if ( $return === TRUE )
    return $result;
  print($result);
}

/**
 * tarefa - phpDOC
 * how works ????
 * BENCHMARK
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param $_what - ????
 */
function StartTimer ($_what='') {
  global $_MYTIMER; $_MYTIMER=0;
  list ($_usec, $_sec) = explode (' ', microtime());
  $_MYTIMER = ((float) $_usec + (float) $_sec);
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param $_return - boolean, ????
 */
function StopTimer($_return = false) {
 global $_MYTIMER; if (!$_MYTIMER) return; //no timer has been started
 list ($_usec, $_sec) = explode (' ', microtime()); //get the current time
 $_MYTIMER = ((float) $_usec + (float) $_sec) - $_MYTIMER; //the time taken in milliseconds
 if($_return == false) {
   print number_format ($_MYTIMER, 5);
 } else {
    return number_format ($_MYTIMER, 5);
 }
}

/**
 * tarefa - phpDOC, english!
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param $_registros - Intenger, ????
 * @param $_zero - String, ????
 * @param $_um - String, ????
 * @param $_mais - String, ????
 * @param $_return - Boolean, ????
 */
function label_count($_registros=0, $_zero='Nenhum registro', $_um='1 registro', $_mais='%s registros', $_return=false)
{
  # Verificando a quantidade de registros informado
  switch($_registros)
  {
    case '0':
    case 0:
      $_txt = $_zero;
    break;

    case '1':
    case 1:
      $_txt = $_um;
    break;

    default:
      $_txt = sprintf($_mais, $_registros);
  }#switch
  if($_return == false)
  {
    print $_txt;
  }
  else
  {
    return $_txt;
  }
}

/**
 * tarefa - english!
 * Retorna uma string sem o último caractere.
 * Útil para manipulação de URL's
 * @name remove_ultimo_caractere
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @version 0.1
 * @param string $_str
 * @return string
 */
function remove_ultimo_caractere($_str=false,$_ultimo='')
{
  $_tmp = '';
  if($_str[strlen($_str)-1]==$_ultimo || $_ultimo=='') {

    # Percorre a string excluindo a última posição
    for($i=0;$i<=strlen($_str)-2;$i++)

      # Concatenando a string
      $_tmp .=  $_str[$i];

    # Retornando a string formatada
    return $_tmp;
  } else {
    return $_str;
  }
}

/**
 * 
 */
function datetimeToTimestamp( $_datetime, $_return = false ){
  $_datetime = trim( $_datetime );
  $_timestampValue = '';
  if ( preg_match('/\//', $_datetime) == true ){
    $_timestampValue = strtotime(flipDate( $_datetime ,'/','-'));
  }
  elseif( preg_match('/\-/', $_datetime ) == true ){
    $_timestampValue = strtotime( $_datetime );
  }   
  if ( $_return == true ){
    return $_timestampValue;
  } echo $_timestampValue;
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param $_dia_semana - Type ?, ????
 * @param $_formato - String, ?????
 */
function dia_txt($_dia_semana, $_formato='0') {

  switch(LOCALE) {
    case 'pt_BR':
      switch($_formato) {
        case 0:
          switch($_dia_semana) {
            case 0:  return 'Domingo'; break;
            case 1:  return 'Segunda'; break;
            case 2:  return 'Terça'; break;
            case 3:  return 'Quarta'; break;
            case 4:  return 'Quinta'; break;
            case 5:  return 'Sexta'; break;
            case 6:  return 'Sábado'; break;
          }
        break;
        case 1:
          switch($_dia_semana) {
            case 0:  return 'Dom'; break;
            case 1:  return 'Seg'; break;
            case 2:  return 'Ter'; break;
            case 3:  return 'Qua'; break;
            case 4:  return 'Qui'; break;
            case 5:  return 'Sex'; break;
            case 6:  return 'Sáb'; break;
          }
        break;
        case 2:
          switch($_dia_semana) {
            case 0:  return 'D'; break;
            case 1:  return 'S'; break;
            case 2:  return 'T'; break;
            case 3:  return 'Q'; break;
            case 4:  return 'Q'; break;
            case 5:  return 'S'; break;
            case 6:  return 'S'; break;
          }
        break;
      }
    break;
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param $_dia_mes - Type ?, ????
 * @param $_formato - String, ?????
 */
function mes_txt($_dia_mes, $_formato='0') {

  switch(__LOCALE__) {
    case 'pt_BR':
      switch($_formato) {
        case 0:
          switch($_dia_mes) {
            case 1:   return 'Janeiro'; break;
            case 2:   return 'Fevereiro'; break;
            case 3:   return 'Março'; break;
            case 4:   return 'Abril'; break;
            case 5:   return 'Maio'; break;
            case 6:   return 'Junho'; break;
            case 7:   return 'Julho'; break;
            case 8:   return 'Agosto'; break;
            case 9:   return 'Setembro'; break;
            case 10:  return 'Outubro'; break;
            case 11:  return 'Novembro'; break;
            case 12:  return 'Dezembro'; break;
          }
        break;
        case 1:
          switch($_dia_mes) {
            case 1:   return 'Jan'; break;
            case 2:   return 'Fev'; break;
            case 3:   return 'Mar'; break;
            case 4:   return 'Abr'; break;
            case 5:   return 'Mai'; break;
            case 6:   return 'Jun'; break;
            case 7:   return 'Jul'; break;
            case 8:   return 'Ago'; break;
            case 9:   return 'Set'; break;
            case 10:  return 'Out'; break;
            case 11:  return 'Nov'; break;
            case 12:  return 'Dez'; break;
          }
        break;
        case 2:
          switch($_dia_mes) {
            case 1:   return 'J'; break;
            case 2:   return 'F'; break;
            case 3:   return 'M'; break;
            case 4:   return 'A'; break;
            case 5:   return 'M'; break;
            case 6:   return 'J'; break;
            case 7:   return 'J'; break;
            case 8:   return 'A'; break;
            case 9:   return 'S'; break;
            case 10:  return 'O'; break;
            case 11:  return 'N'; break;
            case 12:  return 'D'; break;
          }
        break;
      }
    break;
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param $_data - Type ?, ????
 * @param $_formato - String, ?????
 * @param $_return - Boolean, ?????
 */
function facebooktime($_data,$_formato='timestamp', $_return =false) {

  if($_formato=='datetime') {
    $_data = (int) datetime2timestamp($_data);
  }

  #*** Se for menor que 60 segundos
  $_dif = time() - $_data;
  if($_dif<60) {
    if($_dif==0) {
      $_string = __t("default.fbtime_now", true);
    } elseif($_dif==1) {
      $_string = __t("default.fbtime_1second", true);
    } else {
      $_string = sprintf(__t("default.fbtime_seconds", true), $_dif);
    }

  #*** 1 Minuto
  } elseif($_dif>59 && $_dif<120) {
    $_string = __t("default.fbtime_halfminute", true);

  #*** Até 1 hora
  } elseif($_dif>119 && $_dif<3600) {
    $_string = sprintf('há %s minutos', floor($_dif/60));

  #*** 1 Hora
  } elseif($_dif>3599 && $_dif<7200) {
    $_string = 'há 1 hora';

  #*** Entre 2 horas e 23 horas e 59 minutos e 59 segundos
  } elseif($_dif>7199 && $_dif<86400) {
    $_string = sprintf('há %s horas', floor($_dif/60/60));

  #*** Ontem às 00:00
  } elseif($_dif>86399 && $_dif<172800) {
    $_string = sprintf('ontem às %s', date('H:s', $_data));

  #*** Entre 2 e 3 dias atrás
  } elseif($_dif>172799 && $_dif<259200) {
    $_string = sprintf('%s às %s', dia_txt(date('N', $_data)), date('H:s', $_data));

  #*** Há mais de 3 dias
  } else {

    #*** Se não for do mesmo ano exibe o ano também
    if(date('Y', $_data) < date('Y')) {
      $_string = sprintf('%s de %s em %s ás %s', date('d', $_data), mes_txt(date('n', $_data)), date('Y', $_data), date('H:s', $_data));
    } else {
      $_string = sprintf('%s de %s ás %s', date('d', $_data), mes_txt(date('n', $_data)), date('H:s', $_data));
    }

  }

  if($_return == true) { return $_string; } else { echo $_string; }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param $_class - Boolean, ????
 */
function odd($_class=false) {

  if($_class==false) {
    if(!$_SESSION['class']) {
      $_SESSION['class'] = 'odd';
    }
    $_class = $_SESSION['class'];
  }

  if($_class=='even')
    $_class = 'odd';
  else
    $_class = 'even';
  $_SESSION['class'] = $_class;
  return $_SESSION['class'];
}

/**
 * Array to XML is a function that does just that... 
 * converts any given array to xml structure.
 *
 * @name array2xml()
 * @author Marcus Carver © 2008 <info@marcuscarver.com>
 * @link http://blog.marcuscarver.com/
 * @version:     1.0
 * @param $array - The array you wish to convert into a XML structure.
 * @param $name - String, The name you wish to enclose the array in, 
 *        the 'parent' tag for XML.
 * @param $standalone - Boolean, This will add a document header to 
 *        identify output solely as a XML document.
 * @param $beginning - Boolean, INTERNAL USE... DO NOT USE!
 * @return: Gives a string output in a XML structure
 *
 * Use:echo array2xml($products,'products');
 */
function array2xml($array, $name='array', $standalone=true, $beginning=true) {

  global $nested;

  if ($beginning) {
    if ($standalone) header("content-type:text/xml;charset=utf-8");
    $output .= '<'.'?'.'xml version="1.0" encoding="UTF-8"'.'?'.'>' . "\n;";
    $output .= '<' . $name . '>' . "\n;";
    $nested = 0;
  }

  // This is required because XML standards do not allow a tag to start with a number or symbol, you can change this value to whatever you like:
  $ArrayNumberPrefix = 'ARRAY_NUMBER_';

 foreach ($array as $root=>$child) {
    if (is_array($child)) {
      $output .= str_repeat(" ", (2 * $nested)) . '  <' . (is_string($root) ? $root : $ArrayNumberPrefix . $root) . '>' . "\n;";
      $nested++;
      $output .= array2xml($child,NULL,NULL,FALSE);
      $nested--;
      $output .= str_repeat(" ", (2 * $nested)) . '  ' . "\n;";
    }
    else {
      $output .= str_repeat(" ", (2 * $nested)) . '  <' . (is_string($root) ? $root : $ArrayNumberPrefix . $root) . '>' . "\n;";
    }
  }

  if ($beginning) $output .= '';

  return $output;
}

/**
 * tarefa - phpDoc, english
 * Faz a requisição de uma biblioteca específica
 * @param String  $_lib
 * @param Boolean $_instantiate
 * @version 0.1
 */
function require_lib($_lib=false, $_instantiate=true, $_prefixo='')
{

  # Verificando se o controlador foi informado
  if($_lib!=false)
  {
    # Existe o arquivo solicitado?
    if(file_exists(__ROOT__.'lib/'.$_prefixo.$_lib.'.php'))
    {
      require_once __ROOT__.'lib/'.$_prefixo.$_lib.'.php';

      # Se for solicitado instanciar a classe (para classes simples) retorna um objeto
      if($_instantiate==true)
      {

        eval('$Objeto = new '.$_lib.';');

        if(is_object($Objeto))
        {
          return $Objeto;
        }
        else
        {
          return false;
        }
      }
    }
    else
    {
      echo 'A biblioteca "<strong>'.$_lib.'</strong>" não foi encontrado em "'.__ROOT__.'lib/';
      exit(0);
      return false;
    }
  } else {

    echo 'Nenhuma biblioteca informada.';
    exit(0);
    return false;
  }
}


/**
 * tarefa - phpDoc
 * Trabalhando com URL's limpas
 * @name rewrite
 * @version 0.2
 */
function rewrite($_index='none') {
  $_rewrite      = explode('/', str_ireplace(__REWRITE_EXT__, '', remove_ultimo_caractere(str_replace(str_replace(__PATH__, '/', $_SERVER['SCRIPT_NAME']), '', str_replace(__PATH__, '/', $_SERVER['REQUEST_URI'])), '/')));
  $_rewrite['0'] = $_request_uri = str_ireplace(__REWRITE_EXT__, '', str_replace(str_replace(__PATH__, '/', $_SERVER['SCRIPT_NAME']), '', str_replace(__PATH__, '/', $_SERVER['REQUEST_URI'])));
  $_return = null;
  
  if(is_int($_index)) {
    if( isset( $_rewrite[ $_index ] ) ) {
      $_return = remove_ultimo_caractere( $_rewrite[ $_index ], '/');
      if(strpos($_return, '?')>0) {
        $_tmp = explode('?', $_return);
        $_return = $_tmp[0];
      }
    }
    return $_return;
  } else {
    return $_rewrite;
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param Boolean $_link    - ???
 * @param Boolean $_return  - ???
 * @param String  $_ext     - ???
 */ 
function cdn_location($_link=false, $_return = false, $_ext='none') {

  if($_link['0']=='/'){
    for($i=1;$i<=strlen($_link);$i++) $_tmp .= $_link[$i];
    $_link = $_tmp;
  }

  $_url  = CDN_DIR . str_replace( '//', '/', $_link);

  if($_return==false) {
    echo $_url;
  } else {
    return $_url;
  }
}

/**
 * tarefa - phpDOC
 * @param Boolean $_link    - ???
 * @param Boolean $_return  - ???
 * @param String  $_ext     - ???
 */ 
function data_location($_link=false, $_return = false, $_ext='none') {

  if($_link['0']=='/'){
    for($i=1;$i<=strlen($_link);$i++) $_tmp .= $_link[$i];
    $_link = $_tmp;
  }

  $_url  = DATA_DIR . str_replace( '//', '/', $_link);

  if($_return==false) {
    echo $_url;
  } else {
    return $_url;
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param Boolean $_link    - ??? 
 * @param Boolean $_return  - ??? 
 * @param String  $_ext      - ??? 
 */
function pkg_location($_link=false, $_return = false, $_ext='none') {

  if($_link['0']=='/'){
    for($i=1;$i<=strlen($_link);$i++) $_tmp .= $_link[$i];
    $_link = $_tmp;
  }

  $_url  = PKG_DIR . str_replace( '//', '/', $_link);

  if($_return==false) {
    echo $_url;
  } else {
    return $_url;
  }
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 *
 * Retorna ou adiciona componente no breadcrumb
 * @param string $_str
 * @return string
 */
function set_breadcrumb($_str = false, $_clean=false) {
  if($_clean==false) {
    $_SESSION['SEO']['breadcrumb'] .= $_str;
  } else {
    $_SESSION['SEO']['breadcrumb'] = $_str;
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 *
 * Retorna ou exibe o breadcrumb
 */
function get_breadcrumb($_return =false) {
  if($_return==false) {
    echo $_SESSION['SEO']['breadcrumb'];
  } else {
    return $_SESSION['SEO']['breadcrumb'];
  }
}

function seo_noscript( $_str = false ) {
  if( $_str == true ) { $_SESSION['SEO']['noscript'] = $_str;}
  return $_SESSION['SEO']['noscript'];
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Retorna ou adiciona o título do site <title>
 * @param string $_str
 * @return string
 */
function seo_title( $_str = false, $_clean = false, $_reverse = false ) {
  if( $_str == true ) {
    if($_clean == false) {
    	if($_reverse == false) {
      	$_SESSION['SEO']['title'] .= " " . __TITLE_SEP__ . " {$_str}";
    	} else {
      	$_SESSION['SEO']['title'] =  "{$_str} " . __TITLE_SEP__ . ' ' . $_SESSION['SEO']['title'];
    	}
    } else {
      $_SESSION['SEO']['title'] = $_str;
    }
  }
	return $_SESSION['SEO']['title'];
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 *
 * Retorna ou adiciona a descrição do site
 * @param string $_str
 * @return string
 */
function seo_description( $_str = false ) {
  if( $_str==false ) {
    return $_SESSION['SEO']['description'];
  } else {
    $_SESSION['SEO']['description'] = $_str;
    return $_SESSION['SEO']['description'];
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function seo_tags( $_str = false ){
  if($_str==false) {
    return $_SESSION['SEO']['tags'];
  } else {
    $_SESSION['SEO']['tags'] = $_str;
    return $_SESSION['SEO']['tags'];
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Christian Marcell (chroda) <christianmarcell@gmail.com>
 * @param 
 *
 * Retorna ou adiciona a descrição do site
 * @param string $_str
 * @return string
 */
function seo_copyright( $_str = false ) {
  if($_str==false) {
    return $_SESSION['SEO']['copyright'];
  } else {
    $_SESSION['SEO']['copyrigth'] = $_str;
    return $_SESSION['SEO']['copyright'];
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function passwd( $_passwd=false ) {
  return md5($_passwd . __PASS_SALT__);
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function is_app($_slug=false){
  $__db = $_SESSION['__db'];
  if($_slug!=false) {
    # Fazendo a verificação
    $__ds = $__db->Aplicativos->findOne(Array(
      'slug' => new MongoRegex('/'.strtolower($_slug).'/')
    ));
    if(is_array($__ds)) {
      return $__ds;
    } else {
      return false;
    }
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * @param $s  Informa uma string com uma URL e retirar o que não deve
 * @return string
 * @name string_safe
 */
function string_safe($str) {
  # A
  $str = str_replace('Ã', 'A', $str);
  $str = str_replace('ã', 'a', $str);
  $str = str_replace('Á', 'A', $str);
  $str = str_replace('á', 'a', $str);
  $str = str_replace('À', 'A', $str);
  $str = str_replace('à', 'a', $str);
  $str = str_replace('Ä', 'A', $str);
  $str = str_replace('ä', 'a', $str);
  $str = str_replace('Ã', 'A', $str);
  $str = str_replace('Â', 'A', $str);
  $str = str_replace('â', 'a', $str);

  # E
  $str = str_replace('É', 'E', $str);
  $str = str_replace('é', 'e', $str);
  $str = str_replace('Ë', 'E', $str);
  $str = str_replace('ë', 'e', $str);
  $str = str_replace('ê', 'e', $str);
  $str = str_replace('Ê', 'E', $str);

  # I
  $str = str_replace('Í', 'I', $str);
  $str = str_replace('é', 'i', $str);

  # O
  $str = str_replace('Õ', 'O', $str);
  $str = str_replace('õ', 'o', $str);
  $str = str_replace('Ó', 'O', $str);
  $str = str_replace('ó', 'o', $str);
  $str = str_replace('Ô', 'O', $str);
  $str = str_replace('ô', 'o', $str);
  $str = str_replace('Ò', 'O', $str);
  $str = str_replace('ò', 'o', $str);
  $str = str_replace('Ö', 'O', $str);
  $str = str_replace('ö', 'o', $str);


  # U
  $str = str_replace('Ú', 'U', $str);
  $str = str_replace('ú', 'u', $str);
  $str = str_replace('Ù', 'U', $str);
  $str = str_replace('ù', 'u', $str);
  $str = str_replace('Ü', 'U', $str);
  $str = str_replace('ü', 'u', $str);

  # Ç
  $str = str_replace('Ç', 'c', $str);
  $str = str_replace('ç', 'c', $str);
  $str = str_replace(' ', '-', $str);

  #  Transformando em integer
  $tmp = preg_replace("@[^A-Za-z0-9\@\.\-_]+@i", '', $str);

  return $tmp;
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param $s Informa um numero maior igual a 0 e menor que 10
 * @return string Retorna 01,02,03,04,05,06,07,08,09 caso seja somente 1,2,3,4,5,6,7,8,9
 * @name string_menor10
 */
function lessTen($number) {
  if (strlen($number)==1) {
    return '0'.$number;
  } return $number;
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Retorna somente os numeros da string informada
 * @return Integer
 * @param $str Object
 * @name strtoint
 */
function strtoint($str) {

  #  Transformando em integer
  $tmp = preg_replace("/[^0-9]/", '', $str);

  #  Retornando o valor obtido
  return $tmp;
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function bytes($_bytes=0, $_return='KB')
{
  if($_return=='B')
  {
    $_tamanho = inttostr($_bytes,2);
  }elseif ($_return=='KB')
  {
    $_tamanho = inttostr($_bytes/1024,2);
  }elseif($_return=='MB')
  {
    $_tamanho = inttostr($_bytes/pow(1024,2),2);
  }
  return $_tamanho;
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function inttostr( $nNum, $nDecimais ) {
  $ResConv = strval($nNum);
  $Pos = strrpos ($ResConv, '.');
  if ($pos === false) {
    return $ResConv;
  } else {
    return substr($ResConv,0,$Pos+$nDecimais+1);
  }
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Retorna apenas o número de palavras solicitado
 * @return String
 * @param $texto String
 * @param $n_palavras Integer
 * @name string_limita_palavras
 */
function limita_palavras($texto, $n_palavras) {
  $resultado = explode(" ",$texto);
    foreach($resultado as $chave=>$r) {
      if($chave>=$n_palavras) break;
      $buff[]= $r;
    }
    return implode(" ",$buff);
}

function conta_palavras($_texto)
{
  $_resultado = explode(" ",$_texto);
  return count($_resultado);
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Criação do link permanente para url_rewrite
 *
 * @access public
 * @name permlink
 * @param $str String
 * @version 0.2
 * @package Vision
 */
function permlink( $str )
{
  $str = trim( $str );
  # A
  $str = str_replace('Ã', 'A', $str);
  $str = str_replace('ã', 'a', $str);
  $str = str_replace('Á', 'A', $str);
  $str = str_replace('á', 'a', $str);
  $str = str_replace('À', 'A', $str);
  $str = str_replace('à', 'a', $str);
  $str = str_replace('Ä', 'A', $str);
  $str = str_replace('ä', 'a', $str);
  $str = str_replace('Ã', 'A', $str);
  $str = str_replace('Â', 'A', $str);
  $str = str_replace('â', 'a', $str);
  # E
  $str = str_replace('É', 'E', $str);
  $str = str_replace('é', 'e', $str);
  $str = str_replace('Ë', 'E', $str);
  $str = str_replace('ë', 'e', $str);
  $str = str_replace('ê', 'e', $str);
  $str = str_replace('Ê', 'E', $str);

  # I
  $str = str_replace('Í', 'I', $str);
  $str = str_replace('í', 'i', $str);
  $str = str_replace('é', 'i', $str);
  # O
  $str = str_replace('Õ', 'O', $str);
  $str = str_replace('õ', 'o', $str);
  $str = str_replace('Ó', 'O', $str);
  $str = str_replace('ó', 'o', $str);
  $str = str_replace('Ô', 'O', $str);
  $str = str_replace('ô', 'o', $str);
  $str = str_replace('Ò', 'O', $str);
  $str = str_replace('ò', 'o', $str);
  $str = str_replace('Ö', 'O', $str);
  $str = str_replace('ö', 'o', $str);
  # U
  $str = str_replace('Ú', 'U', $str);
  $str = str_replace('ú', 'u', $str);
  $str = str_replace('Ù', 'U', $str);
  $str = str_replace('ù', 'u', $str);
  $str = str_replace('Ü', 'U', $str);
  $str = str_replace('ü', 'u', $str);
  # Ç
  $str = str_replace('Ç', 'c', $str);
  $str = str_replace('ç', 'c', $str);
  $str = str_replace(' ', '-', $str);
  $str = str_replace('.', '', $str);
  $str = str_replace('--', '-', $str);
  #  Transformando em integer
  $tmp = strtolower( preg_replace("@[^A-Za-z0-9\@\.\-_]+@i", '', $str) );
  # Retornando o valor final
  return $tmp;
} # function permlink

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function br2nl($_string)
{
  return preg_replace('/<br\\s*?\/??>/i', '\n', $_string);
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Retorna formatação de email sem espaços e tudo minísculo
 */
function str_email($_email) {
	return strtolower( preg_replace("@[^A-Za-z0-9\@\.\-_]+@i", '', trim($_email)));
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function toupper($_str)
{
  $_str = strtoupper(trim( $_str ));

  # A
  $_str = str_replace('ã', 'Ã', $_str);
  $_str = str_replace('á', 'Á', $_str);
  $_str = str_replace('à', 'À', $_str);
  $_str = str_replace('ä', 'Ä', $_str);
  $_str = str_replace('â', 'Â', $_str);

  # E
  $_str = str_replace('é', 'É', $_str);
  $_str = str_replace('ë', 'Ë', $_str);
  $_str = str_replace('ê', 'Ê', $_str);


  # I
  $_str = str_replace('í', 'Í', $_str);
  $_str = str_replace('ì', 'Ì', $_str);

  # O
  $_str = str_replace('õ', 'Õ', $_str);
  $_str = str_replace('ó', 'Ó', $_str);
  $_str = str_replace('ô', 'Ô', $_str);
  $_str = str_replace('ò', 'Ò', $_str);
  $_str = str_replace('ö', 'Ö', $_str);

  # U
  $_str = str_replace('ú', 'Ú', $_str);
  $_str = str_replace('ù', 'Ù', $_str);
  $_str = str_replace('ü', 'Ü', $_str);

  # Ç
  $_str = str_replace('ç', 'Ç', $_str);

  return $_str;
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function get_referer_keywords( $_robot ){
  # Pegando dados da url de referência
  $_referencia = strtolower($_SERVER['HTTP_REFERER']);

  # Verificando se vem do robô especificado
  if (strpos($_referencia, $_robot)){
    # Excluindo tudo antes "q="
    $a = substr($_referencia, strpos($_referencia, 'q='));

    # Excluindo "q=
    $a = substr($a,2);

    # Excluindo tudo após o próximo "&"
    if (strpos($a,"&")){
      $a = substr($a, 0,strpos($a,"&"));
    }

    # Retornando palavras chaves
    return urldecode($a);
  }#if
}# function get_referer_keywords


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Gera um SELECT contendo a lista de todas as cidades
 * @name select_cidades
 * @version 0.1
 */
function select_cidades( $_argv = Array(), $_estado=false, $_selected=false ) {

  $__db = $_SESSION['__db'];

  #  Resetando ponteiro
  reset( $_argv );

  #  Variável que armazenará o input
  $_html = "<select ";

  #  Percorrendo vetor e concatenando os atributos
  while(list($_chave, $_valor)=each($_argv))
    $_html .= " {$_chave}=\"{$_valor}\"";

  $_html .= ">";

  # Verificando
  if($_selected!=false)
    $_html .= '<option value="null">Selecione...</option>';
  else
    $_html .= '<option value="null" selected="selected">Selecione...</option>';

  $_html .= '<option value="null" disabled="disabled" style="background:#eee;"></option>';

  # Fazendo a consulta
  $_cursor = $__db->Cidades->find(Array('estado'=>"{$_estado}"));

  # Gerando a lista de países
  foreach($_cursor as $_result){
    # Verificando
    if($_selected != false && $_result['id'] == $_selected )
      $selected = ' selected="selected"';
    else
      $selected = '';
    $_html .= sprintf('<option value="%s"%s>%s</option>', $_result['id'], $selected, $_result['nome'] );
  }#foreach

  $_html .= '</select>';

  return $_html;

} # select_cidades


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Gera um SELECT contendo a lista de todos os estados
 * @name select_estados
 * @version 0.1
 */
function select_estados( $_argv = Array(), $_selected=false ) {

  $__db = $_SESSION['__db'];

  #  Resetando ponteiro
  reset( $_argv );

  #  Variável que armazenará o input
  $_html = "<select ";

  #  Percorrendo vetor e concatenando os atributos
  while(list($_chave, $_valor)=each($_argv))
    $_html .= " {$_chave}=\"{$_valor}\"";

  $_html .= ">";

  # Verificando
  if($_selected!=false)
    $_html .= '<option value="null">Selecione...</option>';
  else
    $_html .= '<option value="null" selected="selected">Selecione...</option>';

  $_html .= '<option value="null" disabled="disabled" style="background:#eee;"></option>';

  # Fazendo a consulta
  $_cursor = $__db->Estados->find();

  # Gerando a lista de estados
  foreach($_cursor as $_result){
    # Verificando
    if($_selected != false && $_result['id'] == $_selected )
      $selected = ' selected="selected"';
    else
      $selected = '';
    $_html .= sprintf('<option value="%s"%s>%s</option>', $_result['id'], $selected, $_result['nome'] );
  }#foreach

  $_html .= '</select>';

  return $_html;

} # select_estados


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Gera um SELECT contendo a lista de todos os logradouros
 * @name select_logradouros
 * @version 0.1
 */
function select_logradouros( $_argv = Array(), $_selected=false ) {

  $__db = $_SESSION['__db'];

  #  Resetando ponteiro
  reset( $_argv );

  #  Variável que armazenará o input
  $_html = "<select ";

  #  Percorrendo vetor e concatenando os atributos
  while(list($_chave, $_valor)=each($_argv))
    $_html .= " {$_chave}=\"{$_valor}\"";

  $_html .= ">";

  # Verificando
  if($_selected!=false)
    $_html .= '<option value="null">Selecione...</option>';
  else
    $_html .= '<option value="null" selected="selected">Selecione...</option>';

  $_html .= '<option value="null" disabled="disabled" style="background:#eee;"></option>';

  # Fazendo a consulta
  $_cursor = $__db->Logradouros->find();

  # Gerando a lista de estados
  foreach($_cursor as $_result){
    # Verificando
    if($_selected != false && $_result['id'] == $_selected )
      $selected = ' selected="selected"';
    else
      $selected = '';
    $_html .= sprintf('<option value="%s"%s>%s</option>', $_result['id'], $selected, $_result['nome'] );
  }#foreach

  $_html .= '</select>';

  return $_html;

} # select_logradouros


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Retorna o endereço em um Array
 * @param $_cep integer
 * @return Array
 * @version 0.1
 * @copyright Felipe Olivaes para http://www.republicavirtual.com.br
 */
function busca_endereco( $_cep = false)
{
  $_cep = strtoint($_cep);
	# Verifica se é um CEP válido
  if($_cep==false || strlen($_cep)<8 || strlen($_cep)>9)
  {
    print 'Informe o CEP corretamente';
    return false;
  }
    else
  {
    $_resultado = @file_get_contents("http://republicavirtual.com.br/web_cep.php?cep={$_cep}&formato=json");
    if(!$_resultado)
    {
      print "Erro ao buscar o endereço.";
      return false;
    }

    # Retornando
    return $_resultado;
  }#if
}#function busca_endereco

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function url_ico($_ico='alert', $_size='16', $_return = false) {
  $_ext  = '.png';

  if($_return == true) {
    return location("assets/ico/{$_size}/{$_ico}",true, $_ext);
  }
  location("assets/ico/{$_size}/{$_ico}",false, $_ext);
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Armazena uma mensagem de erro
 * @version 0.2
 */
function set_flash($_argv=false) {

  if($_argv==false) {
    $_argv = Array(
      'title' => 'Sistema',
      'text'  => 'Operação concluída!',
      'ico'   => 'alert'
    );
  }
  $_SESSION['flash'] = Array(
    'timestamp' => time(),
    'title' => $_argv['title'],
    'text'  => $_argv['text'],
    'ico'   => url_ico($_argv['ico'], 32, true)
  );
  return true;
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Puxa o resultado obtido com a última operação
 * @return unknown_type
 */
function get_flash(){
  $_inicio = $_SESSION['flash']['timestamp'];
  $_fim    = time();
  $_dif    = $_fim - $_inicio;
  if($_dif<=__FLASH_DIF__) {
    $_flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $_flash;
  } else {
    return false;
  }
}

if (DATABASE === 'mongo') {
  /**
   * tarefa - phpDOC
   * how work ????
   * @author Michel Wilhelm <michelwilhelm@gmail.com>
   * @param 
   * This function translate all the environment according with the
   * i18n on database and the user's preference or the default system preference located on config.php
   * defined with __LOCALE__ constant
   *
   * The __t is Translate :)
   * @version 0.1
   * @name __t
   */
  function __t( $_query = false, $_return = false ) {
    // Database connection
    $__db = $_SESSION['__db'];
  
    // Getting arguments
    $_args = explode('.', $_query);
    if( count($_args) == 1 ){ $_args['0'] = 'default'; $_args['1'] = $_query; }
    
    // Verifying the translate
    if( isset( $_SESSION['user']['locale'] ) ) {
      $_locale = $_SESSION['user']['locale'];
    } else {
      $_locale = __LOCALE__;
    }
  
    // Getting translate
  	  $_i18n = $__db->i18n->findOne(Array('locale'=>$_locale, 'group' => $_args['0'], 'key' => $_args['1']));
  
    if($_return==true) {
      return $_i18n['value'];
    } elseif($_return=='array') {
      return $_i18n;
    } else {
      echo $_i18n['value'];
    }
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function apiKey_generate(){

  // Conexão com o Mongo
  $__db = $_SESSION['__db'];
  $_str = '';

  //*** Caracteres válidos
  $_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';

  //*** Gerando a string
  for ($_i = 0; $_i < 32; $_i++)
    $_str .= $_chars[mt_rand(0, strlen($_chars))];

  // Verificando se a chave já foi usada ou não
  if(!is_array($__db->Usuarios->findOne(Array('api_key'=>$_str)))) {
    if(strlen($_str)==32) {
      return $_str;
    } else {

      $_str = apiKey_generate();
      return $_str;
    }
  } else {
    return apiKey_generate();
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function post_hash(){

  // Conexão com o Mongo
  $__db = $_SESSION['__db'];


  #*** Caracteres válidos
  $_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';

  #*** Gerando a string
  for ($_i = 0; $_i < 32; $_i++)
    $_str .= $_chars[mt_rand(0, strlen($_chars))];

  // Verificando se a chave já foi usada ou não
  if(!is_array($__db->Posts->findOne(Array('token'=>$_str)))) {
    if(strlen($_str)==32) {
      return $_str;
    } else {

      $_str = post_hash();
      return $_str;
    }
  } else {
    return post_hash();
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function file_ext($_args = Array()) {
  if(count($_args)>0) {

    $_buff = explode('.', $_args['name']);
    return $_buff[count($_buff)-1];

  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function get_mime_header($_ext, $_return = false) {
  switch(trim(strtolower($_ext))) {

    // Application
    case 'atom'  :
    case 'xml'   : $_header = 'application/atom+xml'; break;
    case 'json'  : $_header = 'application/json'; break;
    case 'js'    : $_header = 'application/javascript'; break;
    case 'json'  : $_header = 'application/json'; break;
    case 'ogg'   : $_header = 'application/ogg'; break;
    case 'ps'    : $_header = 'application/postscript'; break;
    case 'woff'  : $_header = 'application/x-woff'; break;
    case 'xhtml' :
    case 'xht'   :
    case 'xml'   :
    case 'html'  :
    case 'htm'   : $_header = 'application/xhtml+xml'; break;
    case 'dtd'   : $_header = 'application/xml-dtd'; break;
    case 'zip'   : $_header = 'application/zip'; break;
    case 'gz'    : $_header = 'application/x-gzip'; break;

    // Audio
    case 'au'    :
    case 'snd'   : $_header = 'audio/basic'; break;
    case 'mid'   :
    case 'rmi'   : $_header = 'audio/mid'; break;
    case 'mp3'   : $_header = 'audio/mpeg'; break;
    case 'aif'   :
    case 'aifc'  :
    case 'aiff'  : $_header = 'audio/x-aiff'; break;
    case 'm3u'   : $_header = 'audio/x-mpegurl'; break;
    case 'ra'    :
    case 'ram'   : $_header = 'audio/x-pn-realaudio'; break;
    case 'wav'   : $_header = 'audio/x-wav'; break;

    // Image
    case 'bmp'   : $_header = 'image/bmp'; break;
    case 'cod'   : $_header = 'image/cis-cod'; break;
    case 'gif'   : $_header = 'image/gif'; break;
    case 'ief'   : $_header = 'image/ief'; break;
    case 'jpe'   :
    case 'pjpeg' : $_header = 'image/pjpeg';  break;
    case 'jpeg'  :
    case 'jpg'   : $_header = 'image/jpeg'; break;
    case 'jfif'  : $_header = 'image/pijpeg'; break;
    case 'png'   : $_header = 'image/x-png'; break;
    case 'svg'   : $_header = 'image/svg+xml'; break;
    case 'tif'   :
    case 'tiff'  : $_header = 'image/tiff'; break;
    case 'ras'   : $_header = 'image/x-cmu-raster'; break;
    case 'cmx'   : $_header = 'image/x-cmx'; break;
    case 'ico'   : $_header = 'image/x-icon'; break;
    case 'pnm'   : $_header = 'image/x-portable-anymap'; break;
    case 'pbm'   : $_header = 'image/x-portable-bitmap'; break;
    case 'pgm'   : $_header = 'image/x-portable-graymap'; break;
    case 'ppm'   : $_header = 'image/x-portable-pixmap'; break;
    case 'rgb'   : $_header = 'image/x-rgb'; break;
    case 'xbm'   : $_header = 'image/x-bitmap'; break;
    case 'xpm'   : $_header = 'image/x-xpixmap'; break;
    case 'xwd'   : $_header = 'image/x-xwindowdump'; break;

    // Message
    case 'mht'   :
    case 'mhtml' :
    case 'nws'   : $_header = 'message/rfc822'; break;

    // Text
    case 'css'   : $_header = 'text/css'; break;
    case 'h323'  : $_header = 'text/323'; break;
    case 'htm'   :
    case 'html'  :
    case 'stm'   : $_header = 'text/html'; break;
    case 'uls'   : $_header = 'text/iuls'; break;
    case 'bas'   :
    case 'c'     :
    case 'h'     :
    case 'as'    :
    case 'txt'   : $_header = 'text/plain'; break;
    case 'rtx'   : $_header = 'text/richtext'; break;
    case 'sct'   : $_header = 'text/scriptlet'; break;
    case 'tsv'   : $_header = 'text/tab-separated-values'; break;
    case 'htt'   : $_header = 'text/webviewhtml'; break;
    case 'htc'   : $_header = 'text/x-component'; break;
    case 'etx'   : $_header = 'text/x-settext'; break;
    case 'vcf'   : $_header = 'text/x-vcard'; break;

    // Video
    case 'mp2'   :
    case 'mpa'   :
    case 'mpe'   :
    case 'mpeg'  :
    case 'mpg'   :
    case 'mpv2'  : $_header = 'video/mpeg'; break;
    case 'mov'   :
    case 'qt'    : $_header = 'video/quicktime'; break;
    case 'lsf'   :
    case 'lsx'   : $_header = 'video/x-la-asf'; break;
    case 'asf'   :
    case 'asr'   :
    case 'asx'   : $_header = 'video/x-ms-asf'; break;
    case 'avi'   : $_header = 'video/x-msvideo'; break;
    case 'movie' : $_header = 'video/x-sgi-movie'; break;

    // Other
    case 'flr'   :
    case 'vrml'  :
    case 'wrl'   :
    case 'wrz'   :
    case 'xaf'   :
    case 'xof'   : $_header = 'x-world/x-vrml'; break;

    // Default: binary
    default:
      $_header = 'application/octet-stream';
  }

  if($_return==true) {
    return $_header;
  } else {
    header("Content-type: {$_header}");
  }

}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function import( $_lib = false, $_instantiate = true ) {

  // Verificando se o controlador foi informado
  if( $_lib != false ) {

    // Existe o arquivo solicitado?
    if( file_exists( __CORE_DIR__ . str_replace( '.', '/', $_lib ) . '.php' ) ) {
      
      require_once __CORE_DIR__ . str_replace( '.', '/', $_lib ) . '.php';
      
      $_lib = str_replace( 'controllers.', '', $_lib );
      $_lib = str_replace( 'library.', '', $_lib );
      $_lib = str_replace( 'includes.', '', $_lib );

      if( class_exists( $_lib ) ) {
        
        // Se for solicitado instanciar a classe (para classes simples) retorna um objeto
        if( $_instantiate == true ) {
          
          // Instanciando o objeto dinamicamente
          eval( '$Objeto = new ' . $_lib . ';' );

          # Setando conexão com o banco de dados
          if(method_exists( $Objeto, '__db' ) ) {
            $Objeto->__db( $_SESSION['__db'] );
          }

          # Retornando o objeto;
          return $Objeto;

        }
      }
    } else {
      echo 'A biblioteca "<strong>'.$_lib.'</strong>" não foi encontrada. Arquivo: "'.__ROOT__.str_replace('.', '/', $_lib).'.php';
      exit(0);
      return false;
    }

  }
  else
  {
    echo 'Nenhuma biblioteca informada.';
    exit(0);
    return false;
  }
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Alias para obter o id do usuário logado
 * @name my_id
 * @version 0.1
 * @return type MongoObjectId
 */
function my_id(){
  return $_SESSION['user']['id'];
}



/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function issueId($_id=false){
  if(!is_int($_id) || $_id < 0) {
    trigger_error('Você precisa informar o ID', E_USER_WARNING);
  } else {
    if(is_admin()){ //Mostra a issue apenas para administradores
      return "<p>Em desenvolvimento (<a style=\"color: #f99;\" href=\"http://jobs.crossmediabrasil.com:3000/issues/{$_id}\" target=\"blank\">issue #{$_id}</a>)</p>";
    }
  }
}


/**
 * tarefa - phpDOC
 * tarefa - Melhorar function, fazer todo o controle internamente e retornar uma div pronta.
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * @name NOW()
 * @return mysql_datetime Retorna data no formado Y-m-d H:i:s
 */
function NOW() {
  return date('Y-m-d H:i:s');
} # function NOW()


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function _version($_file)
{
  filemtime($_file);
  $_version = md5( file_get_contents($_file) );
  return $_version;
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function array_debug($_array=false)
{
  if($_array==false || !is_array($_array)) {
    echo '<pre>';
    echo 'Informe um array!';
    echo '</pre>';
  } else {
    echo '<pre>';
    print_r($_array);
    echo '</pre>';
  }
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Faz a requisição de um arquivo controlador de alguma
 * tabela da base de dados
 *
 * @param String $_controller
 * @param Bool $_instantiate
 * @version 0.1
 */
function require_controller($_controller=false, $_instantiate=false)
{

  # Verificando se o controlador foi informado
  if($_controller!=false)
  {
    # Existe o arquivo solicitado?
    if(file_exists(__ADMIN_ROOT__.'controllers/'.$_controller.'.php'))
    {
      require_once __ADMIN_ROOT__.'controllers/'.$_controller.'.php';

      # Se for solicitado instanciar a classe (para classes simples) retorna um objeto
      if($_instantiate==true)
      {
        # Instanciando o objeto dinamicamente
        eval('$Objeto = new '.$_controller.';');

        # Setando conexão com o banco de dados
        $Objeto->setDB($_SESSION['DB']);

        # Retornando o objeto;
        return $Objeto;
      }
    }
    else
    {
      echo 'O controlador "<strong>'.$_controller.'</strong>" não foi encontrado em "'.__ADMIN_ROOT__.'controllers/';
      exit(0);
      return false;
    }
  }
  else
  {
    echo 'Nenhum controlador informado.';
    exit(0);
    return false;
  }
}



/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function share_addthis($_label='Compartilhar') {
  ?>
  <!-- AddThis Button BEGIN -->
  <div class="addthis_toolbox addthis_default_style">
    <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=<?php echo __ADDTHIS_USER__?>" class="addthis_button_compact"><?php echo $_label?></a>
    <!--<span class="addthis_separator">|</span>-->
    <a class="addthis_button_facebook"></a>
    <a class="addthis_button_myspace"></a>
    <a class="addthis_button_google"></a>
    <a class="addthis_button_twitter"></a>
  </div>
  <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=michelwilhelm"></script>
  <!-- AddThis Button END -->
  <?php
}

/**
 * Pega o arquivo de configuração de um determinado aplicativo
 * @param string $_app
 * @name require_app
 * @return bool
 */
function require_app($_app = false) {

  # Verificando se foi informado a string
  if($_app!=false) {

    # Localização do arquivo de configuração do aplicativo
    $_arq = __ROOT__ . 'app/' . $_app . '/conf.php';
    
    # Se o arquivo de configuração existir
    if(file_exists($_arq)) {

      # Puxando o arquivo
      require_once $_arq;
      return true;

    } else {

      # Retornando uma string com erro
      echo '<strong>[Erro]</strong> O aplicativo não pôde ser carregado porque não foi encontrado o arquivo de configuração. <strong>'.$_arq.'</strong>';
      return false;
    }
    return true;
  } else {
    echo '<strong>[Erro]</strong> O aplicativo não foi informado.';
    return false;
  }
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Força um redirecionamento
 * @param $_url
 * @return unknown_type
 */
function redirect($_url)
{

  if(@header("Location: {$_url}")==false)
  {
    $Vision = require_lib('Vision', true);
    echo $Vision->js("window.location=('{$_url}')");
  }
  return true;
}



/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function css_dir($_return=true) {
  $_tmp = 'http://'.__DNS__.'/views/css/';
  if($_return==true)
    return $_tmp;
  else
    echo $_tmp;
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function js_dir($_return=true) {
  $_tmp = 'http://'.__DNS__.'/views/js/';
  if($_return==true)
    return $_tmp;
  else
    echo $_tmp;
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function img_dir($_return=true) {
  $_tmp = 'http://'.__DNS__.'/views/img/';
  if($_return==true)
    return $_tmp;
  else
    echo $_tmp;
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function data_dir($_return=true) {
  $_tmp = 'http://'.__DNS__.'/data/';
  if($_return==true)
    return $_tmp;
  else
    echo $_tmp;
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function lower($_str=false) {
  return trim(strtolower($_str));
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function upper($_str=false) {
  return trim(strtoupper($_str));
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function site_location($_link=false, $_return = false, $_ext='none')
{
  $_dns  = __SITE_DNS__;
  $_path = __PATH__;

  if($_ext=='none')
  {
    $_ext  = __REWRITE_EXT__;
  } elseif($_ext==false){
    $_ext = '';
  } else {
    $_ext  = $_ext;
  }

  #*** Se o primeiro char for /
  if($_link['0']=='/')
  {
    for($i=1;$i<=strlen($_link);$i++)
    {
      $_tmp .= $_link[$i];
    }
    $_link = $_tmp;
  }
  
  if($_SERVER['SERVER_PORT'] != 80)
  {
    $_port = ":{$_SERVER['SERVER_PORT']}";
  }
  
  $_url  = "http://".str_replace('//','/',"{$_dns}{$_port}{$_path}{$_link}{$_ext}");
  
  if($_return==false)
  {
    echo $_url;
  } else {
    return $_url;
  }
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function location_pkg($_link=false, $_return = false)
{
  $_dns  = __PKG_URL__;
  $_path = __PATH__;

  #*** Se o primeiro char for /
  if($_link['0']=='/')
  {
    for($i=1;$i<=strlen($_link);$i++)
    {
      $_tmp .= $_link[$i];
    }
    $_link = $_tmp;
  }
  
  if($_SERVER['SERVER_PORT'] != 80)
  {
    $_port = ":{$_SERVER['SERVER_PORT']}";
  }
  
  $_url  = "http://".str_replace('//','/',"{$_dns}{$_port}{$_path}{$_link}");
  
  if($_return==false)
  {
    echo $_url;
  } else {
    return $_url;
  }
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 *
 * Gera a máscara para o telefone
 * @version 0.1
 * @name mask_telefone
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param integer $_telefone
 * @param boolean $_return
 * @return string
 */
function mask_telefone($_telefone='0000000000', $_return=false)
{
  $_t = preg_replace("/[^0-9]/", '', $_telefone);
  $_tmp = "({$_t['0']}{$_t['1']}) {$_t['2']}{$_t['3']}{$_t['4']}{$_t['5']}-{$_t['6']}{$_t['7']}{$_t['8']}{$_t['9']}";
  if($_return==true)
  {
    return $_tmp;
  } else {
    echo $_tmp;
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Gera a máscara para o CPF
 * @version 0.1
 * @name mask_cpf
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param integer $_cpf
 * @param boolean $_return
 * @return string
 */
function mask_cpf($_cpf='00000000000', $_return=false)
{
  $_t = preg_replace("/[^0-9]/", '', $_cpf);
  $_tmp = "{$_t['0']}{$_t['1']}{$_t['2']}.{$_t['3']}{$_t['4']}{$_t['5']}.{$_t['6']}{$_t['7']}{$_t['8']}-{$_t['9']}{$_t['10']}";
  if($_return==true)
  {
    return $_tmp;
  } else {
    echo $_tmp;
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Gera a máscara para o CNPJ
 * @version 0.1
 * @name mask_cnpj
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param integer $_cnpj
 * @param boolean $_return
 * @return string
 */
function mask_cnpj($_cnpj='00000000000000', $_return=false)
{
  $_t = preg_replace("/[^0-9]/", '', $_cnpj);
  $_tmp = "{$_t['0']}{$_t['1']}.{$_t['2']}{$_t['3']}{$_t['4']}.{$_t['5']}{$_t['6']}{$_t['7']}/{$_t['8']}{$_t['9']}{$_t['10']}{$_t['11']}-{$_t['12']}{$_t['13']}";
  if($_return==true)
  {
    return $_tmp;
  } else {
    echo $_tmp;
  }
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Envia cabeçalho para o navegador indicando que é do tipo JSON
 * @return bool
 * @param void
 */
function header_json()
{
  # Enviando cabeçalho
  header('Content-type: application/json');
  return true;
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Envia cabeçalho para o navegador que é do tipo XML
 * @return bool
 * @param void
 */
function header_xml() {
  
  #* Enviando$targetçalho
  header('Content-type: text/xml');
  return true;
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Escapa para se trabalhar com o mysql
 * @param $_io string
 * @param $_type String
 * @return string
 * @name sqlscape
 * @version 0.1
 */
function sqlscape($_io=false,$_type='string') {
  
  #* Verificando o que foi solicitado
  switch($_type) {
    
    #* String
    case 'string':
      $_io = addslashes($_io);
    break;
    
    #* Integer
    case 'int':
      
      #** Bibliotecas
      $String = require_lib('String', true);

      $_io = (int) $String->strtoint($_io);
    break;
  }
  
  #* Retornando
  return $_io;
  
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 */
function unscape($_io=false) {
  $_io = str_ireplace("\'","'",$_io);
  $_io = str_ireplace('\"','"',$_io);
  return $_io;
}


/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Extrai os arquivos de um arquivo ZIP
 * @param String $_source Arquivo de origem
 * @param String $_dest Diretório de destino para descompactação
 * @return Bool
 * @version 0.1
 * @name unzip
 */
function unzip($_source=false, $_dest='./') {
  if($_source!=false) {
    if(file_exists($_source)) {
      if(is_writeable($_dest)) {
        $_zip = new ZipArchive;
        $_handle = $_zip->open($_source);
        if ($_handle === true) {
          $_zip->extractTo($_dest);
          $_zip->close();
          return true;
        } else {
          return false;
        }
      } else {
        echo 'Diretório de destino não possui permissão de escrita';
        return false;
      }
    } else {
      echo 'Arquivo de origem não encontrado';
      return false;
    }
  } else {
    echo 'Informe o arquivo de origem';
    return false;
  }
}

/**
 * tarefa - phpDOC
 * how work ????
 * @author Michel Wilhelm <michelwilhelm@gmail.com>
 * @param 
 * Carrega as funções de um determinado pacote
 * @name pkg_functions_load
 * @version 0.1
 */
function pkg_functions_load($_slug=false,$_version=false) {
  if($_slug!=false && $_version != false) {
    if(file_exists(__ADMIN_ROOT__."pkg/{$_slug}-{$_version}/functions.php")) {
      require_once __ADMIN_ROOT__."pkg/{$_slug}-{$_version}/functions.php";
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

function strtagsTrim( $_target ) {
 return strip_tags(trim( $_target )); 
}