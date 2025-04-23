<?php
namespace App;

require_once 'utilities/ConnectionDB.php';
require_once 'Persona.php';
require_once 'Task.php';

 use App\Persona;
 use App\utilities\ConnectionDB;
 use App\Task;
 if($_SERVER['REQUEST_METHOD'] == 'POST') {
     $tittle = $_POST['tittle'];
     $description = $_POST['description'];
     $beginDate = $_POST['begin_date'];
     $endDate = $_POST['end_date'];

     $task = new Task(
         $tittle,
         $description,
         $beginDate,
         $endDate,
     );


    $task->create();
}

 $tasks = Task::getList();
?>
<html>
<body>
 <form action="#" method="POST" >
     <input type="text" name="tittle" />
     <input type="date" name="begin_date" />
     <input type="date" name="end_date" />
     <textarea name="description" ></textarea>

     <button type="submit">enviar</button>

 </form>

<div>
    <ul>
        <?php foreach($tasks as $task) {
            echo "<li>".$task->getTitle()."</li>";
        } ?>
    </ul>
</div>
</body>
</html>
