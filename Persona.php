<?php
namespace App;
use App\utilities\ConnectionDB;

class Persona
{
    private ?int $id = null;
    private string $nombre;
    private string $apellido;
    protected int $edad;
    private string $email;

    public string $apodo;

    public function __construct(string $nombre, string $apellido, int $edad, string $email, ?int $id = null)
    {
        $this->edad = $edad;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->id = $id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getEdad(): int
    {
        return $this->edad;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function setNombre(string $nombre): string|bool
    {
        if (strlen($nombre) < 3) {
           return false;
        }
        $this->nombre = $nombre;
        return $this->nombre;
    }

    public function guardar()
    {
        $conn = new ConnectionDB();
        $sql = "INSERT INTO personas (nombre, apellido, edad, email) VALUES (:nombre, :apellido, :edad, :email)";
        $params = [
            ':nombre' => $this->nombre,
            ':apellido' => $this->apellido,
            ':edad' => $this->edad,
            ':email' => $this->email
        ];

        if($conn->execute($sql, $params)) {
            $this->id = $conn->pdo->lastInsertId();
        }
    }

}