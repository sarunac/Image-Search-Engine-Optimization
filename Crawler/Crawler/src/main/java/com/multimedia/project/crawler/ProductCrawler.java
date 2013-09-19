package com.multimedia.project.crawler;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.InputStream;
import java.net.URI;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.remote.RemoteWebDriver;

import com.multimedia.project.VO.ProductDetailsVO;
import com.multimedia.project.dbconnection.MySqlConnection;


public class ProductCrawler {
	
	static List<String> urlPaths = new ArrayList<>();
	static Connection connection = null;

	public Object productDetails(String url) throws Exception {

    	URL productURL = new URL(url);
    	String urlPath = productURL.getPath();
    	
    	if(!urlPaths.contains(urlPath)) {
    		urlPaths.add(urlPath);
    		
    		RemoteWebDriver driver = new FirefoxDriver();
    		ProductDetailsVO pdVO = new ProductDetailsVO();
    		
    		driver.get(url);
    		
    		Object imgSource = driver.executeScript("return MACYS.pdp.mainImgSrc", 1);
    		Object categoryClassification  = driver.executeScript("return MACYS.pdp.categoryId", 1);
    		Object productClassification  = driver.executeScript("return MACYS.pdp.productId", 1);
    		Object others = driver.executeScript("return MACYS.pdp.upcmap", 1);
        
    		String title = driver.getTitle();
    		int productID = Integer.parseInt(productClassification.toString());
    		int categoryID = Integer.parseInt(categoryClassification.toString());
    		String otherDetails = others.toString();
    		ColorExtract colorExtract = new ColorExtract();
    		String color = colorExtract.color(otherDetails);
    		String description = driver.findElement(By.cssSelector("[id=longDescription][class=longDescription]")).getText();
    		String additionalNotes = driver.findElement(By.cssSelector("[id=bullets][class=bullets]")).getText();
        	
    		URL imagePath  = new URL("http://slimages.macys.com/is/image/MCY/products/");
    		URI uri = imagePath.toURI();
    		String imageurl = uri.resolve(imgSource.toString()).toString();
    		
            String extension = imageurl.substring(imageurl.lastIndexOf("."));
            String imageName = Cryptography.MD5(imageurl) + extension;

        	ImageCrawlController imageCrawlController = new ImageCrawlController();
        	imageCrawlController.imageCrawl(imageurl);
        	
        	pdVO.setTitle(title);
        	pdVO.setProductID(productID);
        	pdVO.setCategoryId(categoryID);
        	pdVO.setColor(color);
        	pdVO.setDescription(description);
        	pdVO.setAdditionalNotes(additionalNotes);
        	pdVO.setImageURL(imageurl);
        	pdVO.setProductURL(url);
        	pdVO.setImageName(imageName);
        	
    		driver.quit();
    		
    		insertDetails(pdVO);
    	}
    	
        return null;
	}
	
	public void insertDetails(ProductDetailsVO productDetailsVO) {
		connection = MySqlConnection.getConnection();
		PreparedStatement statement = null;
		PreparedStatement statementSelect = null;
		FileInputStream inputStream = null;

		try {
			
			statementSelect = connection
						      .prepareStatement("SELECT * FROM ProductDetails WHERE ProductID = ?");
			statementSelect.setInt(1, productDetailsVO.getProductID());
			ResultSet rs = statementSelect.executeQuery();
			
			int rowCount = 0;  
			while(rs.next()) {			    
			    rowCount++;  
			}			
			
			if(rowCount == 0) {
				String imageName = productDetailsVO.getImageName();
				
				File image = new File("D:/music/"+imageName);
				inputStream = new FileInputStream(image);
				String categoryrequired = "Pants";
				statement = connection
							.prepareStatement("INSERT INTO ProductDetails(Title, Image, ProductID, CategoryID, " +
										  	  "Color, Description, AdditionalNotes, ImageURL, ProductURL, ImageName, category) " +
										   	  "values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				
				statement.setString(1, productDetailsVO.getTitle());
				statement.setBinaryStream(2, (InputStream) inputStream,(int) (image.length()));
				statement.setInt(3, productDetailsVO.getProductID());
				statement.setInt(4, productDetailsVO.getCategoryId());
				statement.setString(5, productDetailsVO.getColor());
				statement.setString(6, productDetailsVO.getDescription());
				statement.setString(7, productDetailsVO.getAdditionalNotes());
				statement.setString(8, productDetailsVO.getImageURL());
				statement.setString(9, productDetailsVO.getProductURL());
				statement.setString(10, imageName);
				statement.setString(11, categoryrequired);
				
				statement.executeUpdate();
			}
			
		} catch (FileNotFoundException e) {
			System.out.println("FileNotFoundException: - " + e);
		} catch (SQLException e) {
			System.out.println("SQLException: - " + e);
		} finally {
			try {
				connection.close();
				statement.close();
			} catch (SQLException e) {
				System.out.println("SQLException Finally: - " + e);
			}
		}
	}
}
