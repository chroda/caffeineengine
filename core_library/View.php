<?php
/**
 * @TODO phpDoc
 */
class View {

  /**
   * tarefa - phpDoc
   * Vetor que contém os arquivos CSS
   * que devem ser carregados no bootstrap
   *
   * @var array
   */
  private static $__css_array=Array();

  /**
   * tarefa - phpDoc
   * Vetor que contém os arquivos Javascript
   * que devem ser carregados no bootstrap
   * @var array
   */
  private static $__js_array=Array();

  /**
   * tarefa - phpDoc
   * Vetor que contém páginas estáticas
   * @var array
   */
  private static $__pages = Array();

  /**
   * tarefa - phpDoc
   */
  public static function setPages($_arr=false) {
    if($_arr!=false) {
      self::$__pages = $_arr;
    } else {
      return false;
    }
  }

  /**
   * tarefa - phpDoc
   */
  public static function isPage($_str=false) {
    if($_str!=false) {
      if(array_search($_str, self::$__pages)===false) {
        return false;
      } else {
        return true;
      }
    } else {
      return false;
    }
  }

  /**
   * tarefa - phpDoc
   */
  public static function getPage($_str=false) {
     if( $_str != false ) {
      foreach( self::$__pages as $_key => $_value ) {
        if( $_key == $_str ) {
          return $_value;
        }
      }
    } else {
      return false;
    }
  }

  /**
   * tarefa - phpDoc
   * Renderiza a view
   */
  public static function render( $_view ){

    // Verificando se o arquivo solicitado realmente existe
    $_file = str_replace( '/' . __TPL_EXT__, __TPL_EXT__, VIEW_PATH . $_view . __TPL_EXT__ );

    if(file_exists($_file)) {
      require_once $_file;
    } else {
      trigger_error("O a view <strong>{$_view}</strong> não foi encontrada em <strong>".VIEW_PATH."</strong>", E_USER_ERROR);
    }
  }

  /**
   * tarefa - phpDoc
   */
  //*** Verifica a existência de uma view
  public static function exists($_view){
    // Verificando se o arquivo solicitado realmente existe
    $_file = str_replace( '/' . __TPL_EXT__, __TPL_EXT__, VIEW_PATH . $_view . __TPL_EXT__ );

    if(file_exists($_file)) {
      return true;
    } else {
      return false;
    }
  }

  public static function baseLoad($_param) {
    require __ROOT__ . 'inc.'.$_param . '.php';
  }


  /**
   * tarefa - phpDoc
   *
   * Carrega todos os estilos CSS no cabeçalho da página (<head>)
   *
   * @name loadCss
   * @version 0.2
   * @return string
   * @static
   */
  public static function loadCss()
  {
    # Ordenando por índice
    ksort( self::$__css_array );
    # Carregando...
	  foreach( self::$__css_array as $_key=>$_url ) {
      # Carrega somente se o arquivo existir
      print sprintf('<link rel="stylesheet" type="text/css" href="%s"/>'."\n", $_url);
    }
  }

  /**
   * Adiciona ilimitados estilos a lista de carregamento dinamico
   *
   * @static
   * @name addCss
   * @version 0.2
   * @param Array $__css_array
   */
  public static function addCss($_pos=false, $_path=Array())
  {
    if( $_pos==false ) {
      $_pos = count(self::$__css_array);
    }

    # Se for informados vários estilos ao mesmo tempo...
    if( is_array( $_path ) ) {
      # Percorrendo array informado
      foreach($_path as $_conteudo) {
        self::$__css_array[$_pos] = $__css_arrayonteudo;
      }
    } else {
      self::$__css_array[$_pos] = $_path;
    }
    return true;
  }

  /**
   * tarefa - phpDoc
   */
  public static function loadJs($_cache=false,$_no_rel=false) {

    # Ordenando por índice
    ksort(self::$__js_array);
	if($_no_rel==false){$_rel='rel="javascript"';}else{$_rel='';}
    if($_cache==true) {
      # Carregando...
  	  foreach(self::$__js_array as $_key=>$_url)
  	  {

  	    if(preg_match('/^[a-z]+:\/\/'.__DNS__.'\//', $_url)) {
  	      $_js .= file_get_contents(__ROOT__.preg_replace('/^[a-z]+:\/\/'.__DNS__.'\//', '', $_url));
  	    } elseif(preg_match('/^[a-z]+:/', $_url)) {
          $_js .= file_get_contents($_url);
  	    } elseif(!preg_match('/^[a-z]+:/', $_url)) {
          $_js .= file_get_contents(__ROOT__.$_url);
  	    }
  	    $_js .= "\n\n";

        # Carrega somente se o arquivo existir
        #echo "<script type=\"text/javascript\" src=\"{$_url}\"></script>\n";
      }

      $_bytes = mb_strlen($_js);
      $_arquivo = sprintf(CACHE_PATH . "cache.%s.js", $_bytes);
      if(!file_exists($_arquivo)) {
        $_handle = fopen($_arquivo, 'w');
        fwrite($_handle, $_js);
        fclose($_handle);
      }
      # Carrega somente se o arquivo existir
      printf('<script type="text/javascript" rel="javascript" src="%s"></script>' . "\n", location(URL_CACHE_PATH . "cache.{$_bytes}.js", true ));
    } else {
      # Carregando...
  	  foreach(self::$__js_array as $_key=>$_url)
  	  {
        
        if(!preg_match('/^[a-z]+:/', $_url)) {
          $_url = location( $_url, true, false );
        }
        
        # Carrega somente se o arquivo existir
        printf('<script rel="javascript" type="text/javascript" src="%s"></script>' . "\n", $_url);
      }

    }

  }

  /**
   * tarefa - phpDoc
   */
  public static function addJs( $_pos=false, $_path = Array()){

    if( !isset( $_pos ) ) {
      $_pos = count(self::$__js_array);
    }

    # Se for informados vários estilos ao mesmo tempo...
    if( is_array( $_path ) ) {
      # Percorrendo array informado
      foreach($_path as $_conteudo) {
        self::$__js_array[$_pos] = $_conteudo;
      }
    } else {
      self::$__js_array[$_pos] = $_path;
    }
    return true;
  }

}