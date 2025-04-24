<?php

namespace App;

use App\utilities\ConnectionDB;
use PDO;

class Task
{
    protected null|int $id = null;
    protected string $title;
    protected string $description;
    protected string $beginDate;
    protected ?string $endDate;
    protected ?string $createdAt;

    public function __construct(
        string $title,
        string $description,
        string $beginDate,
        ?string $endDate = null,
        ?string $createdAt = null,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->beginDate = $beginDate;
        $this->endDate = $endDate;
        $this->createdAt = $createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTittle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getBeginDate(): string
    {
        return $this->beginDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function create(): void
    {
        $conn = new ConnectionDB();
        $sql = 'INSERT INTO tasks (title, description, begin_date, end_date) 
                values (:title, :description, :begin_date, :end_date)';

        $pdo  = $conn->pdo->prepare($sql);

         // opcion 1 usando bindParam
        /*
            $pdo->bindParam(':title', $this->title);
            $pdo->bindParam(':description', $this->description);
            $pdo->bindParam(':begin_date', $this->beginDate);
            $pdo->bindParam(':end_date', $this->endDate);

            $pdo->execute();
        */
        //opcion 2 usando array de paramsde forma directa en execute

        $params = [
            ':title' => $this->title,
            ':description' => $this->description,
            ':begin_date' => $this->beginDate,
            ':end_date' => $this->endDate
        ];

        if($pdo->execute($params)) {
            // en cualquiera de los 2 caso para obtener el ID
            // del registro que cabamos de insertar
            $this->id = $conn->pdo->lastInsertId();
        }

    }

    public function setTitle(string $title): bool
    {
        if (strlen($title) <3) {
            return false;
        }

        if (strlen($title) > 50) {
            return false;
        }

        $this->title = $title;
        return true;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setBeginDate(string $beginDate): void
    {
        $this->beginDate = $beginDate;
    }

    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function update(): bool
    {
        $conn = new ConnectionDB();
        $sql = 'UPDATE tasks 
                SET 
                    title = :title, 
                    description = :description, 
                    begin_date = :begin_date, 
                    end_date = :end_date
                WHERE id = :id';
        $pdo  = $conn->pdo->prepare($sql);
        $params = [
            ':title' => $this->title,
            ':description' => $this->description,
            ':begin_date' => $this->beginDate,
            ':end_date' => $this->endDate,
            ':id' => $this->id
        ];

       return $pdo->execute($params);
    }

    public static function findById(int $id): ?Task
    {
        $conn = new ConnectionDB();
        $sql = 'SELECT * FROM tasks WHERE id = :id';
        $pdo  = $conn->pdo->prepare($sql);
        $params = [
            ':id' => $id
        ];

        if($pdo->execute($params)) {
            $row = $pdo->fetch(PDO::FETCH_ASSOC);
            return new Task(
                $row['title'],
                $row['description'],
                $row['begin_date'],
                $row['end_date'],
                $row['created_at'],
                $row['id']
            );
        }

        return null;
    }


    public static function getList(){
        $conn = new ConnectionDB();
        $sql = 'SELECT * FROM tasks';
        $pdo  = $conn->pdo->prepare($sql);
        $pdo->execute();

        $tasks = $pdo->fetchAll(PDO::FETCH_ASSOC);

        if (empty($tasks)) {
            return [];
        }

        $list = [];
        foreach ($tasks as $task) {
            $list[] = new Task(
                $task['title'],
                $task['description'],
                $task['begin_date'],
                $task['end_date'],
                $task['created_at'],
                $task['id']
            );
        }
        return $list;
    }

}