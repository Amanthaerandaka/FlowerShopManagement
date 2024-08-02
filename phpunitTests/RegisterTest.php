<?php

use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    private $pdo;
    private $register;

    protected function setUp(): void
    {
        // Create an in-memory SQLite database for testing
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Set up the schema and test data
        $this->setUpTestData();
        
        // Instantiate the Register class with the test PDO instance
        $this->register = new Register($this->pdo);
    }
    
    protected function tearDown(): void
    {
        // Clean up test data
        $this->cleanUpTestData();
    }

    private function setUpTestData()
    {
        // Create users table
        $this->pdo->exec("CREATE TABLE users (
            id INTEGER PRIMARY KEY,
            name TEXT,
            email TEXT UNIQUE,
            number TEXT UNIQUE,
            password TEXT
        )");
    }

    private function cleanUpTestData()
    {
        // Drop users table
        $this->pdo->exec("DROP TABLE users");
    }
    
    public function testRegistrationSuccess()
    {
        $result = $this->register->registerUser('John Doe', 'john@example.com', '1234567890', 'securepassword', 'securepassword');
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('success', $result);
        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('user_id', $result);
    }

    public function testRegistrationEmailExists()
    {
        $this->register->registerUser('John Doe', 'john@example.com', '1234567890', 'securepassword', 'securepassword');
        $result = $this->register->registerUser('Jane Doe', 'john@example.com', '0987654321', 'anotherpassword', 'anotherpassword');
        
        $this->assertEquals('Email or number already exists!', $result);
    }

    public function testRegistrationNumberExists()
    {
        $this->register->registerUser('John Doe', 'john@example.com', '1234567890', 'securepassword', 'securepassword');
        $result = $this->register->registerUser('Jane Doe', 'jane@example.com', '1234567890', 'anotherpassword', 'anotherpassword');
        
        $this->assertEquals('Email or number already exists!', $result);
    }

    public function testPasswordMismatch()
    {
        $result = $this->register->registerUser('John Doe', 'john@example.com', '1234567890', 'securepassword', 'differentpassword');
        
        $this->assertEquals('Confirm password does not match!', $result);
    }
}
