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
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>TITTLE</th>
                <th>BEGIN DATE</th>
                <th>END DATE</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
         <?php foreach($tasks as $task) {
             echo "<tr>
                 <td>{$task->getId()}</td>
                 <td>{$task->getTittle()}</td>
                 <td>{$task->getBeginDate()}</td>
                 <td>{$task->getEndDate()}</td>
                 <td>
                    <a href="."edit.php?id={$task->getId()}".">E</a>
                    <a href='./delete.php'>D</a>
                 </td>
            </tr>";
         } ?>
        </tbody>
    </table>
</div>

</body>
</html>
