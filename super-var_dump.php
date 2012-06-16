<?php
function super_var_dump($var) {
	super_var_dump::init($var);
}

class super_var_dump {
	
	private static $instance;
	private static $current_depth;
	static function init($a) {
		// var_dump(self::$instance);
		error_reporting(-1);
		ini_set('display_errors', 1); 
		if ( empty(self::$instance) || ! self::$instance )
			self::$instance = 1;
		else
			self::$instance++;
		if ( empty(self::$current_depth) || ! self::$current_depth ) {
			self::$current_depth = 1; ?>
			<script type="text/javascript">
				function super_var_dump_toggle_div_display(instance, depth) {
					var div = document.getElementById( 'super-var-dump-container-' + instance + '-' + depth );
					var span = document.getElementById( 'super-var-dump-arrow-' + instance + '-' + depth );
					if ( div.style.display == 'none' ) {
						div.style.display = 'block';
						span.innerHTML = ' v ';
					}
					else {
						div.style.display = 'none';
						span.innerHTML = ' > ';
					}
					window.getSelection().removeAllRanges();
				}
			</script>
			<?php 
			echo '<pre style="font: 9pt Lucida Console; overflow: auto; background-color: #FCF7EC; overflow-x: auto; white-space: pre-wrap; white-space: -moz-pre-wrap !important; word-wrap: break-word; white-space: normal;">';
		} else
			self::$current_depth++;

		self::select_variable_type($a);

		self::$current_depth--;
		if ( ! self::$current_depth )
			echo '</PRE>';		
	}

	static function select_variable_type($a) {
		if ( is_object($a) )
			self::output_object($a);
		else if ( is_array($a) )
			self::output_array($a);
		else if ( is_numeric($a) )
			self::output_numeric($a);
		else if ( is_string($a) )
			self::output_string($a);
		else if ( is_bool($a) )
			self::output_bool($a);
		else if ( is_null($a) )
			self::output_null($a);

	}
	static function output_object($a) {
		$object_vars = get_object_vars($a);
		echo '<div style="padding-left:10px" id="super-var-dump-' . self::$instance . '">';
		echo '<span id="super-var-dump-arrow-' .  self::$instance . '-' . self::$current_depth . '" style="cursor: pointer" onclick="super_var_dump_toggle_div_display(' . self::$instance . ', ' . self::$current_depth . ')"> > </span>Object';
		echo '<div id="super-var-dump-container-' .  self::$instance . '-' . self::$current_depth . '" style="display:none; padding-left: 10px">';
		echo '{';
		echo '<div style="padding-left: 10px">';
		foreach ( $object_vars as $object_var_key => $object_var_value ) {
			echo $object_var_key . ' => ';
			self::init($a->$object_var_key);
			echo "\r";
		}
		echo '</div>';
		echo '}';

		echo '</div>';
		echo '</div>';
	}
	static function output_array($a) {
		echo '<div style="padding-left:10px" id="super-var-dump-' . self::$instance . '">';
		echo '<span id="super-var-dump-arrow-' .  self::$instance . '-' . self::$current_depth . '" style="cursor: pointer" onclick="super_var_dump_toggle_div_display(' . self::$instance . ', ' . self::$current_depth . ')"> > </span>array';
			echo '<div id="super-var-dump-container-' .  self::$instance . '-' . self::$current_depth . '" style="display:none; padding-left: 10px">';
			echo '{';
		$keys = array_keys($a);
		foreach($keys as $key) {
			echo '<div style="padding-left:5px">';
			echo "['" . $key  . "'] => ";
			super_var_dump($a[$key]);
			echo '</div>';
		}
		echo '}';
		echo '</div>';
		echo '</div>';
	}
	static function output_numeric($a) {
		echo $a;
		echo "<BR>";
	}
	static function output_string($a) {
		if ( ! $a ) echo '""';
		else echo $a;
		echo '<BR>';
	}
	static function output_bool($a) {
		if ( $a ) echo 'true';
		else echo 'false';
		echo '<BR>';
	}
	static function output_null($a) {
		echo 'NULL';
	}
}
?>