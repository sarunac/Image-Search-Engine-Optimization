package com.multimedia.project.dbconnection;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class MySqlConnection {

	public static Connection getConnection() {
		
		String JDBC_DRIVER = "com.mysql.jdbc.Driver";
		String url = "jdbc:mysql://127.0.0.1:3306/test";
		String username = "root";
		String password = "";
		Connection connection = null;
		
		try {
		    System.out.println("Connecting database...");
		    Class.forName(JDBC_DRIVER);
		    connection = DriverManager.getConnection(url, username, password);
		    System.out.println("Database connected!");
		} catch (SQLException e) {
		    throw new RuntimeException("Cannot connect the database!", e);
		} catch (ClassNotFoundException e) {
			e.printStackTrace();
		}
//		} finally {
//		    System.out.println("Closing the connection.");
//		    if (connection != null) try { connection.close(); } catch (SQLException ignore) {}
//		}
		
		return connection;
	}
}
