<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : 
 * FILE/ROLE : config.php
 *
 * File Last Update : 2017 08 04
 *
 * File Description :
 * -> Défini les constantes de l'application
 */

$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';

define('APP',array(
	'url-protocol'	=> $protocol,
	'url-server'	=> $_SERVER['SERVER_NAME'],
	'url-website'	=> $protocol . '://' . $_SERVER['SERVER_NAME'],
	'url-dir'		=> 'ocp-three'));