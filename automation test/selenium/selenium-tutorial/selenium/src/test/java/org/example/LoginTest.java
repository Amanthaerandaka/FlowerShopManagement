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
 * @author Sanoj Indrasinghe
 */
public class LoginTest { 
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
    public void testLogin() {
        // Open the login page
        driver.get("http://localhost/FlowerShopManagement/FlowerShopManagement/login.php");

        // Find and fill the email field
        WebElement emailField = driver.findElement(By.name("email"));
        emailField.sendKeys("test@gmail.com");

        // Find and fill the password field
        WebElement passwordField = driver.findElement(By.name("pass"));
        passwordField.sendKeys("test1234");

        // Find and click the login button
        WebElement loginButton = wait.until(ExpectedConditions.elementToBeClickable(By.name("submit")));
        ((JavascriptExecutor) driver).executeScript("arguments[0].click();", loginButton);

        // Wait until the landing page is loaded (assuming "home.php" for regular users)
        wait.until(ExpectedConditions.urlToBe("http://localhost/FlowerShopManagement/FlowerShopManagement/login.php"));

        // Verify login success by checking if a specific element on the landing page is displayed
        WebElement userWelcomeMessage = driver.findElement(By.xpath("//h3[contains(text(),'Welcome')]"));
        assertTrue(userWelcomeMessage.isDisplayed(), "Login failed or welcome message not found.");
    }
}
