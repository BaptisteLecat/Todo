<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="addTodoForm.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&display=swap" rel="stylesheet">
    <title>Formulaire Todo</title>
  </head>
  <body>
    <div class="container_form">
      <div class="header_form">
        <h1>Create your Todoux</h1>
      </div>
      <form class="form" action="index.html" method="post">
        <h3>Title</h3>
        <input type="text" class="text_input" name="todo_title" placeholder="Prendre ma douche">
        <div class="priorityStatut_container">
          <div class="priority_public">
            <div class="imgicon"></div>
            <h6>Public</h6>
          </div>
          <div class="priority_private">
            <div class="imgicon"></div>
            <h6>Private</h6>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
