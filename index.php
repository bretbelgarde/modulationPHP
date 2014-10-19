<!DOCTYPE html>
<html lang="en">
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
          <a href="#" class="pure-menu-heading mod-link">Mod List</a>
          <ul id="mod-list">
          
          </ul>
        </div>
      </div>
      <div id="content" class="pure-u-15-24">
        <div id="notifications">
          <p>&nbsp;</p>
        </div>
        <div id="mod-details">

        </div>
      </div>
    </div>

    <script id="modinfo-template" type="x-handlebars-template">
      <form id="mod-data" name="mod-data" class="pure-form pure-form-stacked">
        <fieldset>
          <legend>{{name}}</legend>
          <div class="mod-meta"><small><span class="pull-left">Filename: {{filename}}</span><span class="pull-right">MD5: {{md5}}</span></small></div>
          <input type="hidden" id="filename" name="filename" value="{{filename}}">
          <input type="hidden" id="md5" name="md5" value="{{md5}}">
          <hr class="clearfix">
          <label for="name">Mod Name: </label>
          <input type="text" id="name" name="name" placeholder="Mod Name" {{#if name.length}}value="{{name}}"{{/if}} class="pure-input-1">
          
          <label for="modid">Mod ID:</label>
          <input type="text" id="modid" name="modid" placeholder="Mod ID" {{#if modid.length}}value="{{modid}}"{{/if}} class="pure-input-1">
          
          <label for="version">Version:</label>
          <input type="text" id="version" name="version" placeholder="Version Number" {{#if version.length}}value="{{version}}"{{/if}} class="pure-input-1">

          <label for="type">Mod Type:</label>
          <input type="text" id="type" name="type" placeholder="Mod Type" {{#if type.length}}value="{{type}}"{{/if}} class="pure-input-1">

          <label for="download">Download Source:</label>
          <input type="text" id="download" name="download" placeholder="Download Source" {{#if download.length}}value="{{download}}"{{/if}} class="pure-input-1">
          
          <label for="website">Website URL:</label>
          <input type="text" id="website" name="website" placeholder="Website URL" {{#if website.length}}value="{{website}}"{{/if}} class="pure-input-1">
          
          <label for="authors">Authors:</label>
          <input type="text" id="authors" name="authors" placeholder="Authors" {{#if authors.length}}value="{{authors}}"{{/if}} class="pure-input-1">

          <label for="donation">Donation URL:</label>
          <input type="text" id="donation" name="donation" placeholder="Donation URL" {{#if donation.length}}value="{{donation}}"{{/if}} class="pure-input-1">
          
          <label for="description">Description</label>
          <textarea id="description" name="description" class="pure-input-1 description">{{#if description.length}}{{description}}{{/if}}</textarea>
          
          <button type="button" id="save" class="pure-button pure-button-primary pull-right">Save</button>
        </fieldset>
      </form>
    </script>

    <script id="mod-list-template" type="x-handlebars-template">
      {{#each this }}
      <li {{#if new}}class="new"{{/if}}>
        <a href="mod-info.php?file={{filename}}" class="mod-link">
        <span class="mod-name">{{name}}</span><br>
        <span class="mod-md5"> <small>MD5: {{md5}}</small></span>
        </a>
      </li>
      {{/each}}
    </script>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/handlebars/handlebars.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
