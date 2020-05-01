<!--Start session-->
<!--Connect to the database-->

<!--Check user inputs-->
    <!--Define error message-->
    <!--Get email and password-->
    <!--Store errors in errors variable-->
    <!--If there are any errors-->
        <!--print error message-->
    <!--else: No errors-->
        <!--Prepare variables for the query-->
        <!--Run query: Check combination of email & password exists-->
        <!--If email & password don't match print error-->
        <!--else-->
            <!--log the user in: Set session variables-->
            <!--If remember me is not checked-->
                <!--print "success"-->
            <!--else-->
                <!--Create two variables $authentificator1 and &authentificator2-->
                <!--Store them in a cookie-->
                <!--Run query to store them in rememberme table-->
                <!--If query unsuccessful-->
                    <!--print error-->
                <!--else-->
                    <!--print "success"-->