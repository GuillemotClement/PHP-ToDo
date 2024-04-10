<?php 

//Déclaration des cas d'erreur
const ERROR_REQUIRED = "Veuillez saisir une todo";
const ERROR_MIN_LENGTH = "Saisir 5 caractères minimum";
//on utilise un seul champ, donc on utilise pas de tableau
$error = '';

//déclaration du nom d'un fichier
$filename = __DIR__ . "/data/todos.json";

//initialisation de la varaible avec tableau vide
$todos = [];


//on vérfiie que le fichier des todo existe
if(file_exists($filename)){
    //on recup les données présente dans le fichier
    $data = file_get_contents($filename);
    //on convertis le JSON en tableau assocatif
    //dans le cas ou il n'y a pas de donnée, on récupère un tableau vide
    $todos = json_decode($data, true) ?? [];
}

//on vérifie qu'on est bien en POST
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //on vient nettoyer les données reçus
    $_POST = filter_input_array(INPUT_POST, [
        "todo" => [
            "filter" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            //les flag permet d'activer l'encodage des caractères accentuer
            "flags" => FILTER_FLAG_NO_ENCODE_QUOTES | FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_BACKTICK
        ]
        ]);
    //on vérifie qu'on est bien une valeur 
    $todo = $_POST['todo'] ?? '';
    //verif des valeurs
    //on vérifie que la valeur existe
    if(!$todo){
        $error = ERROR_REQUIRED;
    }elseif(mb_strlen($todo) < 5){
        $error = ERROR_MIN_LENGTH;
    }

    //on vérifie qu'il n'y a pas d'erreur
    if(!$error){
        //on recup les donnes du tableau todo
        $todos = [...$todos, [
            'name' => $todo,
            'done' => false,
            'id' => time()
        ]];
        //on sauvegarde les nouvelle données dans le fichier en format json
        file_put_contents($filename, json_encode($todos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}   

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once 'includes/head.php' ?>
    <title>ToDo</title>
</head>
<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="todo">
                <h1>Ma Todo</h1>
                <form class="todo-form" action="/" method="POST">
                    <input type="text" name="todo">
                    <button class="btn btn-primary">Ajouter</button>  
                </form>
                <?php if($error): ?>
                    <p class="text-danger"><?= $error ?></p>
                <?php endif; ?>
                <ul class="todo-list">
                    <?php foreach($todos as $todo): ?>
                        <li class="todo-list-element">
                            <span class="todo-list-element-name"><?= $todo['name'] ?></span>
                            <button class="btn btn-small btn-success">Valider</button>
                            <button class="btn btn-small btn-danger">Supprimer</button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>
</html>