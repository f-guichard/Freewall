<?php
	include('inject_config.php');
	$logger->warning('Creating new comments table');
    header("Content-Type: text/html ; charset=utf-8");
	header("Cache-Control: no-cache , private");
	header("Pragma: no-cache");
    try {
        //$freewalldb->query("SET NAMES 'utf8'");
        $sql_query = "SELECT distinct(comment) from comments ORDER BY id DESC LIMIT 10";
        $logger->warning("Query $sql_query préparée");
        $r_sql = $freewalldb->query($sql_query);
        //var_dump($r_sql);
        //Contrôler qu'on a au moins 1 ligne à afficher
        if(!$r_sql || $r_sql->num_rows <= 0) {
            $logger->error("Pas de commentaire en base : erreur ( " . $freewalldb->errno . " ) " . $freewalldb->error);
            echo "Pas de commentaire en base : erreur (" . $freewalldb->errno . ") " . $freewalldb->error;
            return;
        }
        //On est bon -> on constuit le html de retour
        echo "<table>";
        while ($comment = $r_sql->fetch_assoc()) {
            echo "<tr><td>".$comment["comment"]."</td></tr>";
        }
        echo "</table>";
        $logger->warning('Comment successfuly sent !');
        return;
    } catch (Exception $e) {
        $logger->error($e->getMessage());
        echo 'Erreur: consulter les logs';
    }
?>