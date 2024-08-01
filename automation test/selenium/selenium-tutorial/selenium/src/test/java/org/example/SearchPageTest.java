package org.example;

import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.edge.EdgeDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;
import java.util.List;

import static org.junit.jupiter.api.Assertions.assertTrue;
import static org.junit.jupiter.api.Assertions.assertFalse;

/**
 * Author: Sanoj Indrasinghe
 */
public class SearchPageTest {

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
    public void testSearchFunctionality() {
        // Open the search page
        driver.get("http://localhost/api-flora/search_page.php");

        // Find and fill the email field
        WebElement emailField = driver.findElement(By.name("email"));
        emailField.sendKeys("para@gmail.com");

        // Find and fill the password field
        WebElement passwordField = driver.findElement(By.name("pass"));
        passwordField.sendKeys("123");

        // Find and click the login button
        WebElement loginButton = driver.findElement(By.name("submit"));
        loginButton.click();

        // Perform a search
        WebElement searchBox = driver.findElement(By.name("search_btn"));
        searchBox.sendKeys("Twilight Bloom");

        WebElement searchButton = driver.findElement(By.name("search_btn"));
        searchButton.click();

        // Wait for search results to be displayed
        wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("product_container")));

        // Verify that products are displayed
        List<WebElement> products = driver.findElements(By.cssSelector(".box-container .box"));
        assertFalse(products.isEmpty(), "No products found!");

        // Optionally, check the content of the first product
        if (!products.isEmpty()) {
            WebElement firstProduct = products.get(0);
            assertTrue(firstProduct.getText().contains("rose"), "First product does not contain 'rose'");
        }
    }
}
