<?php 

    $filename = __DIR__ . "/data/todos.json";

    //on vérifie les données récupé depuis l'url
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //on récupère la valeur de l'id
    $id = $_GET['id'] ?? '';

    //si l'id est true
    if($id){
        //on récupère le fichier json des todo list
        $data = file_get_contents($filename);
        //on decode le json et on récupère un tableau associatif. Si vide on récup un tableau vide
        $todos = json_decode($data, true) ?? [];
        //si dans le tableau il y a des valeurs
        if(count($todos)){
            //on recup la valeur de l'index de l'id
            $todoIndex = (int)array_search($id, array_column($todos, 'id'));
            //on inverse la valeur de l'état de la todo
            $todos[$todoIndex]['done'] = !$todos[$todoIndex]['done'];
            //on viens modifier le fichier des todo, on le repase en json
            file_put_contents($filename, json_encode($todos));
        }
    }
   
    header('Location: /');






















    //redirection
    // header('Location: http://localhost:3000/');
