// Unit test for handling a request with no segments

// Arrange
$_SERVER['REQUEST_URI'] = '/'; // Simulate a request with no segments

// Act
ob_start(); // Start output buffering to capture the echoed response
require_once 'index.php'; // Include the main routing script
$output = ob_get_clean(); // Get the captured output

// Assert
$this->assertEquals('DashboardController', $controller_name); // Assert the default controller
$this->assertEquals('index', $method_name); // Assert the default method
$this->assertEquals('', $output); // Assert no output (404 messages)