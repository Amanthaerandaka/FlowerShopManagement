<?php

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $pdo;
    private $login;

    protected function setUp(): void
    {
        // Create a new in-memory SQLite database for testing
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Set up the schema and test data
        $this->setUpTestData();
        
        // Instantiate the Login class with the test PDO instance
        $this->login = new Login($this->pdo);
    }
    
    protected function tearDown(): void
    {
        // Clean up test data
        $this->cleanUpTestData();
    }

    private function setUpTestData()
    {
        // Create users table
        $this->pdo->exec("CREATE TABLE users (id INTEGER PRIMARY KEY, email TEXT, password TEXT)");

        // Insert test data
        $passwordHash = password_hash('testpassword', PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->execute(['test@example.com', $passwordHash]);
    }

    private function cleanUpTestData()
    {
        // Drop users table
        $this->pdo->exec("DROP TABLE users");
    }
    
    public function testLoginSuccess()
    {
        $userId = $this->login->loginUser('test@example.com', 'testpassword');
        $this->assertNotFalse($userId, 'Login should succeed with correct credentials.');
    }

    public function testLoginFailure()
    {
        $userId = $this->login->loginUser('wrong@example.com', 'wrongpassword');
        $this->assertFalse($userId, 'Login should fail with incorrect credentials.');
    }
}
