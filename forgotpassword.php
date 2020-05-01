<!--Start session-->
<!--Connect to the database-->

<!--Check user inputs-->
    <!--Define error messages-->
    <!--Get email-->
    <!--Store errors in errors variable-->
    <!--If there are any errors-->
        <!--print error message-->
    <!--else: No errors-->
        <!--Prepare variables for the query-->
        <!--Run query to check if the email exists in the users table--->
        <!--If the email does not exist-->
            <!--print error message-->
        <!--else-->
            <!--get the user_id-->
            <!--Create a unique activation code-->
            <!--Insert user details and activation code in the forgotpassword tabel-->
            <!--Send email with link to resetpassword.php with user id and activation code-->
            <!--If email sent successfully-->
                <!--print success message-->