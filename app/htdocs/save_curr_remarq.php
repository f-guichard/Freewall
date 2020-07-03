<?php
		include_once('inject_config.php');
		$logger->warning('Inject new commentaire to database');
		try {
			if(!isset($_GET['q']))
			{
				echo '<h2>Nan, il ne faut pas faire ça...</h2>';
				return;
			}
			$comment = $_GET['q'];
			$logger->warning("Commentaire $comment récupéré");
			$sql_query = "INSERT INTO comments(comment) VALUES (\"$comment\");";
			//$sql_query = "INSERT INTO comments(comment) VALUES('https://perdu100.com')";
			$logger->warning("Query $sql_query préparée");
			$r_sql = $freewalldb->query($sql_query);
			// Controller que l'insert est OK
			
			if(!$r_sql) {
                $logger->error("Commentaire non sauvegardé : erreur ( " . $freewalldb->errno . " ) " . $freewalldb->error);
				echo "Commentaire non sauvegardé : erreur (" . $freewalldb->errno . ") " . $freewalldb->error;
				return;
            }
			$logger->warning('Comment successfuly saved !');
		} catch (Exception $e) {
			$logger->error($e->getMessage());
			echo 'Erreur: consulter les logs';
		}
?>