package org.example;

import java.time.Duration;
import java.util.List;

import org.junit.jupiter.api.AfterEach;
import static org.junit.jupiter.api.Assertions.assertFalse;
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
            /*driver.quit();*/
        }
    }

    @Test
    public void testSearchFunctionality() {
        // Open the search page
        driver.get("http://localhost/FlowerShopManagement/FlowerShopManagement/search.php");

        // Perform a search
        WebElement searchBox = driver.findElement(By.name("search_box")); // Fix: Corrected the name attribute
        searchBox.sendKeys("viburnum");

        WebElement searchButton = wait.until(ExpectedConditions.elementToBeClickable(By.name("search_btn")));
        ((JavascriptExecutor) driver).executeScript("arguments[0].click();", searchButton);

        // Wait for search results to be displayed
        wait.until(ExpectedConditions.visibilityOfElementLocated(By.className("box-container")));

        // Verify that products are displayed
        List<WebElement> products = driver.findElements(By.cssSelector(".box-container .box"));
        assertFalse(products.isEmpty(), "No products found!");

        // Optionally, check the content of the first product
        if (!products.isEmpty()) {
            WebElement firstProduct = products.get(0);
            assertTrue(firstProduct.getText().toLowerCase().contains("viburnum"), "First product does not contain 'viburnum'");
        }
    }
}
