<?php

// app/container_bindings.php

use App\Core\Container;
use App\Models\Database;
use App\Interfaces\ExpenseRepositoryInterface;
use App\Interfaces\ExpenseServiceInterface;
use App\Repositories\ExpenseRepository;
use App\Services\ExpenseService;
use App\Models\Todo;
use App\Controllers\TodoController;
use App\Models\Dashboard;
use App\Repositories\DashboardRepository;
use App\Controllers\DashboardController;
use App\Models\Wishlist;
use App\Models\MarketProduct;
use App\Controllers\WishlistController;
use App\Controllers\MarketController;
use App\Models\TaxDebt;
use App\Controllers\TaxController;
use App\Models\Task;
use App\Controllers\TaskController;
use App\Models\SgkDebt;
use App\Controllers\SgkController;
use App\Models\Project;
use App\Controllers\ProjectController;
use App\Models\Profile;
use App\Controllers\ProfileController;
use App\Models\Note;
use App\Controllers\NoteController;
use App\Models\PersonalDebt;
use App\Controllers\IndividualDebtController;
use App\Models\Income;
use App\Controllers\IncomeController;
use App\Models\BankAccount;
use App\Controllers\IbanTableController;
use App\Controllers\BankAccountController;
use App\Models\Giderler;
use App\Controllers\GiderlerController;
use App\Models\ExecutionDebt;
use App\Controllers\ExecutionController;
use App\Models\DreamGoal;
use App\Controllers\DreamGoalController;
use App\Models\BankDebt;
use App\Controllers\BankController;
use App\Models\AccountCredential;
use App\Controllers\AccountPasswordController;
use App\Controllers\NeedController;
use App\Controllers\AcquiredProductController;
use App\Controllers\AccountCredentialController;


// Get the container instance
$container = Container::getInstance();

// --- Bindings ---

// Bind the Database connection to be a singleton
$container->bind(Database::class, function() {
    return Database::getInstance();
});

// Bind the PDO connection from the Database singleton
$container->bind(PDO::class, function($container) {
    return $container->get(Database::class)->getPdo();
});

// Bind Models
$container->bind(Todo::class, function($container) {
    return new Todo($container->get(PDO::class));
});

$container->bind(Dashboard::class, function($container) {
    return new Dashboard($container->get(DashboardRepository::class));
});

$container->bind(Wishlist::class, function($container) {
    return new Wishlist();
});

$container->bind(MarketProduct::class, function($container) {
    return new MarketProduct($container->get(PDO::class));
});

$container->bind(TaxDebt::class, function($container) {
    return new TaxDebt($container->get(PDO::class));
});

$container->bind(Task::class, function($container) {
    return new Task($container->get(PDO::class));
});

$container->bind(SgkDebt::class, function($container) {
    return new SgkDebt($container->get(PDO::class));
});

$container->bind(Project::class, function($container) {
    return new Project($container->get(PDO::class));
});

$container->bind(Profile::class, function($container) {
    return new Profile($container->get(PDO::class));
});

$container->bind(Note::class, function($container) {
    return new Note($container->get(PDO::class));
});

$container->bind(PersonalDebt::class, function($container) {
    return new PersonalDebt($container->get(PDO::class));
});

$container->bind(Income::class, function($container) {
    return new Income($container->get(PDO::class));
});

$container->bind(BankAccount::class, function($container) {
    return new BankAccount($container->get(PDO::class));
});

$container->bind(Giderler::class, function($container) {
    return new Giderler($container->get(PDO::class));
});

$container->bind(ExecutionDebt::class, function($container) {
    return new ExecutionDebt($container->get(PDO::class));
});

$container->bind(DreamGoal::class, function($container) {
    return new DreamGoal($container->get(PDO::class));
});

$container->bind(BankDebt::class, function($container) {
    return new BankDebt($container->get(PDO::class));
});

$container->bind(AccountCredential::class, function($container) {
    return new AccountCredential($container->get(PDO::class));
});


// Bind Repositories
$container->bind(
    ExpenseRepositoryInterface::class,
    ExpenseRepository::class
);

$container->bind(DashboardRepository::class, function($container) {
    return new DashboardRepository($container->get(Database::class));
});

// Bind Services
$container->bind(
    ExpenseServiceInterface::class,
    ExpenseService::class
);

// Bind Controllers
$container->bind(TodoController::class, function($container) {
    return new TodoController($container->get(Todo::class));
});

$container->bind(DashboardController::class, function($container) {
    return new DashboardController($container->get(Dashboard::class));
});

$container->bind(\App\Controllers\ExpenseController::class, function($container) {
    return new \App\Controllers\ExpenseController(
        $container->get(\App\Interfaces\ExpenseServiceInterface::class),
        $container->get(DashboardRepository::class)
    );
});

$container->bind(WishlistController::class, function($container) {
    return new WishlistController($container->get(Wishlist::class));
});

$container->bind(MarketController::class, function($container) {
    return new MarketController($container->get(MarketProduct::class));
});

$container->bind(\App\Controllers\XtremeAiController::class, function($container) {
    return new \App\Controllers\XtremeAiController($container->get(\App\Services\ExpenseService::class));
});

$container->bind(\App\Controllers\VariableExpenseController::class, function($container) {
    return new \App\Controllers\VariableExpenseController($container->get(\App\Services\ExpenseService::class));
});

$container->bind(\App\Controllers\PostponedPaymentController::class, function($container) {
    return new \App\Controllers\PostponedPaymentController($container->get(\App\Services\ExpenseService::class));
});

$container->bind(\App\Controllers\FixedExpenseController::class, function($container) {
    return new \App\Controllers\FixedExpenseController($container->get(\App\Services\ExpenseService::class));
});

$container->bind(\App\Controllers\ExtraExpenseController::class, function($container) {
    return new \App\Controllers\ExtraExpenseController($container->get(\App\Services\ExpenseService::class));
});

$container->bind(TaxController::class, function($container) {
    return new TaxController($container->get(TaxDebt::class));
});

$container->bind(TaskController::class, function($container) {
    return new TaskController($container->get(Task::class));
});

$container->bind(SgkController::class, function($container) {
    return new SgkController($container->get(SgkDebt::class));
});

$container->bind(ProjectController::class, function($container) {
    return new ProjectController($container->get(Project::class));
});

$container->bind(ProfileController::class, function($container) {
    return new ProfileController($container->get(Profile::class));
});

$container->bind(NoteController::class, function($container) {
    return new NoteController($container->get(Note::class));
});

$container->bind(IndividualDebtController::class, function($container) {
    return new IndividualDebtController($container->get(PersonalDebt::class));
});

$container->bind(IncomeController::class, function($container) {
    return new IncomeController($container->get(Income::class));
});

$container->bind(IbanTableController::class, function($container) {
    return new IbanTableController($container->get(BankAccount::class));
});

$container->bind(GiderlerController::class, function($container) {
    return new GiderlerController($container->get(Giderler::class));
});

$container->bind(ExecutionController::class, function($container) {
    return new ExecutionController($container->get(ExecutionDebt::class));
});

$container->bind(DreamGoalController::class, function($container) {
    return new DreamGoalController($container->get(DreamGoal::class));
});

$container->bind(BankController::class, function($container) {
    return new BankController($container->get(BankDebt::class));
});

$container->bind(BankAccountController::class, function($container) {
    return new BankAccountController($container->get(BankAccount::class));
});

$container->bind(AccountPasswordController::class, function($container) {
    return new AccountPasswordController($container->get(AccountCredential::class));
});

$container->bind(AccountCredentialController::class, function($container) {
    return new AccountCredentialController(
        $container->get(AccountCredential::class)
    );
});

$container->bind(NeedController::class, function($container) {
    return new NeedController($container->get(Wishlist::class));
});

$container->bind(AcquiredProductController::class, function($container) {
    return new AcquiredProductController($container->get(Wishlist::class));
});

$container->bind(ReportController::class, function($container) {
    return new ReportController(
        $container->get(PersonalDebt::class),
        $container->get(BankAccount::class),
        $container->get(ExpenseService::class),
        $container->get(Income::class),
        $container->get(Wishlist::class)
    );
});


// You can add other bindings for other modules here...

return $container;