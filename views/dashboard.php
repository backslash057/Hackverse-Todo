

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Todo List App</title>
  <style><?php include_once $_SERVER["DOCUMENT_ROOT"] . "/public/css/dashboard.css" ?></style>
</head>
<body>
  <h1><span class="heading">TODO</span> List</h1>

  <div class="input-div">
    <input type="text" class="input" placeholder="What do you want to do...">
    <button class="add-button">Add</button>
  </div>

  <div class="container"></div>

  <div id="toast-container"></div>

  <script src="js/dashboard.js"></script>
</body>
</html>
