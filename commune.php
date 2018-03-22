<?php
class AutoCompletionCPVille {
	public $CodePostal;
	public $Ville;
}


//Initialisation de la liste
$list = array();

//Connexion MySQL
$dsn = 'mysql:dbname=javascript;host=localhost:3308';
$user = 'root';
$password = '';

try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}
//Construction de la requete
$strQuery = "SELECT DISTINCT VILLE Ville FROM cp_autocomplete WHERE ";
if (isset($_GET["commune"]))
{
    $strQuery .= "VILLE LIKE :ville ";
}
//Limite
if (isset($_GET["maxRows"]))
{
    $strQuery .= "LIMIT 0, :maxRows";
}
var_dump($db);
$query = $db->prepare($strQuery);
if (isset($_GET["commune"]))

{
    $value = $_GET["commune"]."%";
    $query->bindParam(":ville", $value, PDO::PARAM_STR);
}

//Limite
if (isset($_GET["maxRows"]))
{
    $valueRows = intval($_GET["maxRows"]);
    $query->bindParam(":maxRows", $valueRows, PDO::PARAM_INT);
}

$query->execute();

$list = $query->fetchAll(PDO::FETCH_CLASS, "AutoCompletionCPVille");;

echo json_encode($list);
?>
