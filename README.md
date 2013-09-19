Image-Search-Engine-Optimization
================================
USER MANUAL:
Step 1 : Crawling and Image and Details data collection
This is a domain specific crawler build mainly for Macy's website.
In macy's site there are several categories like "women", "coat" , "pants" and so on. 
To begin a category to crawl from go to that category page in Macys and copy the URL and add it to controller.addSeed function.
For example:
http://www1.macys.com/shop/womens-clothing/womens-pants?id=157&edge=hybrid
The above URL crawls women’s pants in women’s clothing category. 
The intermediate crawl data will be stored in a folder. It can be specified in crawlStorageFolder in BasicCrawlController.java file
The image crawl storage folder can be specified in "storageFolder" in ImageCrawlController file.
Step 2: All the images that are crawled are stored in the storageFolder and the related data is stored in the database in productdetails table
Step 2.1: product details table is created using the following query
CREATE TABLE `productdetails` (
  `Title` varchar(200) DEFAULT NULL,
  `Image` blob NOT NULL,
  `ProductID` int(10) NOT NULL DEFAULT '0',
  `CategoryID` int(10) DEFAULT NULL,
  `Color` varchar(500) DEFAULT NULL,
  `Description` varchar(300) DEFAULT NULL,
  `AdditionalNotes` varchar(1000) DEFAULT NULL,
  `ImageURL` varchar(500) DEFAULT NULL,
  `ProductURL` varchar(500) DEFAULT NULL,
  `ImageName` varchar(100) DEFAULT NULL,
  `tags` varchar(400) DEFAULT NULL,
  `category` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`ProductID`)
) 
Step 2.2 : The data set that we gathered and updated can also be found in the t7 database under product details table.
To use the same database, please import the t7.sql into your database named "t7".
Step 2.3 :  Visual feature extraction : This is done in matlab. Use readimg.m file where the folder in which we have stored the images extracted from crawler is given as input.
We have separately gathered hsv values in rgb2hsv_demo file where again the images folder is given in Path. 
The extracted queries with product name and feature vector is stored in the properties_new table of t7.sql The normalized values are calculated in php using the 863norm.php file
Step 3: It would be extracting and grouping of keywords and storing it in the tags column of productdetails table.
This is done by extractkeywords.php file. The stop words which had to be removed are mentioned in "$stopwords" field. So these words will be removed from the 
description and only remaining will be added from the description as keywords
 
Step 4: Next we build a visual thesaurus. We take each tag from each product and compare all the remaining tags in the remaining images and group the images with similar tags
into a dataset "with keywords" and the image set which do not have that keyword will be grouped into "without keywords".

With keyword query will be : "SELECT Tcoarsenessnorm, TContrastnorm, TDirectionnorm, contrastnorm, correlationnorm, energynorm,							 homogeneitynorm, imgsumnorm, imgavgnorm, imgstdnorm, imgminnorm, imgmaxnorm, hmeannorm, smeannorm, vmeannorm FROM properties_new WHERE Productname IN 		 (SELECT ImageName FROM PRODUCTDETAILS WHERE TAGS LIKE '%$key%')"
Without keyword query will be :
"SELECT Tcoarsenessnorm, TContrastnorm, TDirectionnorm, contrastnorm, correlationnorm, energynorm,homogeneitynorm, imgsumnorm, imgavgnorm, imgstdnorm, imgminnorm, imgmaxnorm, hmeannorm, smeannorm, vmeannorm 				        FROM properties_new WHERE Productname IN (SELECT ImageName FROM PRODUCTDETAILS WHERE     TAGS NOT LIKE '%$key%')"

So like this for each keyword a table is created. It contains images and its respective feature list is inserted into it. Likewise for no key word table is also created. These tables can be found in the "Withkeyword" and "withnokeyword" folder. 
Due to system restriction we were able to crawl approximately 1100 keywords which can be found in the above folders.
Step 5:
Next main step would be creation of p-values which is done in matlab using the k-stestmain.m file where the folder "withkeyword" and "withnokeyword" is given as input. The resultant queries are inserted into the p-value table in the t7 database
Step 6: Based on these p-values search is built.
This is found in index.php. In this the search is build based upon the Euclidian distances of the query and new query vectors. 
Step 7: Finally for project launching,
Import the productdetails.sql , properties_new.sql , pvalue.sql files into your localhost under "test" database
And run the index.php file in the iLike folder inside ".\crawlerandilike\iLike\iLike\source". Make sure the database connection is established correctly for localhost in Connection.php file
default values are "127.0.0.1" and "test" and "root" and "" for host, database, user and password respectively.
For testing you can use the keywords given in "Keywords-To test" folder which gives top results.
We have tried to implement the system as accurately as possible. But some of the keywords may not give out accurate results, the reason behind is mainly because of the discrepancies in the macy's website between the image and its metadata.
But if you test for the keywords in the "keywords-to test" folder you can very well see that our system works accurately.

