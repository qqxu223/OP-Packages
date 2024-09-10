<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>Subscription Conversion Template</title>
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #87ceeb;
        color: #333;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100vh;
    }
    .container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 800px;
        padding: 20px;
        box-sizing: border-box;
        margin-top: 50px;
    }
    h1 {
        color: #007BFF;
        font-size: 24px;
        margin-bottom: 20px;
        text-align: center;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    input[type="text"], textarea {
        width: calc(100% - 16px);
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    input[type="radio"] {
        margin-right: 5px;
    }
    .radio-group {
        margin-bottom: 15px;
    }
    .radio-group label {
        margin: 0 10px 0 0;
        display: inline-block;
        font-weight: normal;
    }
    input[type="submit"], button {
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        color: #fff;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
        width: auto; 
        height: auto; 
    }
    input[type="submit"] {
        background-color: #007BFF;
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
    button.return-button {
        background-color: #dc3545;
    }
    button.return-button:hover {
        background-color: #c82333;
    }
    button.return-danger {
        background-color: #17a2b8;
    }
    button.copy-button {
        background-color: #17a2b8;
    }
    button.copy-button:hover {
        background-color: #138496;
    }
    button.save-button {
        background-color: #28a745;
    }
    button.save-button:hover {
        background-color: #218838;
    }
    textarea {
        height: 200px;
        resize: vertical;
        overflow-y: auto;
    }
    .result-container {
        margin-top: 20px;
    }
    .button-group {
        display: flex;
        flex-wrap: wrap; 
        justify-content: center;
        margin-top: 10px;
        gap: 10px; 
    }
    .log-container {
        margin-top: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
        padding: 10px;
        height: 200px;
        overflow-y: auto;
        white-space: pre-wrap;
        font-family: monospace;
        box-sizing: border-box;
    }
    .saved-data-container {
        margin-top: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
        padding: 10px;
        box-sizing: border-box;
    }
    .clear-button {
        background-color: #ff4c4c; 
        color: white; 
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
    }

    .clear-button:hover {
        background-color: #ff1a1a; 
    }
</style>

</head>
<body>
  <div class="container">
    <h1>Sing-box Subscription Conversion Template</h1>
    <div class="help-info">
        <h2>Help Information</h2>
        <p>Please choose a template to generate the configuration file: select the node information included in your subscription and choose the corresponding template; otherwise, it will not start.</p>
        <ul>
            <li><strong>Default Template 1</strong>: Hong Kong, Taiwan, Singapore, Japan, USA, South Korea.</li>
            <li><strong>Default Template 2</strong>: Singapore, Japan, USA, South Korea.</li>
            <li><strong>Default Template 3</strong>: Hong Kong, Japan, USA.</li>
            <li><strong>Default Template 4</strong>: Hong Kong, Japan, USA.</li>
            <li><strong>Default Template 5</strong>: No region, universal.</li>
        </ul>
    </div>
    <form method="post" action="">
        <label for="subscribeUrl">Subscription Link Address:</label>
        <input type="text" id="subscribeUrl" name="subscribeUrl" required>

        <div class="radio-group">
            <input type="radio" id="useDefaultTemplate" name="templateOption" value="default" checked>
            <label for="useDefaultTemplate">Use Default Template</label>

            <div class="default-template-options" style="margin-left: 20px;">
                <input type="radio" id="useDefaultTemplate1" name="defaultTemplate" value="mixed" checked>
                <label for="useDefaultTemplate1">Default Template 1</label>

                <input type="radio" id="useDefaultTemplate2" name="defaultTemplate" value="second">
                <label for="useDefaultTemplate2">Default Template 2</label>

                <input type="radio" id="useDefaultTemplate3" name="defaultTemplate" value="fakeip">
                <label for="useDefaultTemplate3">Default Template 3</label>

                <input type="radio" id="useDefaultTemplate4" name="defaultTemplate" value="tun">
                <label for="useDefaultTemplate4">Default Template 4</label>

                <input type="radio" id="useDefaultTemplate5" name="defaultTemplate" value="ip">
                <label for="useDefaultTemplate5">Default Template 5</label>
            </div>

            <input type="radio" id="useCustomTemplate" name="templateOption" value="custom">
            <label for="useCustomTemplate">Use Custom Template URL:</label>
            <input type="text" id="customTemplateUrl" name="customTemplateUrl" placeholder="Enter Custom Template URL">
        </div>

        <div class="button-group">
            <input type="submit" name="generateConfig" class="submit-button" value="Generate Configuration File">
            <button type="button" class="return-button" onclick="window.location.href='javascript:history.back()';">Return to Previous Level</button>
            <button type="button" class="return-danger" onclick="window.location.href='/nekoclash';">Return to Main Menu</button>
        </div>
    </form>

    <?php
    $dataFilePath = '/tmp/subscription_data.txt';
    $configFilePath = '/etc/neko/config/config.json';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generateConfig'])) {
        $subscribeUrl = trim($_POST['subscribeUrl']);
        $customTemplateUrl = trim($_POST['customTemplateUrl']);

        $dataContent = "Subscription Link Address: " . $subscribeUrl . "\n" . "Custom Template URL: " . $customTemplateUrl . "\n";
        file_put_contents($dataFilePath, $dataContent, FILE_APPEND);

        $subscribeUrlEncoded = urlencode($subscribeUrl);

        if ($_POST['templateOption'] === 'custom' && !empty($customTemplateUrl)) {
            $templateUrlEncoded = urlencode($customTemplateUrl);
        } elseif ($_POST['templateOption'] === 'default') {
            switch ($_POST['defaultTemplate']) {
                case 'mixed':
                    $templateUrlEncoded = urlencode("https://raw.githubusercontent.com/Thaolga/Rules/main/Clash/json/config_mixed.json");
                    break;
                case 'second':
                    $templateUrlEncoded = urlencode("https://raw.githubusercontent.com/Thaolga/Rules/main/Clash/json/config.json");
                    break;
                case 'fakeip':
                    $templateUrlEncoded = urlencode("https://raw.githubusercontent.com/Thaolga/Rules/main/Clash/json/config_fakeip.json");
                    break;
                case 'tun':
                    $templateUrlEncoded = urlencode("https://raw.githubusercontent.com/Thaolga/Rules/main/Clash/json/config_tun.json");
                    break;
                case 'ip':
                    $templateUrlEncoded = urlencode("https://raw.githubusercontent.com/Thaolga/Rules/main/Clash/json/config_ip.json");
                    break;
                default:
                    $templateUrlEncoded = urlencode("https://raw.githubusercontent.com/Thaolga/Rules/main/Clash/json/config_mixed.json");
                    break;
            }
        }

        $completeSubscribeUrl = "https://sing-box-subscribe-doraemon.vercel.app/config/{$subscribeUrlEncoded}&file={$templateUrlEncoded}";
        $tempFilePath = '/tmp/config.json';

        $command = "wget -O " . escapeshellarg($tempFilePath) . " " . escapeshellarg($completeSubscribeUrl);
        exec($command, $output, $returnVar);

        $logMessages = [];

        if ($returnVar !== 0) {
            $logMessages[] = "Unable to download content: " . htmlspecialchars($completeSubscribeUrl);
        }

        $downloadedContent = file_get_contents($tempFilePath);
        if ($downloadedContent === false) {
            $logMessages[] = "Unable to read the downloaded file content";
        }

        $updatedContent = $downloadedContent;

        if (file_put_contents($configFilePath, $updatedContent) === false) {
            $logMessages[] = "Unable to save the modified content to: " . $configFilePath;
        } else {
            $logMessages[] = "Configuration file generated and saved successfully: " . $configFilePath;
            $logMessages[] = "Generated and downloaded subscription URL: " . htmlspecialchars($completeSubscribeUrl);
        }

        echo "<div class='result-container'>";
        echo "<form method='post' action=''>";
        echo "<textarea id='configContent' name='configContent'>" . htmlspecialchars($updatedContent) . "</textarea>";
        echo "<div class='button-group'>";
        echo "<button class='copy-button' type='button' onclick='copyToClipboard()'><i class='fas fa-copy'></i> Copy to Clipboard</button>";
        echo "<input type='hidden' name='saveContent' value='1'>";
        echo "<button class='save-button' type='submit'>Save Changes</button>";
        echo "</div>";
        echo "</form>";
        echo "</div>";

        echo "<div class='log-container'>";
        foreach ($logMessages as $message) {
            echo htmlspecialchars($message) . "<br>";
        }
        echo "</div>";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['saveContent'])) {
        if (isset($_POST['configContent'])) {
            $editedContent = trim($_POST['configContent']);
            if (file_put_contents($configFilePath, $editedContent) === false) {
                echo "<div class='log-container'>Unable to save the modified content to: " . htmlspecialchars($configFilePath) . "</div>";
            } else {
                echo "<div class='log-container'>Content successfully saved to: " . htmlspecialchars($configFilePath) . "</div>";
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clearData'])) {
        if (file_exists($dataFilePath)) {
            file_put_contents($dataFilePath, '');
            echo "<div class='log-container'>Saved data has been cleared.</div>";
        }
    }

    if (file_exists($dataFilePath)) {
        $savedData = file_get_contents($dataFilePath);
        echo "<div class='saved-data-container'>";
        echo "<h2>Saved Data</h2>";
        echo "<pre>" . htmlspecialchars($savedData) . "</pre>";
        echo "<form method='post' action=''>";
        echo "<button class='clear-button' type='submit' name='clearData'>Clear Data</button>";
        echo "</form>";
        echo "</div>";
    }
    ?>

    <script>
        function copyToClipboard() {
            const copyText = document.getElementById("configContent");
            copyText.select();
            document.execCommand("copy");
            alert("Copied to clipboard");
        }
    </script>
</div>

<style>
    .clear-button {
        background-color: #ff4c4c; 
        color: white; 
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
    }

    .clear-button:hover {
        background-color: #ff1a1a; 
    }

    .button-group button, .button-group input[type="submit"] {
        margin: 5px;
    }

    .saved-data-container {
        margin-top: 20px;
        padding: 10px;
        border: 1px solid #ccc;
    }
</style>