<?php
/**
 * helpers.php
 * Project: livetuga
 *
 * Author: Sam Kitano <samkitano@gmail.com>
 * Date: 07/12/2014
 * Time: 12:29
 */

if ( ! function_exists('ddump'))
{
	/**
	 * Dump variable and die
	 *
	 * @param $var
	 * @return void
	 */
	function ddump($var){
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
		die;
	}
}