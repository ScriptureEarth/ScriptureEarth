<?php
/**
 * Constants.php
 *
 * This file is intended to group all constants to
 * make it easier for the site administrator to tweak
 * the login script.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 */
 
/**
 * Database Constants - these constants are required
 * in order for there to be a successful connection
 * to the MySQL database. Make sure the information is
 * correct.
 */
//const DB_SERVER = 'localhost:3306';
//const DB_USER = 'root';
//const DB_PASS = 'mmljrev22';
//const DB_NAME = 'scripture';
include("databaseConnection.php");

/**
 * Database Table Constants - these constants
 * hold the names of all the database tables used
 * in the script.
 */
const TBL_USERS = 'users';
const TBL_ACTIVE_USERS = 'active_users';
const TBL_ACTIVE_GUESTS = 'active_guests';
const TBL_BANNED_USERS = 'banned_users';

/**
 * Special Names and Level Constants - the admin
 * page will only be accessible to the user with
 * the admin name and also to those users at the
 * admin user level. Feel free to change the names
 * and level constants as you see fit, you may
 * also add additional level specifications.
 * Levels must be digits between 0-9.
 */
const ADMIN_NAME = 'Scott';
const ADMIN_Loren = 'LorenH';
const GUEST_NAME = 'Guest';
const ADMIN_LEVEL = 9;
const USER_LEVEL = 1;
const GUEST_LEVEL = 0;

/**
 * This boolean constant controls whether or
 * not the script keeps track of active users
 * and active guests who are visiting the site.
 */
const TRACK_VISITORS = true;

/**
 * Timeout Constants - these constants refer to
 * the maximum amount of time (in minutes) after
 * their last page fresh that a user and guest
 * are still considered active visitors.
 */
const USER_TIMEOUT = 10;
const GUEST_TIMEOUT = 5;

/**
 * Cookie Constants - these are the parameters
 * to the setcookie function call, change them
 * if necessary to fit your website. If you need
 * help, visit www.php.net for more info.
 * <http://www.php.net/manual/en/function.setcookie.php>
 */
const COOKIE_EXPIRE = 60*60*24*100;  //100 days by default
const COOKIE_PATH = '/';  //Avaible in whole domain

/**
 * Email Constants - these specify what goes in
 * the from field in the emails that the script
 * sends to users, and whether to send a
 * welcome email to newly registered users.
 */
const EMAIL_FROM_NAME = 'YourName';
const EMAIL_FROM_ADDR = 'youremail@address.com';
const EMAIL_WELCOME = false;

/**
 * This constant forces all users to have
 * lowercase usernames, capital letters are
 * converted automatically.
 */
const ALL_LOWERCASE = false;
?>