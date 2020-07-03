<?php
    require 'vendor/autoload.php';
    $inject_cfg = false;
    $hostname = 'phenix';
    if(isset($_ENV['HOSTNAME']))
    {
        $hostname .= '-'.$_ENV['HOSTNAME'];
    }
    $log_filename = '/tmp/'.$hostname.'.log';
    $logger = new Monolog\Logger('freewall.'.$hostname);

    $stream = new Monolog\Handler\StreamHandler('php://stdout', Monolog\Logger::WARNING, $bubble = true);
    $json_formatter = new Monolog\Formatter\JsonFormatter();
    $stream->setFormatter($json_formatter);

    $logger->pushHandler($stream);
    
    $logger->pushHandler(new Monolog\Handler\StreamHandler($log_filename, Monolog\Logger::WARNING));

    try {
        $configFile = "configuration/k8s-osbcmdb-db-config.json";
        if(file_exists($configFile) && ($confDescriptor = fopen($configFile, 'r')))
        {
            $conf = json_decode(fread($confDescriptor, filesize($configFile)));
            $logger->warning('Chargement de la configuration de la base de données '.$conf->database->name.' OK');
        } else {
            echo "<br>Aucune configuration valide detectee dans ".$configFile;
        }
    } catch (Exception $e) {
        $logger->error($e->getMessage());
        echo '<br>Exception : consulter '.$log_filename;
    }
    if($conf)
    {
        try
        {
            $logger->warning("Création du pool MySQLi...");
            $host = $conf->{'database'}->{'server'};
            $port = $conf->{'database'}->{'port'};
            $user = $conf->{'database'}->{'username'};
            $pass = $conf->{'database'}->{'password'};
            $dbne = $conf->{'database'}->{'db_name'};
            $log_cfg = "mysqli:".$user.":xxxxxx@".$host.":".$port."/".$dbne;
            $logger->warning("Configuration courante du pool : ".$log_cfg);
            $freewalldb = new mysqli($host, $user, $pass, $dbne, $port);
            if ($freewalldb->connect_errno) {
                $logger->error(" ( " . $freewalldb->connect_errno . " ) " . $freewalldb->connect_error);
                echo "Erreur : (" . $freewalldb->connect_errno . ") " . $freewalldb->connect_error;
            }
            $freewalldb->set_charset("utf8");
        }
        catch(Exception $e)
        {
            $logger->error($e->getMessage());
        }
    } else {
        echo "<br>Impossible de configurer l'accès à la base de donnees : aucune bdd disponible";
        exit;
    }  
    $inject_cfg = true;
?>
