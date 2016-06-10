<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$login_setup = array();
/* Sign-up/Register feature 
 * Set the followng config to True or False
 * True will show up the "Register" link on the login page
 * False will not 
 */  
  
$login_setup['Sign_Up']						= True; 

/* Username retreival feature
 * Set the followng config to True or False
 * True will show up the "Forgot Username" link on the login page
 * False will not  
 */

$login_setup['Username_Retrieval'] 	= True;

/* Password retreival feature
 * Comment one of the following lines as per need
 * True will show up the "Forgot Username" link on the login page
 * False will not  
 */
 
$login_setup['Pwd_Retrieval'] 	   	= True;  

//Username retrieval by"EnterEmail"/"EnterName"

$login_setup['Uname_Retrieval_Method'] = "Email"; 

/* Password retreival Method
* Set the following config to
* "Email" for unique key to be sent to email
* "SecQuestion" to enable resetting by entering security question
*/

$login_setup['Pwd_Retrieval_Method']	= "SecQuestion";


$login_setup['Track_Login_Attempts'] 	= False;
$login_setup['Max_Login_Attempts'] 		= 4;     //Max no of login attempts
$login_setup['No_Of_SecQuestions']     = 2;

$config['Login_Setup'] = $login_setup;

?>
