package com.multimedia.project.crawler;


import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class ColorExtract {

	public String color(String otherDetails)	{
		Pattern patterncolor;
		String inital = "";
		String required = "";
		
		try	{
			patterncolor = Pattern.compile("color=[\\w ]+");
			
			Matcher matcher = patterncolor.matcher(otherDetails);
			while(matcher.find()) {
				inital = matcher.group();
			}
			required = (String) inital.subSequence(6, inital.length());
		} catch(Exception e) {
			e.printStackTrace();
		}
		return required;
	}

}
;