<?php
require_once "Task.php";
use App\Task;

if (!isset($_GET['id'])) {
    // lanzar error o redirigir
}
$id = intval($_GET['id']);

$task = Task::findById($id);

if ($task) {

   if($task->delete()){
       header("Location: index.php");
       exit;
   }

   echo "error al intentar eliminar la tarea {$task->getDescription()}";
}

echo "No se encontro ninguna tarea con el id: {$id}";
