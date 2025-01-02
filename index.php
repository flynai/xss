<?php
/* Initialize the session */
session_start();

error_reporting(E_ERROR | E_PARSE);

/* Define variables and initialize with empty values */
$comment = "";
$comment_err = "";

$_SESSION['comment'][] = null;

/* Processing form data when form is submitted */
if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    /* Check if comment is empty */
    if (empty(trim($_POST["comment"])))
    {
        $comment_err = "Please enter comment.";
    }
    else
    {
        // Apply the specified filter to prevent XSS
        $filtered_comment = preg_replace('/\<[^>]+(\//\\I\_ I\'I\")+on[a-zA-Z]+(\=[^>]+)?\>/', '', $_POST["comment"]);
        $_SESSION['comments'][] = $filtered_comment;
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>GlobalGreyHatTeam</h2>
        <p>Hello we are GGHTeam team please write us a comment how can we help you?</p>
        <?php 
        foreach ($_SESSION['comments'] as &$value) {
            echo "<b>Anonymous: </b>".$value;
            ?><br><?php
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($comment_err)) ? 'has-error' : ''; ?>">
                <label>Comments</label>
                <input type="text" name="comment" class="form-control" value="<?php echo htmlspecialchars($comment); ?>">
                <span class="help-block"><?php echo $comment_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>
