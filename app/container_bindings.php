<?php

// app/container_bindings.php

use App\Core\Container;
use App\Core\DatabaseConnection;
use App\Interfaces\ExpenseRepositoryInterface;
use App\Interfaces\ExpenseServiceInterface;
use App\Repositories\ExpenseRepository;
use App\Services\ExpenseService;
use PDO;

// Get the container instance
$container = Container::getInstance();

// --- Bindings ---

// Bind the PDO connection. We create it once and return the same instance.
$container->bind(PDO::class, function() {
    return DatabaseConnection::getPDO();
});

// Bind Repositories
$container->bind(
    ExpenseRepositoryInterface::class,
    ExpenseRepository::class
);

// Bind Services
$container->bind(
    ExpenseServiceInterface::class,
    ExpenseService::class
);

// You can add other bindings for other modules here...

return $container;