<?php
    $path = '/home/bret/games/minecraft/ATLauncher/Instances/SouthCraftv10x/mods/';
    $fileList = scandir($path);
    foreach ($fileList as $idx => $file) {
        if (!is_file($path.$file)) {
            unset($fileList[$idx]);
        }
    }

    $fileList = array_values($fileList);


?>
<!DOCTYPE html>
<html>
	<head>
		<title>Modulation</title>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
        <link rel="stylesheet" href="bower_components/fontawesome/css/font-awesome.min.css" />
		<link rel="stylesheet" href="css/pure.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body class="pure-skin-mine">
		<div class="app-container pure-g">
            <div id="menu" class="pure-u-9-24">
                <div class="pure-menu pure-menu-open pure-menu-vertical">
                    <a href="#" class="pure-menu-heading">Mod List</a>
                    <ul class="mod-list">
                        <?php foreach ($fileList as $file) { ?>
                            <li><a href="file-info.php?file=<?php echo(urlencode($file)) ?>" class="mod-link"><?php echo($file) ?></a></li>
                        <?php } ?>    
                    </ul>
                </div>
            </div>
            <div id="content" class="pure-u-15-24">
                <div id="notifications">
                    
                </div>
                <div id="mod-details">
                    
                </div>
                <script id="modinfo-template" type="x-handlebars-template">
                    <table class="pure-table">
                        <tr>
                            <td>filename: </td>
                            <td>{{ filename }}</td>
                        </tr>
                        <tr>
                            <td>md5 hash: </td>
                            <td>{{ md5 }}</td>
                        </tr>
                        <tr>
                            <td>modid: </td>
                            <td>{{ modid }}</td>
                        </tr>
                        <tr>
                            <td>name: </td>
                            <td>{{ name }}</td>
                        </tr>
                        <tr>
                            <td>description: </td>
                            <td>{{ description }}</td>
                        </tr>
                        <tr>
                            <td>version: </td>
                            <td>{{ version }}</td>
                        </tr>
                        <tr>
                            <td>website: </td>
                            <td><a href="{{ website }}">{{ website }}</a></td>
                        </tr>
                        <tr>
                            <td>Authors</td>
                            <td>
                                <ul>
                                {{#each authors}}
                                <li>{{this}}</li>
                                {{/each}}
                                </ul>
                            </td>
                        </tr>
                    </table>
                </script>
                
            </div>
		</div>
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/handlebars/handlebars.min.js"></script>
		<script src="js/app.js"></script>
	</body>
</html>
