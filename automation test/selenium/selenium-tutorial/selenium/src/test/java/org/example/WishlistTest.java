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

/**
 * Author: Sanoj Indrasinghe
 */
public class WishlistTest {

    private WebDriver driver;
    private WebDriverWait wait;

    @BeforeEach
    public void setUp() {
        // Initialize the EdgeDriver
        driver = new EdgeDriver();
        wait = new WebDriverWait(driver, Duration.ofSeconds(10));
        driver.manage().window().maximize();
    }

    @AfterEach
    public void tearDown() {
        if (driver != null) {
            driver.quit();
        }
    }

    @Test
    public void testWishlistPage() {
        // Navigate to the wishlist page
        driver.get("http://localhost/api-flora/wishlist.php");

        // Wait for the wishlist page to load and display the wishlist items
        wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("wishlist_container")));

        // Verify that there are items in the wishlist
        List<WebElement> wishlistItems = driver.findElements(By.cssSelector(".wishlist-item"));
        if (wishlistItems.isEmpty()) {
            System.out.println("The wishlist is empty.");
        } else {
            System.out.println("Items in the wishlist:");
            for (WebElement item : wishlistItems) {
                String itemName = item.findElement(By.cssSelector(".item-name")).getText();
                String itemPrice = item.findElement(By.cssSelector(".item-price")).getText();
                String itemImageSrc = item.findElement(By.cssSelector(".item-image")).getAttribute("src");
                System.out.println("Name: " + itemName);
                System.out.println("Price: " + itemPrice);
                System.out.println("Image Source: " + itemImageSrc);
                System.out.println("--------");
            }
        }
    }
}
