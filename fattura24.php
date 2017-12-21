<?php

require __DIR__ . '/vendor/autoload.php';

use \Curl\Curl;

function dump(&$var, $info = FALSE)
{
	$scope = false;
	$prefix = 'unique';
	$suffix = 'value';
 
	if($scope) $vals = $scope;
	else $vals = $GLOBALS;

	$old = $var;
	$var = $new = $prefix.rand().$suffix; $vname = FALSE;
	foreach($vals as $key => $val) if($val === $new) $vname = $key;
	$var = $old;	

	echo "<pre style='margin: 0px 0px 10px 0px; display: block; background: white; color: black; font-family: Verdana; border: 1px solid #cccccc; padding: 5px; font-size: 10px; line-height: 13px;'>";
	if($info != FALSE) echo "<b style='color: red;'>$info:</b><br>";
	do_dump($var, '$'.$vname);
	echo "</pre>";
}

////////////////////////////////////////////////////////
// Function:         do_dump
// Inspired from:     PHP.net Contributions
// Description: Better GI than print_r or var_dump

function do_dump(&$var, $var_name = NULL, $indent = NULL, $reference = NULL)
{
	$do_dump_indent = "<span style='color:#eeeeee;'>|</span> &nbsp;&nbsp; ";
	$reference = $reference.$var_name;
	$keyvar = 'the_do_dump_recursion_protection_scheme'; $keyname = 'referenced_object_name';

	if (is_array($var) && isset($var[$keyvar]))
	{
		$real_var = &$var[$keyvar];
		$real_name = &$var[$keyname];
		$type = ucfirst(gettype($real_var));
		echo "$indent$var_name <span style='color:#a2a2a2'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br>";
	}
	else
	{
		$var = array($keyvar => $var, $keyname => $reference);
		$avar = &$var[$keyvar];
   
		$type = ucfirst(gettype($avar));
		if($type == "String") $type_color = "<span style='color:green'>";
		elseif($type == "Integer") $type_color = "<span style='color:red'>";
		elseif($type == "Double"){ $type_color = "<span style='color:#0099c5'>"; $type = "Float"; }
		elseif($type == "Boolean") $type_color = "<span style='color:#92008d'>";
		elseif($type == "NULL") $type_color = "<span style='color:black'>";
   
		if(is_array($avar))
		{
			$count = count($avar);
			echo "$indent" . ($var_name ? "$var_name => ":"") . "<span style='color:#a2a2a2'>$type ($count)</span><br>$indent(<br>";
			$keys = array_keys($avar);
			foreach($keys as $name)
			{
				$value = &$avar[$name];
				do_dump($value, "['$name']", $indent.$do_dump_indent, $reference);
			}
			echo "$indent)<br>";
		}
		elseif(is_object($avar))
		{
			echo "$indent$var_name <span style='color:#a2a2a2'>$type</span><br>$indent(<br>";
			foreach($avar as $name=>$value) do_dump($value, "$name", $indent.$do_dump_indent, $reference);
			echo "$indent)<br>";
		}
		elseif(is_int($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
		elseif(is_string($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color\"$avar\"</span><br>";
		elseif(is_float($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
		elseif(is_bool($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color".($avar == 1 ? "TRUE":"FALSE")."</span><br>";
		elseif(is_null($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> {$type_color}NULL</span><br>";
		else echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $avar<br>";

		$var = $var[$keyvar];
	}
}

add_action( 'gform_after_submission', 'post_to_third_party', 10, 2 );
function post_to_third_party( $entry, $form ) 
{
 


}

function create_fattura24($entry, $action) {
    if ($action['type']=="complete_payment")
	{
		$titan = TitanFramework::getInstance( 'gravity-fattura24' );
		$api_key = $titan->getOption( 'id_api_key' );
	 
		$curl = new Curl();
		$curl->post('https://www.app.fattura24.com/api/v0.3/TestKey', array(
		'apiKey' => $api_key,    
		));
		
		//dump($curl);
		

		if ($curl->httpStatusCode==200)
		{
			//echo "<br>autenticazione ok";
			
			/*
		   for ($i=1;$i<=200;$i++)
		   {
				if (rgar( $entry, $i )!="")
				{
					echo "<br>".$i.") ".rgar( $entry, $i );   
				}
					
				for ($s=1;$s<=10;$s++)
				{
					if (rgar( $entry, $i.".".$s )!="")
					{
						echo "<br>".$i.".".$s.") ".rgar( $entry, $i.".".$s );   	
					}			
				}
		   }
		   */
		   
			$nome=rgar( $entry, $titan->getOption( 'id_nome' ));
			$cognome=rgar( $entry, $titan->getOption( 'id_cognome' ));
			$ragione_sociale=rgar( $entry, $titan->getOption( 'id_ragione_sociale' ));
			$p_iva=rgar( $entry, $titan->getOption( 'id_p_iva' ));
			$indirizzo=rgar( $entry, $titan->getOption( 'id_indirizzo' ));
			$cap=rgar( $entry, $titan->getOption( 'id_cap' ));
			$mail=rgar( $entry, $titan->getOption( 'id_mail' ));
			$telefono=rgar( $entry, $titan->getOption( 'id_telefono' ));
			$totale=rgar( $entry, $titan->getOption( 'id_totale' ));
			$cod_fisc=rgar( $entry, $titan->getOption( 'id_cod_fisc' ));
			$citta=rgar( $entry, $titan->getOption( 'id_citta' ));
			$provincia=rgar( $entry, $titan->getOption( 'id_provincia' ));
			
			$netto=$totale/1.22;
			$iva=$totale-$netto;
			
			if ($ragione_sociale!="")
			{
				$nominativo=$ragione_sociale;
			}
			else
			{
				$nominativo=$nome." ".$cognome;
			}
		   
			$customerData = array(
				'Name'      => $nominativo,
				'Email'     => $mail,
				'FiscalCode'      => $cod_fisc,
				'VatCode'      => $p_iva,
				'Address'      => $indirizzo,
				'Postcode'      => $cap,
				'City'      => $citta,
				'Country'      => 'Italia',		
				'Province'      => $provincia,	
				'CellPhone'		=> $telefono,
			);   
			
			$transaction_id="";
			if (isset($action))
			{
				$transaction_id=$action['transaction_id'];	
			}
			
			
			//dump($customerData);

		   
			$xml = new \XMLWriter();
			$filename=uniqid().".xml";
			$xml->openURI(__DIR__ .'/xml/'.$filename);

			$xml->startDocument('1.0', 'UTF-8');
			$xml->setIndent(2);
			$xml->startElement('Fattura24');
				$xml->startElement('Document');
				


					foreach($customerData as $k => $v)
					{
						$xml->writeElement('Customer'.$k, $v);
					}			

				$xml->endElement(); // Document
				
			$xml->endElement(); // Fattura24
			$xml->endDocument();
			$xml->flush();
			
			$data=file_get_contents(__DIR__ .'/xml/'.$filename);   
			
			$curl = new Curl();
			$curl->post('https://www.app.fattura24.com/api/v0.3/SaveCustomer', array(
				'apiKey' => $api_key, 
				'xml' => $data
			));
			
			//dump($curl);	
		   
			$percorso=__DIR__ .'/xml/'.$filename;
			unlink($percorso);
			
		/*creazione fattura*/

			$xml = new \XMLWriter();
			$filename_doc=uniqid().".xml";
			$xml->openURI(__DIR__ .'/xml/'.$filename_doc);

			$xml->startDocument('1.0', 'UTF-8');
			$xml->setIndent(2);
			$xml->startElement('Fattura24');
				
				$xml->startElement('Document');
				
				$xml->writeElement('DocumentType','I-force');
				$xml->writeElement('SendEmail', 'true');		
				$xml->writeElement('IdTemplate', '5163');		
				$xml->writeElement('Object', 'servizio intermediazione disbrigo pratica');
				
				foreach($customerData as $k => $v)
				{
				$xml->writeElement('Customer'.$k, $v);	
				}
				
				
				$xml->writeElement('PaymentMethodName', 'Rimessa Diretta');
				$xml->writeElement('PaymentMethodDescription', $transaction_id);
					
				$xml->writeElement('TotalWithoutTax', number_format($netto,2,".",""));
				$xml->writeElement('VatAmount', number_format($iva,2,".",""));
				$xml->writeElement('Total', number_format($totale,2,".",""));		

				$xml->startElement('Payments');
					$xml->startElement('Payment');
						$xml->writeElement('Date', date('Y-m-d'));

						$xml->writeElement('Amount',number_format($totale,2,".",""));		
						$xml->writeElement('Paid', 'true');
					$xml->endElement(); // Payment
				$xml->endElement(); // Payments		
				
					$xml->startElement('Rows');
						$xml->startElement('Row');
							$xml->writeElement('Description', 'descrizione');

							$xml->writeElement('Qty', 1);
							$xml->writeElement('Price', number_format($netto,2,".",""));
							$xml->writeElement('VatCode', 22);
							$xml->writeElement('Code', '');			
					
						$xml->endElement(); // Row
					$xml->endElement(); // Rows
				$xml->endElement(); // Fattura24
			$xml->endDocument();
			$xml->flush();	
			
			$data=file_get_contents(__DIR__ .'/xml/'.$filename_doc);   	
			
			
			$curl = new Curl();
			$curl->post('https://www.app.fattura24.com/api/v0.3/SaveDocument', array(
				'apiKey' => $api_key, 
				'xml' => $data
			));
			
			//dump($curl);
			//dump($curl->response);
			
			$percorso_doc=__DIR__ .'/xml/'.$filename_doc;
			unlink($percorso_doc);		

			
			
			
			$risposta = @simplexml_load_string($curl->response);
			
			//dump($risposta);
			
			$docid=strval($risposta->docId);
			
			//dump($docid);
			
			$docnumber=$risposta->docNumber;
			
			$curl = new Curl();
			$curl->post('https://www.app.fattura24.com/api/v0.3/GetFile', array(
				'apiKey' => $api_key, 
				'docId' => $docid
			));		
			
			//dump($curl);
			//dump($curl->response);
			
			$nomefilefatt=uniqid().".pdf";
			
			file_put_contents(__DIR__ .'/pdf/'.$nomefilefatt, $curl->response);

			
			
			
			//die();
			
		}			
	}
	return;
}
add_action( 'gform_post_payment_completed', 'create_fattura24', 10, 2 );


?>