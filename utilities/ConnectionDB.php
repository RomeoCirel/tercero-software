<?php
namespace App\utilities;
use PDO;

class ConnectionDB {
    public ?PDO $pdo;


    public function __construct(
        private readonly string $host = 'localhost',
        private readonly string $dbname = 'tasks_managger',
        private readonly string $user = 'root',
        private readonly string $pass = '',
        private readonly string $charset = 'utf8mb4'
    ) {
        $this->startConnection();
    }

    public function startConnection(): void {
        if (!isset($this->pdo)) {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        }
    }

    public function getDatabaseInfo(): array {
        $this->startConnection();

        $dbName = $this->dbname;
        $tables = $this->query("SHOW TABLES");

        $key = "Tables_in_{$dbName}";
        $tableNames = array_column($tables, $key);

        return [
            'database' => $dbName,
            'tables' => $tableNames
        ];
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public function closeConnection(): void {
        $this->pdo = null;
    }

    public function query(string $sql, array $params = []): array {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function queryOne(string $sql, array $params = []): ?array {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() ?: null;
    }

    public function insert(string $sql, array $params = []): int {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $this->pdo->lastInsertId();
    }

    public function insertIntoTable(string $table, array $data): int {
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":$col", $columns);

        $sql = "INSERT INTO {$table} (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(string $table, array $data, string $where, array $whereParams = []): int {
        $setClause = implode(', ', array_map(fn($col) => "$col = :$col", array_keys($data)));
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([...$data, ...$whereParams]);
        return $stmt->rowCount();
    }

    public function delete(string $table, string $where, array $whereParams = []): int {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($whereParams);
        return $stmt->rowCount();
    }

    public function execute(string $sql, array $params = []): bool {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
