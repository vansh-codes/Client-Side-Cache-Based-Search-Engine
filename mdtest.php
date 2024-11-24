<?php
require 'parsedown-master/Parsedown.php';

$content = "
# Markdown Test
- Hey
- This is a test
- **Bold**
- *Italic*
";

$Parsedown = new Parsedown();
$parsedMarkdown = $Parsedown->text($content);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?= $parsedMarkdown ?>
</body>
</html>