<?
/**
 * Classe de Geração de Debug
 *
 * @copyright Willian Ribeiro Angelo
 * @license Open Source
 *
 * @author Willian Ribeiro Angelo <agfoccus@gmail.com>
 * @package Debug 2.0
 */


// Para usar com a classe de conexão com banco de dados
//$conexao = new Conexao('mysql');
// include DIR.'geshi.php';

// Extrair valores da sessão
extract( $_SESSION );
extract( $_COOKIE );

/*
Sistema para geração de DEBUG 2.1
 - Variaveis
 - Session
 - Get
 - Post
 - Cookie
 - MySQL Querys com Exibição da Tabela

Modo de Usar

Faça um include no código fonte no qual deseja realizar o debug
  include('includes/debug.php');

Nas partes do seu código php que deseja fazer um Debug adicione os exemplos

	$debugs[] = 'Teste com String';
	$debugs[] = $test_com_var;
	$mysqls[] = "SELECT * FROM table";

No final do Arquivo adicione está include
	include('includes/debug.php');

Obs: O include tem que ser sempre na última linha do arquivo

*/

// Cria um arquivo temporario, ou modifica ele do zero
$fp = fopen( DIR.'temp/'.$_SESSION['login'].'-debug_temp.html', 'w' );


// Pega os valores da pagina
$DEBUGS    = print_r( $debugs, TRUE );
$MYSQLS    = var_export($mysqls,TRUE);
// $MYSQLS = print_r($mysqls,TRUE);
$SESSION   = print_r( $_SESSION, TRUE );
$POST      = print_r( $_POST, TRUE );
$GET       = print_r( $_GET, TRUE );
$COOKIE    = print_r( $_COOKIE, TRUE );
$server    = $_SERVER['SERVER_NAME'];
$endereco  = $_SERVER ['REQUEST_URI'];
$RECENT    = 0;

fwrite($fp, '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Console Debug </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
	<META HTTP-EQUIV="Expires" CONTENT="-1">
	
	<!-- Compatibilidade do Chrome no Internet Explorer -->
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />

	<!-- Le styles -->
	<link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet">

	<!-- Data Table -->
	<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">

	<style type="text/css">
		body { padding-top: 60px; padding-bottom: 40px; }
	</style>

	<link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le fav and touch icons -->
	<link rel="shortcut icon" href="http://twitter.github.com/bootstrap/assets/images/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/images/apple-touch-icon-114x114.png">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


	<!-- Include jQuery Syntax Highlighter -->
	<script type="text/javascript" src="http://balupton.github.com/jquery-syntaxhighlighter/scripts/jquery.syntaxhighlighter.min.js"></script>
	<!-- Initialise jQuery Syntax Highlighter -->
	<script type="text/javascript">$.SyntaxHighlighter.init();</script>

	<!-- CodeMirror-->
	 <link rel="stylesheet" href="http://codemirror.net/lib/codemirror.css">
    <script src="http://codemirror.net/lib/codemirror.js"></script>
    <script src="http://codemirror.net/mode/sql/sql.js"></script>
    <link rel="stylesheet" href="http://codemirror.net/theme/monokai.css">

	<!-- Data table -->
	<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>

	<script src="http://twitter.github.io/bootstrap/assets/js/bootstrap-transition.js"></script>
	<script src="http://twitter.github.io/bootstrap/assets/js/bootstrap-alert.js"></script>
	<script src="http://twitter.github.io/bootstrap/assets/js/bootstrap-modal.js"></script>
	<script src="http://twitter.github.io/bootstrap/assets/js/bootstrap-dropdown.js"></script>
	<script src="http://twitter.github.io/bootstrap/assets/js/bootstrap-scrollspy.js"></script>
	<script src="http://twitter.github.io/bootstrap/assets/js/bootstrap-tab.js"></script>
	<script src="http://twitter.github.io/bootstrap/assets/js/bootstrap-tooltip.js"></script>
	<script src="http://twitter.github.io/bootstrap/assets/js/bootstrap-popover.js"></script>
	<script src="http://twitter.github.io/bootstrap/assets/js/bootstrap-button.js"></script>
	<script src="http://twitter.github.io/bootstrap/assets/js/bootstrap-collapse.js"></script>
	<script src="http://twitter.github.io/bootstrap/assets/js/bootstrap-carousel.js"></script>
	<script src="http://twitter.github.io/bootstrap/assets/js/bootstrap-typeahead.js"></script>

	<script>$(document).ready(function() {
	// Stuff to do as soon as the DOM is ready;
	// Toda as tabelas com a class table-striped serão reformatadas como Data table
		$(\'.model1\').dataTable({
			// Modelo do topo

			"sDom": "<\'row-fluid\'<\'span4\'f>t<\'span5\'T>t<\'span6\'i><\'span6\'p>>",
			// "sDom" : "<\'row-fluid\'<\'span4\'f>t<\'span3\'C>t<\'span5\'T>t<\'span6\'i><\'span6\'p>>",
			// "sDom" : "<\'row-fluid\'<\'span4\'f>t<\'span8\'T>t<\'span6\'i><\'span6\'p>>",
			"bDestroy": true,
			"bRetrieve": true,
			"bInfo": true,
			"bSort": true,
			/* 			"oLanguage": {
			"sSearch": ""
			}, */
			"bPaginate": false,

			"oTableTools": {
				"aButtons": [
					"copy",
					"print", {
					"sExtends": "collection",
					"sButtonText": \'Save <span class="caret" />\',
					"aButtons": ["xls"]
				}]
			},
			// Páginação estilo bootstrap
			"sPaginationType": "bootstrap",
			// Opções do campos

			"oColVis": {
				// "buttonText": "&nbsp;",
				"bRestore": true,
				"sAlign": "left",
				// Excluir coluna por numero
				// "aiExclude": [0, 1,2],
				// Ativar com o passar do mause
				"activate": "mouseover",
				"fnLabel": function(index, title, th) {
					return (index + 1) + \'. \' + title;
				}

			},

			"oLanguage": {
				"sLengthMenu": \'Sorting <select>\' + \'<option value="10">10</option>\' + \'<option value="15">15</option>\' + \'<option value="20">20</option>\' + \'<option value="25">25</option>\' + \'<option value="30">30</option>\' + \'<option value="35">35</option>\' + \'<option value="50">50</option>\' + \'<option value="100">100</option>\' + \'<option value="300">300</option>\' + \'<option value="-1">All</option>\' + \'</select> \'
			},
			"sPaginationType": "full_numbers"
		});

		// new FixedHeader( $(\'#example\') );
		// Modelo 2
		$(\'.model2\').dataTable({
			"sDom" : "<\'row-fluid\'<\'span3\'l><\'span3\'f>t<\'span3\'C>t<\'span2\'T>t<\'span2\'i><\'span8\'p>>",
			// "sDom": "<\'row-fluid\'<\'span3\'l><\'span3\'f>t<\'span2\'T>t<\'span2\'i><\'span8\'p>>",
			// "sDom" : "<\'row-fluid\'<\'span4\'f>t<\'span8\'T>t<\'span6\'i><\'span6\'p>>",
			"sPaginationType": "bootstrap",
			// Destroi outra tabela que tiver com o mesmo nome
			"bDestroy": true,
			// Reecria a tabela se tiver outra
			"bRetrieve": true,
			// Mostra info sobre os resultados no footer da tabela
			"bInfo": true,
			// Faz um orderby
			"bSort": true,
			// Paginacao
			"bPaginate": true,
			"bSortClasses": true,
			"bStateSave": true,
			"bAutoWidth": true,

			"oTableTools": {
				"aButtons": [
					// "copy",
					"print", {
					"sExtends": "collection",
					"sButtonText": \'Save <span class="caret" />\',
					"aButtons": ["xls"]
				}]
			},

			"aaSorting": [],
			"sPaginationType": "full_numbers",
			"oLanguage": {
				"sLengthMenu": \'Lines per Page: <select>\' + \'<option value="10">10</option>\' + \'<option value="15">15</option>\' + \'<option value="20">20</option>\' + \'<option value="25">25</option>\' + \'<option value="30">30</option>\' + \'<option value="35">35</option>\' + \'<option value="50">50</option>\' + \'<option value="100">100</option>\' + \'<option value="300">300</option>\' + \'<option value="-1">All</option>\' + \'</select> \'
			},
		});
	});</script>
</head>
<body>

	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand text-center" href="#">Console Debug</a>
				<!-- <div class="nav-collapse">
					<ul class="nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#about">About</a></li>
						<li><a href="#contact">Contact</a></li>
					</ul>
				</div> --><!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div class="container">
	<p class="text-warning">http://'.$server.$endereco.'</p>

	');
	
	// fwrite( $fp, "<h5>URL: $ios_url</h5>" );
	// fwrite( $fp, '<h5>File: http://'.$server.$endereco .'</h5>');

	fwrite($fp, '<!-- Main hero unit for a primary marketing message or call to action -->
	<ul class="nav nav-tabs" id="myTab">');

	if ( count( $debugs )>0 ) {
	  fwrite($fp, '<li><a href="#variables">Variables</a></li>');
	 }
	  if(count($_GET)>0){
	  	fwrite($fp, '<li><a href="#get">Get</a></li>');
	  }
	  
	  if(count($_POST)>0){
	  	fwrite($fp, '<li><a href="#post">Post</a></li>');
	  }
	  
	  if(count($_SESSION)>0){
	  	fwrite($fp, '<li><a href="#session">Session</a></li>');
	  }
	  
	  if(count($_COOKIE)>1){
	  	fwrite($fp, '<li><a href="#cookie">Cookie</a></li>');
	  }
	  
	  if(count($mysqls)>0){
	  	fwrite($fp, '<li><a href="#tables">Tables</a></li>');
	  }
	  fwrite($fp, '<li><a href="#mysql-console">MySQL Editor</a></li>');
 
	
 fwrite($fp, '
 	</ul>
<div class="tab-content">

	<div class="tab-pane active" id="variables">' );
		// Debugs
			if ( count( $debugs )>0 ) {
				// fwrite( $fp, '<h2>Variables Debugs - $debug[]="$var";</h2>' );
				fwrite( $fp, '<table id="table_assigned_vars"><tr class=""><td>' );
				fwrite( $fp, '<pre class="highlight">' );
				fwrite( $fp, $DEBUGS );
				fwrite( $fp, '</pre>' );
				fwrite( $fp, '</td></tr>	</table>' );
			}
	fwrite($fp, '</div>');
	
	fwrite($fp, '	<!-- GET -->');
	fwrite($fp, '	<div class="tab-pane" 		 id="get">');

			if ( count( $_GET )>0 ) {
				// fwrite( $fp, '<h2>Variables in Get - $_GET</h2>' );
				fwrite( $fp, '<table id="table_assigned_vars"><tr class=""><td>' );
				fwrite( $fp, '<pre class="highlight">' );
				fwrite( $fp, $GET );
				fwrite( $fp, '</pre>' );
				fwrite( $fp, '</td></tr></table>' );
			}

	fwrite($fp, '	</div>');
	fwrite($fp, '	<!-- POST -->');
	fwrite($fp, '	<div class="tab-pane" 		 id="post">');
		if ( count( $_POST )>0 ) {
			// fwrite( $fp, '<h2>Variables in Post - $_POST</h2>' );
			fwrite( $fp, '<table id="table_assigned_vars"><tr class=""><td>' );
			fwrite( $fp, '<pre class="highlight">' );
			fwrite( $fp, $POST );
			fwrite( $fp, '</pre>' );
			fwrite( $fp, '</td></tr></table>' );
		}
	
	fwrite($fp, '</div>');
	fwrite($fp, '<!-- SESSION -->');
	fwrite($fp, '<div class="tab-pane" 		 id="session">');
		// Session
		if ( count( $_SESSION )>0 ) {
			// fwrite( $fp, '<h2>Variables in Session - $_SESSION</h2>' );
			fwrite( $fp, '<table id="table_assigned_vars"><tr class=""><td>' );
			fwrite( $fp, '<pre class="highlight">' );
			fwrite( $fp, $SESSION );
			fwrite( $fp, '</pre>' );
			fwrite( $fp, '</td></tr></table>' );
		}
	
	fwrite( $fp, '</div>' );
	fwrite( $fp, '<!-- COOKIE -->' );
	fwrite( $fp, '<div class="tab-pane" 		 id="cookie">' );

		// COOKIE
		if ( count( $_COOKIE )>1 ) {
			// fwrite( $fp, '<h2>Variables in Cookies - $_COOKIE </h2>' );
			fwrite( $fp, '<table id="table_assigned_vars"><tr class=""><td>' );
			fwrite( $fp, '<pre class="highlight">' );
			fwrite( $fp, $COOKIE );
			fwrite( $fp, '</pre>' );
			fwrite( $fp, '</td></tr></table>' );
		}
	fwrite( $fp, '</div>' );

	fwrite($fp, '<!-- TABLES -->');
	fwrite($fp, '<div class="tab-pane" 		 id="tables">');
		// MYSQL
		if ( count( $mysqls )>0 ) {
			// fwrite( $fp, '<h2>MYSQL - Generates Debugs for Querys</h2>' );
			fwrite( $fp, '<table id="table_assigned_vars">' );
			$i=0;
			foreach ($mysqls as $key => $value) {
				$i++;
				
				fwrite( $fp, '<tr class=""><td>' );
				
				fwrite( $fp, '<div class="well">
				    <ul class="nav nav-tabs">
				      <li class="active"><a href="#sql'.$i.'" data-toggle="tab">SQL </a></li>
				      <li><a href="#sqlexecute'.$i.'" data-toggle="tab">TABLE GENERATE</a></li>
				    </ul>
				    <div id="myTabContent" class="tab-content">
				      <div class="tab-pane active in" id="sql'.$i.'"> <pre class="highlight">' );
					  fwrite( $fp, $value);		
				     fwrite( $fp, '</pre> </div>
				      <div class="tab-pane fade" id="sqlexecute'.$i.'">' );
					 fwrite( $fp, $conexao->mysql2table($value,'model2') );		
				     fwrite( $fp, '
				      </div>
				  </div>
				  </div>' );
				fwrite( $fp, '</td></tr>' );
			}
				fwrite( $fp, '</table>' );
		}
	fwrite($fp, '</div>');

	fwrite( $fp, '<!-- MYSQL EDTIOR -->' );
	fwrite( $fp, '<div class="tab-pane" 		 id="mysql-console">' );

			// fwrite( $fp, '<h2>Variables in Cookies - $_COOKIE </h2>' );
			fwrite( $fp, '<table id="table_assigned_vars"><tr class=""><td>' );
			fwrite( $fp, '

				<form class="form-horizontal">

<!-- Textarea -->
<div class="control-group">
  <label class="control-label">Query</label>
  <div class="controls">                     
    <textarea id="textarea_query" name="textarea_query">SELECT * FROM MDT_HIER_MSTR</textarea>
  </div>
</div>

<!-- Button (Double) -->
<div class="control-group">
  <label class="control-label"></label>
  <div class="controls">
    <button id="bttable" name="button1id" class="btn btn-success">MySQL to Table</button>
    <button id="btjson" name="button2id" class="btn btn-danger">MySQL to Json</button>
  </div>
</div>

</form>

<div id="resultado">
</div>
           
        ' );
			fwrite( $fp, '</td></tr></table>' );

	fwrite( $fp, '</div>' );

	fwrite($fp, '
  
</div>
 


<script>

var sql = $("#textarea_query").val();
var resultado = $("#resultado");

$("#bttable").click(function (e) {
  e.preventDefault();
  
 	$.ajax({
		  url: "debug_sql.php",
		  type: "GET",
  dataType: "html",
  data: {query: sql, modo:"mysql"},
  complete: function(xhr, textStatus) {
    //called when complete
  },
  success: function(data, textStatus, xhr) {
		    //called when successful
		    resultado.html(data);
		  },
		  error: function(xhr, textStatus, errorThrown) {
		    //called when there is an error
		  }
		});

});

	
$("#btjson").click(function (e) {
  e.preventDefault();
  
  	$.ajax({
		  url: "debug_sql.php",
		  type: "GET",
  dataType: "html",
  data: {query: sql, modo:"json"},
  complete: function(xhr, textStatus) {
    //called when complete
  },
  success: function(data, textStatus, xhr) {
		    //called when successful
		    resultado.html(data);
		  },
		  error: function(xhr, textStatus, errorThrown) {
		    //called when there is an error
		  }
		});
});



  $("#myTab a").click(function (e) {
  e.preventDefault();
  $(this).tab("show");
})
	$(".nav-tabs li a").first().click();
</script>
	
	</div> <!-- /container -->

	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	

</body>
</html>');
// Fecha o arquivo
fclose( $fp );


// Só abre o Popup para o pessoal de TI com level 9 e que estiver com a sessão debug ativada em 1
/* if ($user['debug'] ==1 || $debug = true ){
?>
<script language="javascript">window.open('<?=URL.'temp/'.$_SESSION['login']?>-debug_temp.html', 'Debug', 'WIDTH=1024, HEIGHT=600,resizable=yes,');</script>
<?
} 
<script>window.open('<?=URL.'temp/'.$_SESSION['login']?>-debug_temp.html', 'Debug', 'WIDTH=1024, HEIGHT=600,resizable=yes,');</script>

*/
?>
