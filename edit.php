<?php
require_once 'utilities/ConnectionDB.php';
require_once 'Task.php';
use App\Task;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['id'])) {
        $task = Task::findById($_POST['id']);
        if ($task) {
            $task->setTitle($_POST['tittle']);
            $task->setDescription($_POST['description']);
            $task->setBeginDate($_POST['begin_date']);
            $task->setEndDate($_POST['end_date']);
            if($task->update()) {
                header('Location: /');
                exit;
            }
        }
    }
}

$id = $_GET['id'];

if ($id) {
    $task = Task::findById($id);
}

?>

<html>
<body>
    <div>
        <form action="#" method="POST" >
            <input type="hidden" name="id" value="<?php echo $task->getId() ?>">
            <input type="text" name="tittle" value="<?php echo $task->getTittle() ?>" />
            <input type="date" name="begin_date" value="<?php echo $task->getBeginDate() ?>" />
            <input type="date" name="end_date" value="<?php echo $task->getEndDate() ?>" />
            <textarea name="description"><?php echo $task->getDescription() ?></textarea>
            <button type="submit">enviar</button>
        </form>
    </div>
</body>
</html>

