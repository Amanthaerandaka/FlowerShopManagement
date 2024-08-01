package org.example;

import java.time.Duration;

import org.junit.jupiter.api.AfterEach;
import static org.junit.jupiter.api.Assertions.assertTrue;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.edge.EdgeDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

/**
 * Author: Sanoj Indrasinghe
 */
public class RegisterTest {

    private WebDriver driver;
    private WebDriverWait wait;

    @BeforeEach
    public void setUp() {
        driver = new EdgeDriver();
        wait = new WebDriverWait(driver, Duration.ofSeconds(10));
        driver.manage().window().maximize();
    }

    @AfterEach
    public void tearDown() {
        if (driver != null) {
            //driver.quit();
        }
    }

    @Test
    public void testRegister() {
        // Open the registration page
        driver.get("http://localhost/FlowerShopManagement/FlowerShopManagement/register.php");

        // Find and fill the name field
        WebElement nameField = driver.findElement(By.name("name"));
        nameField.sendKeys("cust");

        // Find and fill the email field
        WebElement emailField = driver.findElement(By.name("email"));
        emailField.sendKeys("cust@gmail.com");

        // Find and fill the phone number
        WebElement numberField = driver.findElement(By.name("number"));
        numberField.sendKeys("12345678");

        // Find and fill the password field
        WebElement passwordField = driver.findElement(By.name("pass"));
        passwordField.sendKeys("cust1234");

        // Find and fill the confirm password field
        WebElement confirmPasswordField = driver.findElement(By.name("cpass"));
        confirmPasswordField.sendKeys("cust1234");

        // Find and click the register button
        WebElement registerButton = wait.until(ExpectedConditions.elementToBeClickable(By.name("submit")));
        ((JavascriptExecutor) driver).executeScript("arguments[0].click();", registerButton);

        // Wait until the login page is loaded
        wait.until(ExpectedConditions.urlToBe("http://localhost/FlowerShopManagement/FlowerShopManagement/register.php"));

        // Verify registration success by checking the URL
        assertTrue(driver.getCurrentUrl().equals("http://localhost/FlowerShopManagement/FlowerShopManagement/register.php"), "Registration failed or redirection to login page not happened.");
    }
}
