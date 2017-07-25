<?php

/**
 * Hash d'un mot de passe
 */
function get_hash($text) {
	return hash('sha256', 'b!:' . $text . '/?e9');
}