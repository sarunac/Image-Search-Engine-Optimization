package com.multimedia.project.crawler;

import java.net.MalformedURLException;
import java.net.URISyntaxException;
import java.util.regex.Pattern;

import edu.uci.ics.crawler4j.crawler.Page;
import edu.uci.ics.crawler4j.crawler.WebCrawler;
import edu.uci.ics.crawler4j.url.WebURL;

public class BasicCrawler extends WebCrawler{
	
	private final static Pattern FILTERS = Pattern.compile(".*(\\.(css|js|bmp|gif|jpe?g" + "|png|tiff?|mid|mp2|mp3|mp4"
            + "|wav|avi|mov|mpeg|ram|m4v|pdf" + "|rm|smil|wmv|swf|wma|zip|rar|gz))$");

/**
* You should implement this function to specify whether the given url
* should be crawled or not (based on your crawling logic).
*/
@Override
public boolean shouldVisit(WebURL url) {
    String href = url.getURL().toLowerCase();
    return !FILTERS.matcher(href).matches() && href.startsWith("http://www1.macys.com/shop/product");
}

/**
* This function is called when a page is fetched and ready to be processed
* by your program.
*/
@Override
public void visit(Page page) {

    String url = page.getWebURL().getURL();
    if(url.startsWith("http://www1.macys.com/shop/product/")) {
    	
    	try {
    		ProductCrawler productCrawler = new ProductCrawler();
			productCrawler.productDetails(url);
		} catch (MalformedURLException | URISyntaxException e) {
			e.printStackTrace();
		} catch (Exception e) {
			e.printStackTrace();
		}
    }

	
  }

    
}
