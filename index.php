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
                    <input type="text">
                    <button class="btn btn-primary">Ajouter</button>  
                </form>
                <div class="todo-list"></div>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>
</html>