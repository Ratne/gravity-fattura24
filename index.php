<?php
/**
 * Main plugin file
 *
 */

/**
Plugin Name: Gravity Forms - Fattura24
Description: Interfaccia fattura24 con un form di gravityform per generare automaticamente la fattura dal tuo account.
Author: 
Version: 0.1
 */
require_once( 'titan-framework-checker.php' );


add_action( 'tf_create_options', 'my_theme_create_options' );
function my_theme_create_options() {

	$titan = TitanFramework::getInstance( 'gravity-fattura24' );
	
	$panel = $titan->createAdminPanel( array(
	'name' => 'Gravity Forms to Fattura24',
	) );	

	$panel->createOption( array(
	'type' => 'heading',
	'name' => '<p>Inserire l\'API KEY rilasciata da Fattura24</p>',
	) );	
	
	$panel->createOption( array(
	'name' => 'API KEY',
	'id' => 'id_api_key',
	'type' => 'text',	
	) );		
	
	
	$panel->createOption( array(
	'type' => 'heading',
	'name' => '<p>Inserire in ogni campo il valore dell\'id del campo del form, es. 60 oppure 20.3</p>',
	) );
	
	$panel->createOption( array(
	'name' => 'ID campo form Nome',
	'id' => 'id_nome',
	'type' => 'text',
	
	) );	
	$panel->createOption( array(
	'name' => 'ID campo form Cognome',
	'id' => 'id_cognome',
	'type' => 'text',
	
	) );	
	
	$panel->createOption( array(
	'name' => 'ID campo form Ragione Sociale',
	'id' => 'id_ragione_sociale',
	'type' => 'text',
	
	) );	
	$panel->createOption( array(
	'name' => 'ID campo form Partita Iva',
	'id' => 'id_p_iva',
	'type' => 'text',
	
	) );	
	$panel->createOption( array(
	'name' => 'ID campo form Codice Fiscale',
	'id' => 'id_cod_fisc',
	'type' => 'text',
	
	) );		
	$panel->createOption( array(
	'name' => 'ID campo form Indirizzo',
	'id' => 'id_indirizzo',
	'type' => 'text',
	
	) );	
	$panel->createOption( array(
	'name' => 'ID campo form CAP',
	'id' => 'id_cap',
	'type' => 'text',
	
	) );	
	$panel->createOption( array(
	'name' => 'ID campo form Mail',
	'id' => 'id_mail',
	'type' => 'text',
	
	) );	
	$panel->createOption( array(
	'name' => 'ID campo form Telefono',
	'id' => 'id_telefono',
	'type' => 'text',
	
	) );	
	$panel->createOption( array(
	'name' => 'ID campo form Città',
	'id' => 'id_citta',
	'type' => 'text',
	
	) );	
	$panel->createOption( array(
	'name' => 'ID campo form Provincia',
	'id' => 'id_provincia',
	'type' => 'text',	
	) );	
	$panel->createOption( array(
	'name' => 'ID campo form Totale Importo',
	'id' => 'id_totale',
	'type' => 'text',	
	) );		

	$panel->createOption( array(
	'type' => 'save'
	) );
	
}
require_once('fattura24.php');
?>