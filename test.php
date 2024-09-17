<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call PHP Function from JavaScript</title>
</head>
<body>
    <script>
        function myFunction() {
            console.log("Function called");

            // AJAX request to call PHP script
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "mail.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log("PHP Response: " + xhr.responseText);
                } else {
                    console.error("Error calling PHP");
                }
            };
            xhr.send();

            // The function will call itself every 1 minute (60000 milliseconds)
            setTimeout(myFunction, 600);
        }

        // Start the recursive function call
        myFunction();
    </script>
</body>
</html> -->
