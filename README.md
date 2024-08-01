# Bank
1.	**Overview of documentation contents:**
-	Software Requirement Specification (SRS): The software will present the user with a login page that will ask the user to input their id. They will be provided with the basic services that they need within a bank. They will be able to: 
•	Create Accounts: Open Savings, Checking, or Investment accounts.
•	Manage Accounts: Perform operations such as withdrawals, deposits, transfers, and view account balances and transaction histories.
•	Interest Calculation: Automatically calculate and apply interest to Savings and Investment accounts monthly.
•	User Authentication: Secure login system to protect user data and transactions.
•	Transaction Management: Handle high volumes of transactions efficiently, especially during peak periods.
•	Real-time Updates: Provide real-time updates and account summaries.
•	Administrative Functions: Allow bank administrators to manage accounts and oversee transactions.
-	Software Design Description (SDD): The implementation of the files and the program itself will satisfy the need for a more robust and seamless banking experience. All the options are neatly laid out and obvious to any user. Error checking will ensure stability against misinputs and wrong information. The design will focus on:
•	User Interface: A clean and intuitive interface with clear options for all banking operations.
•	Error Handling: Comprehensive error checking to ensure stability against misinputs and incorrect information.
•	Modular Design: Separation of different functionalities into distinct modules for easier maintenance and testing.
•	File Structure: Creation of two sets of files (regular files and files with a '1' at the end) to facilitate easier testing without affecting the user end. Regular files are for actual implementation, while files with '1' are for testing purposes.
•	Database Design: A local database for testing purposes, which mirrors the actual banking database to ensure compatibility and accurate testing results.
Security Measures: Implementation of security protocols to protect user data and ensure safe transactions.

-	Software Test Documentation (STD): We have a local database that is used to test and document results. The use of the files without a 1 at the end allows for general testing without the userid constraints and will allow for easier modification if needed. The local database will not interfere or alter the actual banking database that the program will be implemented for. The testing process includes: 
•	Functional Testing: Ensuring all banking operations (withdrawals, deposits, transfers, account creation) work correctly.
•	Usability Testing: Verifying that the user interface is intuitive and user-friendly.
•	Performance Testing: Evaluating the system's performance under high transaction volumes, especially during peak periods.
•	Security Testing: Testing the login system and other security measures to protect user data and transactions.
•	Error Handling: Checking the system’s response to various error conditions to ensure stability and robustness.
•	File Testing: Using files without a '1' for general testing and files with a '1' for testing specific functionalities without user ID constraints. When logging in, use the userid: 12345 as a start.
•	Documentation of Results: Recording the results of all tests and making necessary modifications based on feedback. The local database used for testing ensures that no actual banking data is altered or interfered with during the testing process.


2.	**Description of all files:** We have created the .php and .html files for search, update, insert, delete, and display for all the 3 account types along with their transaction tables. In addition, we have duplicated the files, inserting a 1 at the end (ex: insert_checkings and insert_checkings1). They are inherently the same files, with the modification for the files that end with a 1, being tied to a user. To further explain, if we call for display_checkings.php, the database will display every checking account that is an entry in the checking table. On the other hand, display_checkings1.php will only display the checking accounts tied to the userid that was used to login to the database (ex: if a userid was 1111, then display_checkings1.php will display every entry that has a userid of 1111). Therefore, the files without the 1 at the end are general purpose use on the developer end, while the files with a 1 at the end are used by the user. All the files linked to the login and dashboard files are the files with the 1 at the end. The files with a 1 at the end are the main ones being used and called for by the program.


For Checking:

delete_checking.php: prompts the user to enter an account number. The file will delete the entry in the table with the same account number.
display_checkings.php: displays all the entries in the table. It will include all the attributes of the table which includes: userid, account number, last name, first name, balance, date, email, address, etc… 
insert_checking.php: will prompt the user to create a new account and enter in the fields for all the attributes present in the table: 
search_checking.php: will prompt the user to enter an account number. The file will display all the accounts tied to the account number in a similar manner to the display_checkings file.
update_checking.php: will prompt the user to enter an account number. The file will also ask to update any information for that account in the table.
deposit_checkings.php: will prompt the user to enter an account number along with the amount to be deposited.
transfer_checkings.php: will prompt the user to enter the account numbers of the sender and receiver along with the transfer amount.
withdraw_checkings.php: will prompt the user to enter an account number along with the amount to be withdrawn.
All the html files are the exact same, providing the user interface to input the required information/fields. Each html file will have different fields to fill based on the requirements of the php file.
Note: The same applies for the variants that have a 1 at the end. The difference is an error checking that makes sure that the account number entered is linked to the userid used to log in. Otherwise, the database will not allow the user to use the program.



For Saving:
delete_savings.php: prompts the user to enter an account number. The file will delete the entry in the table with the same account number.
display_ savings.php: displays all the entries in the table. It will include all the attributes of the table which includes: userid, account number, last name, first name, balance, date, email, address, etc… 
insert_ savings.php: will prompt the user to create a new account and enter in the fields for all the attributes present in the table: 
search_ savings.php: will prompt the user to enter an account number. The file will display all the accounts tied to the account number in a similar manner to the display_savings file.
update_ savings.php: will prompt the user to enter an account number. The file will also ask to update any information for that account in the table.
deposit_ savings_transaction.php: will prompt the user to enter an account number along with the amount to be deposited.
transfer_ savings_transaction.php: will prompt the user to enter the account numbers of the sender and receiver along with the transfer amount.
withdraw_ savings_transaction.php: will prompt the user to enter an account number along with the amount to be withdrawn.
Interest_calculations_savings_transaction.php: will check if it is the first day of the month and calculate the interest rate if it is. If it is not, the program will inform the user that it is not the first day yet.
All the html files are the exact same, providing the user interface to input the required information/fields. Each html file will have different fields to fill based on the requirements of the php file.
Note: The same applies for the variants that have a 1 at the end. The difference is an error checking that makes sure that the account number entered is linked to the userid used to log in. Otherwise, the database will not allow the user to use the program.




 For Investment:
delete_investments.php: prompts the user to enter an account number. The file will delete the entry in the table with the same account number.
display_investments.php: displays all the entries in the table. It will include all the attributes of the table which includes: userid, account number, last name, first name, balance, date, email, address, etc… 
insert_investments.php: will prompt the user to create a new account and enter in the fields for all the attributes present in the table: 
search_investments.php: will prompt the user to enter an account number. The file will display all the accounts tied to the account number in a similar manner to the display_investments file.
update_investments.php: will prompt the user to enter an account number. The file will also ask to update any information for that account in the table.
deposit_investments _transaction.php: will prompt the user to enter an account number along with the amount to be deposited.
withdraw_investments _transaction.php: will prompt the user to enter an account number along with the amount to be withdrawn. The program will check if a year has past since the most recent transaction.
transfer_ investments_transaction.php: will prompt the user to enter the account numbers of the sender and receiver along with the transfer amount.
interest_calculations_investments_transaction.php: will check if it is the first day of the month and calculate the interest rate if it is. If it is not, the program will inform the user that it is not the first day yet. 
All the html files are the exact same, providing the user interface to input the required information/fields. Each html file will have different fields to fill based on the requirements of the php file.
Note: The same applies for the variants that have a 1 at the end. The difference is an error checking that makes sure that the account number entered is linked to the userid used to log in. Otherwise, the database will not allow the user to use the program.




For Checking Transaction:

delete_checkings_transaction.php: will prompt the user to enter the transaction ID associated with the transaction and will delete the transaction.
display_checkings_transaction.php: displays all the entries in the table. It will include all the attributes of the table.
search_checkings_transaction.php: will prompt the user to enter a transaction ID. The file will display all the transactions tied to the ID in a similar manner to the display_checkings_transaction file.
update_checkings_transaction.php: will prompt the user to enter a transaction ID. The file will also ask to update any information for that transaction in the table.




For Saving Transaction:

delete_savings_transaction.php: will prompt the user to enter the transaction ID associated with the transaction and will delete the transaction.
display_savings_transaction.php: displays all the entries in the table. It will include all the attributes of the table.
search_savings_transaction.php: will prompt the user to enter a transaction ID. The file will display all the transactions tied to the ID in a similar manner to the display_savings_transaction file.
update_savings_transaction.php: will prompt the user to enter a transaction ID. The file will also ask to update any information for that transaction in the table.




For Investment Transaction:

delete_investment_transaction.php: will prompt the user to enter the transaction ID associated with the transaction and will delete the transaction.
display_investment_transaction.php: displays all the entries in the table. It will include all the attributes of the table.
search_investment_transaction.php: will prompt the user to enter a transaction ID. The file will display all the transactions tied to the ID in a similar manner to the display_investment_transaction file.
update_investment_transaction.php: will prompt the user to enter a transaction ID. The file will also ask to update any information for that transaction in the table.
All the html files are the exact same, providing the user interface to input the required information/fields. Each html file will have different fields to fill based on the requirements of the php file.


	
Test folder:
login.php: will ask whether the user is an administrator or a regular user. If they are a regular user, they will input their userid then will be taken to the dashboard. If the userid is not valid, they will be prompted to create a new account with the userid.
daily_summary.php: If the administrator option was chosen in the login page, the file will print out all of the transactions that happened in the current day for all 3 types of accounts.
logout.php: will logout the user.
register.php: if the userid is not valid in the login page, they will be taken to this page where they will be prompted to fill all the attributes of the login table.
dashboard.php: If the userid is valid, they will be taken to the dashboard where the options for checking, savings, and investment will be present. The file will allow the user to go through all of the operations of all 3 different accounts.
