<?php

/**
 * @TODO phpDoc
 * @name App
 * @author Michell Wilhelm <michelwilhelm@gmail.com>
 * @version 1.0
 */
class App {

  private $_db        = false;
  private $_css_array = Array();
  private $_js_array  = Array();

  function __construct() {}

  /**
   * tarefa - phpDoc
   */
  public function setDB( $_db=false ) {
    if($_db!=false) {
      $this->_db = $_db;
      return true;
    } else {
      return false;
    }
  }

  /**
   * tarefa - phpDoc
   */
  public function getDB() {
    return $this->_db;
  }

  /**
   * tarefa - phpDoc
   */
  public function is_view( $_view=false ) {
    if( $_view==false ) {
      return false;
    } else {
      if( file_exists( $this->_path.'views/'.$_view.__VIEW_EXT__ ) ) {
        return true;
      } elseif( is_dir( $this->_path.'views/'.$_view ) ) {

      	#*** Dependências
      	$String = require_lib( 'String', true );
      	$_url   = rewrite();
      	
      	# Verificando se existe o arquivo solicitado
      	if( file_exists( $this->_path."views/{$_view}/{$_url['1']}".__VIEW_EXT__ ) ) {
        	return true;
        } elseif( file_exists( $this->_path."views/{$_view}/index".__VIEW_EXT__ ) ) {
        	return true;
        } else {
        	return false;
        }
      } else { 
        return false;
      }
    }
  }

  /**
   * tarefa - phpDoc
   */
  public function require_view( $_view=false, $_args=Array() ) {
  
    foreach( $_args as $_chave => $_valor ) {
      $$_chave = $_valor;
    }
  	//*** Verificando se a view existe
    if( $this->is_view( $_view )==false ) {
      echo "<div class=\"warning\">A view <strong>{$_view}".__VIEW_EXT__."</strong> não foi encontrada em ".$this->_path."views/</div>";
      return false;
    } else {

      if( is_dir( $this->_path.'views/'.$_view ) ) {
        //*** Dependências
        $String = require_lib( 'String', true );
        $_url   = rewrite();
        
        // Verificando se existe o arquivo solicitado
        if( file_exists( $this->_path."views/{$_view}/{$_url['1']}".__VIEW_EXT__ ) ) {

          //*** Puxando a view
          require_once( $this->_path."views/{$_view}/{$_url['1']}".__VIEW_EXT__ );
        
        } elseif( file_exists( $this->_path."views/{$_view}/index".__VIEW_EXT__ ) ) {

          //*** Puxando a view
          require_once( $this->_path."views/{$_view}/index".__VIEW_EXT__ );
        
        }
      } elseif( file_exists( $this->_path.'views/'.$_view.__VIEW_EXT__ ) ) {
      	
      	//*** Puxando o arquivo
        require_once( $this->_path.'views/'.$_view.__VIEW_EXT__ );
        
        return true;
      } else {
        return false;
      }
    }
  }


  /**
   * tarefa - phpDoc
   * Carrega todos os estilos CSS no cabeçalho da página (<head>)
   */
  public function loadCss() {
    # Ordenando por índice
    ksort( $this->_css_array );
    # Carregando...
	  foreach( $this->_css_array as $_key=>$_url ) {
      # Carrega somente se o arquivo existir
      echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$_url}\"/>\n";
    }
  }

  /**
   * tarefa - phpDoc
   * Adiciona ilimitados estilos a lista de carregamento dinamico
   *
   * @param Array $_css_array
   */
  public function addCss( $_pos, $_path=Array() ) {
    if(! isset( $_pos ) ) {
      $_pos = count($this->_css_array);
    }

    # Se for informados vários estilos ao mesmo tempo...
    if( is_array( $_path ) ) {
      # Percorrendo array informado
      foreach( $_path as $_conteudo ) {
        $this->_css_array[$_pos] = $_conteudo;
      }
    } else {
      $this->_css_array[$_pos] = $_path;
    }
  }

  /**
   * tarefa - phpDoc
   * Carrega todos os estilos CSS no cabeçalho da página (<head>)
   */
  public function loadJs( $_cache=false ) {
  	
    # Ordenando por índice
    ksort( $this->_js_array );
    if( $_cache==true ) {
      # Carregando...
  	  foreach( $this->_js_array as $_key=>$_url ) {

  	    if( preg_match( '/^[a-z]+:\/\/'.$_SERVER['SERVER_NAME'].'\//', $_url ) ) {
  	      $_js .= file_get_contents( __ROOT__.preg_replace('/^[a-z]+:\/\/'.$_SERVER['SERVER_NAME'].'\//', '', $_url ) );
  	    } elseif ( preg_match( '/^[a-z]+:/', $_url ) ) {
          $_js .= file_get_contents($_url);
  	    } elseif (! preg_match( '/^[a-z]+:/', $_url ) ) {
          $_js .= file_get_contents(__ROOT__.$_url);
  	    }
  	    $_js .= "\n\n";

        # Carrega somente se o arquivo existir
        #echo "<script type=\"text/javascript\" src=\"{$_url}\"></script>\n";
      }

      $_bytes = mb_strlen( $_js );
      $_arquivo = __ROOT__.sprintf( "data/cache/cache.%s.js", $_bytes );
      if(! file_exists( $_arquivo ) ) {
        @mkdir( __ROOT__.'data/cache/',0777 );
        $_handle = fopen( $_arquivo, 'w' );
        fwrite( $_handle, $_js );
        fclose( $_handle ); 
      }
      # Carrega somente se o arquivo existir
      echo "<script type=\"text/javascript\" src=\"/data/cache/cache.{$_bytes}.js\"></script>\n";  
    } else {
      # Carregando...
  	  foreach( $this->_js_array as $_key=>$_url ) {
        # Carrega somente se o arquivo existir
        echo "<script type=\"text/javascript\" src=\"{$_url}\"></script>\n";
      }
    }
  }

  /**
   * tarefa - phpDoc
   * Adiciona ilimitados estilos a lista de carregamento dinamico
   *
   * @param Array $_css_array
   */
  public function addJs( $_pos, $_path=Array() ){
    if(! isset($_pos) ) {
      $_pos = count($this->_js_array);
    }

    # Se for informados vários estilos ao mesmo tempo...
    if( is_array( $_path ) ) {
      # Percorrendo array informado
      foreach( $_path as $_conteudo ) {
        $this->_js_array[$_pos] = $_conteudo;
      }
    } else {
      $this->_js_array[$_pos] = $_path;
    }
  }
}