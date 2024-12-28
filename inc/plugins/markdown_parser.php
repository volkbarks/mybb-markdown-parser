<?php
// Disallow direct access to this file for security reasons
if (!defined("IN_MYBB")) {
    die("Direct initialization of this file is not allowed.");
}

function markdown_parser_info()
{
    return [
        "name" => "Markdown Parser",
        "description" => "Parses markdown using the Parsedown library.",
        "website" => "",
        "author" => "Kozlik",
        "authorsite" => "",
        "version" => "1.0",
        "codename" => "markdown_parser",
        "compatibility" => "18*",
    ];
}

// A class to apply to blockquotes. If blank, will not apply a class
define("MARKDOWN_PARSER_QUOTE_STYLE", "mdquote");

function markdown_parser_activate()
{
    // Don't need to do anything.
}

function markdown_parser_deactivate()
{
    // Don't need to do anything.
}

// The function that converts the markdown text to HTML
function parseMarkdown($text)
{
    // Include the PHP Markdown library (you can use any Markdown library you prefer)
    if (!class_exists("Parsedown")) {
        require_once MYBB_ROOT . "inc/plugins/markdown_parser/Parsedown.php"; // Path to the Parsedown class
    }

    static $parsedown = new Parsedown();
    // I really hope I don't need to enable this bcuz MyBB already escapes html LOL cuz otherwise BBCode in the [md] tags will not render properly :'(
    //$parsedown->setSafeMode(true);

    return $parsedown->text($text); // Convert Markdown to HTML
}

// Hook into the parser to process the custom BBCode
function markdown_parser_parse($message)
{
    // Look for the [md] BBCode and process it
    $pattern = "#\[md\](.*?)\[/md\]#si";
    $message = preg_replace_callback(
        $pattern,
        function ($matches) {
            $content = $matches[1];

            // Revert HTML anchor tags to handle only plain URL text
            $content = convertHtmlUrlsToMarkdownUrls($content);

            // Fix the &gt; so Parsedown can properly parse blockquotes
            $content = str_replace("&gt; ", "> ", $content);

            // Fix any <br /> elements because they act like bad markdown
            $content = str_replace("<br />", "\r\n", $content);

            // Replace non-breaking characters with a regular space before passing to parseMarkdown
            // https://stackoverflow.com/a/45856204
            $content = preg_replace('/\xc2\xa0/', " ", $content);

            // Parse Markdown within the tags
            $content = parseMarkdown($content);

            // Style the blockquotes
            $content = str_replace(
                "<blockquote>",
                "<blockquote " . getBlockquoteClass() . ">",
                $content
            );

            // Add target="_blank" to URLs
            $content = setUrlsToOpenInNewTab($content);

            // Add the tags back so the endparse method can remove all the extra <br>s that MyBB adds in later.
            $content = "[md]" . $content . "[/md]";

            return $content;
        },
        $message
    );

    return $message;
}

// Removes all the extra "<br />" tags MyBB's class_parser:parse_message method does.
function markdown_parser_endparse($message) 
{
    // Look for the [md] BBCode and process it
    $pattern = "#\[md\](.*?)\[/md\]#si";
    $message = preg_replace_callback(
        $pattern,
        function ($matches) {		
            $content = $matches[1];

            // Temporarily escape content inside <blockquote> tags
            $content = preg_replace_callback(
                "#<(blockquote)[^>]*>(.*?)</\\1>#si",
                function($tagMatches) {
                    // Escape <br /> tags inside the <code> and <blockquote> tags
                    return str_replace("<br />", "__BR__TAG__", $tagMatches[0]);
                },
                $content
            );

            // Now replace all <br /> tags in the content
            $content = str_replace("<br />", "", $content);
            
            // Restore the <blockquote> tags and their content
            $content = str_replace("__BR__TAG__", "<br />", $content);

            return $content;
        },
        $message
    );

    return $message;
}

// MyBB already converts URLs to HTML elements before this plugin runs, so turn them back into regular links, markdown style.
function convertHtmlUrlsToMarkdownUrls($string)
{
    // Step 1: Match markdown-style links with an anchor tag inside
    $string = preg_replace_callback(
        '#\[(.*?)\]\(<a\s+href=["\'](https?://[^\s]+)["\'][^>]*>(.*?)</a>\)#i',
        function ($matches) {
            // $matches[1] is the link text from markdown format
            // $matches[2] is the URL from the <a> href
            // $matches[3] is the inner text of the anchor tag
            return "[$matches[1]]($matches[2])"; // Convert to markdown [link text](url)
        },
        $string
    );

    // Step 2: Match regular anchor tags (without markdown)
    $string = preg_replace_callback(
        '#<a\s+href=["\'](https?://[^\s]+)["\'][^>]*>(.*?)</a>#i',
        function ($matches) {
            // $matches[1] is the URL from the <a> href
            // $matches[2] is the link text inside the <a> tag
            return "[$matches[2]]($matches[1])"; // Convert to markdown [link text](url)
        },
        $string
    );

    return $string;
}

function setUrlsToOpenInNewTab($string)
{
    // Post-process the HTML to add target="_blank" to all links
    return preg_replace("/<a\s+(.*?)>/i", '<a $1 target="_blank">', $string);
}

function getBlockquoteClass()
{
    if (
        defined("MARKDOWN_PARSER_QUOTE_STYLE") &&
        !empty(MARKDOWN_PARSER_QUOTE_STYLE)
    ) {
        return 'class="' . MARKDOWN_PARSER_QUOTE_STYLE . '"';
    }
    return "";
}

// Register the parse function to be used in MyBB
function markdown_parser_add_hooks()
{
    global $plugins;

    // Register the hook to parse the custom BBCode
    $plugins->add_hook("parse_message", "markdown_parser_parse");
    $plugins->add_hook("parse_message_end", "markdown_parser_endparse");
}

// Activate the plugin by calling the setup functions
if (defined("IN_ADMIN") && $mybb->input["action"] == "install") {
    markdown_parser_activate();
}

// Add hooks on plugin load
markdown_parser_add_hooks();

?>
