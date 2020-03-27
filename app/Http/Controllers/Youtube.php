<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Youtube extends Controller
{
    // keeps track of current and preceding elements
    var $tags = [];

    // array containing all feed data
    var $output = [];

    // return value for display functions
    var $retval = "";

    // constructor for new object
    public function __construct($file)
    {
        // instantiate xml-parser and assign event handlers
        $xml_parser = xml_parser_create("");
        xml_set_object($xml_parser, $this);
        xml_set_element_handler($xml_parser, "startElement", "endElement");
        xml_set_character_data_handler($xml_parser, "parseData");

        // open file for reading and send data to xml-parser
        $fp = @fopen($file, "r") or die("<b>YouTubeParser:</b> Could not open $file for input");
        while ($data = fread($fp, 4096)) {
            xml_parse($xml_parser, $data, feof($fp)) or die(sprintf(
                    "YouTubeParser: Error <b>%s</b> at line <b>%d</b><br>",
                    xml_error_string(xml_get_error_code($xml_parser)),
                    xml_get_current_line_number($xml_parser)
                ));
        }
        fclose($fp);

        // dismiss xml parser
        xml_parser_free($xml_parser);
    }

    function startElement($parser, $tagname, array $attrs = [])
    {
        // capture LINK href where rel='alternate'
        if (($tagname == "LINK") && $attrs['HREF'] && $attrs['REL'] && $attrs['REL'] == 'alternate') {
            $this->startElement($parser, 'LINK', []);
            $this->parseData($parser, $attrs['HREF']);
            $this->endElement($parser, 'LINK');
        }

        // capture HQ image URL
        if ($attrs['URL'] && $attrs['HEIGHT'] && $attrs['WIDTH'] && !$attrs['TIME']) {
            $this->startElement($parser, 'MEDIA:THUMBNAIL', []);
            $this->parseData($parser, $attrs['URL']);
            $this->endElement($parser, 'MEDIA:THUMBNAIL');
        }

        // capture duration
        if ($tagname == 'YT:DURATION') {
            $this->startElement($parser, 'DURATION', []);
            $this->parseData($parser, $attrs['SECONDS']);
            $this->endElement($parser, 'DURATION');
        }

        // capture rating details
        if ($tagname == 'GD:RATING') {
            $this->startElement($parser, 'RATING', []);
            $this->parseData($parser, $attrs['AVERAGE']);
            $this->endElement($parser, 'RATING');

            $this->startElement($parser, 'NUMRATERS', []);
            $this->parseData($parser, $attrs['NUMRATERS']);
            $this->endElement($parser, 'NUMRATERS');
        }

        // capture statistics
        if ($tagname == 'YT:STATISTICS') {
            $this->startElement($parser, 'FAVORITECOUNT', []);
            $this->parseData($parser, $attrs['FAVORITECOUNT']);
            $this->endElement($parser, 'FAVORITECOUNT');

            $this->startElement($parser, 'VIEWCOUNT', []);
            $this->parseData($parser, $attrs['VIEWCOUNT']);
            $this->endElement($parser, 'VIEWCOUNT');
        }

        // check if this element can contain others - list may be edited
        if (preg_match("/^(FEED|ENTRY)$/", $tagname)) {
            if ($this->tags) {
                $depth = count($this->tags);
                if (is_array($tmp = end($this->tags))) {
                    list($parent, $num) = each($tmp);
                    if ($parent) $this->tags[$depth - 1][$parent][$tagname]++;
                }
            }
            array_push($this->tags, [$tagname => []]);
        } else {
            // add tag to tags array
            array_push($this->tags, $tagname);
        }
    }

    function endElement($parser, $tagname)
    {
        // remove tag from tags array
        array_pop($this->tags);
    }

    function parseData($parser, $data)
    {
        // return if data contains no text
        if (!trim($data)) return;

        $evalcode = "\$this->output";
        foreach ($this->tags as $tag) {
            if (is_array($tag)) {
                list($tagname, $indexes) = each($tag);
                $evalcode .= "[\"$tagname\"]";
                if (${$tagname}) $evalcode .= "[" . (${$tagname} - 1) . "]";
                if ($indexes) extract($indexes);
            } else {
                if (preg_match("/^([A-Z]+):([A-Z]+)$/", $tag, $matches)) {
                    $evalcode .= "[\"$matches[1]\"][\"$matches[2]\"]";
                } else {
                    $evalcode .= "[\"$tag\"]";
                }
            }
        }
        eval("$evalcode = $evalcode . '" . addslashes($data) . "';");
    }

    // display a single channel as HTML
    function display_channel($data)
    {
        extract($data);
        $this->retval .= "<h2>" . htmlspecialchars($TITLE) . "</h2>\n";
        if ($SUBTITLE) $this->retval .= "<p>" . htmlspecialchars($SUBTITLE) . "</p>\n";
        if ($ENTRY) {
            $this->retval .= "<table border=\"0\" cellpadding=\"5\" cellspacing=\"0\">\n";
            foreach ($ENTRY as $item) $this->display_item($item, "VIDEO_LIST");
            $this->retval .= "</table>\n\n";
        }
    }

    // display a single video as HTML
    function display_item($data, $parent)
    {
        extract($data);
        if (!$TITLE) return;

        $this->retval .= "<tr style=\"vertical-align: top;\">\n";
        $this->retval .= "<td style=\"text-align: center;\">";
        if ($THUMBNAIL_URL = $MEDIA['GROUP']['MEDIA']['THUMBNAIL']) {
            $this->retval .= "<p>";
            if ($LINK) $this->retval .=  "<a href=\"$LINK\" target=\"_blank\">";
            $this->retval .= "<img src=\"$THUMBNAIL_URL\" border=\"0\" width=\"120\" alt=\"\">";
            if ($LINK) $this->retval .= "</a>";
            if ($DURATION = $MEDIA['GROUP']['DURATION']) {
                $this->retval .= "<p><small><b>Duration:</b> " . sprintf("%02.2d:%02.2d", floor($DURATION / 60), $DURATION % 60) . "</small></p>";
            }
            $this->retval .= "</p>";
        }
        $this->retval .= "</td>\n";
        $this->retval .= "<td>";
        $this->retval .=  "<h3>";
        if ($LINK) $this->retval .=  "<a href=\"$LINK\" target=\"_blank\">";
        $this->retval .= stripslashes($TITLE);
        if ($LINK) $this->retval .= "</a>";
        if ($AUTHOR) $this->retval .= " <small style=\"white-space: nowrap;\">by <a href=\"http://www.youtube.com/user/{$AUTHOR['NAME']}\">{$AUTHOR['NAME']}</a></small>";
        $this->retval .=  "</h3>";
        if ($SUMMARY) {
            $this->retval .= "<p>" . nl2br(htmlspecialchars(stripslashes($SUMMARY))) . "</p>\n";
        } elseif ($DESCRIPTION = $MEDIA['GROUP']['MEDIA']['DESCRIPTION']) {
            $this->retval .= "<p>" . nl2br(htmlspecialchars(stripslashes($DESCRIPTION))) . "</p>\n";
        }
        $tmp = [];
        if ($PUBLISHED) {
            $tmp[] = "<b>Added:</b> " . date('j F Y', strtotime($PUBLISHED));
        } elseif ($UPLOAD_TIME = $MEDIA['GROUP']['YT']['UPLOADED']) {
            $tmp[] = "<b>Added:</b> " . date('j F Y', strtotime($UPLOAD_TIME));
        }
        if ($RATING && $NUMRATERS) $tmp[] = "<b>Rating:</b> " . number_format($RATING, 2) . " (" . number_format($NUMRATERS) . " ratings)";
        if ($VIEWCOUNT) $tmp[] = "<b>Views:</b> " . number_format($VIEWCOUNT);
        if ($FAVORITECOUNT) $tmp[] = "<b>Favorite:</b> " . number_format($FAVORITECOUNT);
        $this->retval .= "<p><small>";
        $this->retval .= implode("; ", $tmp);
        if (($TAGS = $MEDIA['GROUP']['MEDIA']['KEYWORDS']) && $TAGS = explode(' ', $TAGS)) {
            $this->retval .= "<br>\n<b>Tags:</b>";
            foreach ($TAGS as $tmp) {
                $this->retval .= " <a href=\"http://www.youtube.com/results?search_query=$tmp&amp;search=tag\" target=\"_blank\">$tmp</a>";
            }
            $this->retval .= "</small></p>\n";
        }
        $this->retval .= "</td>\n</tr>\n";
    }

    function fixEncoding(&$input, $key, $output_encoding)
    {
        if (!function_exists('mb_detect_encoding')) return $input;

        $encoding = mb_detect_encoding($input);
        switch ($encoding) {
            case 'ASCII':
            case $output_encoding:
                break;
            case '':
                $input = mb_convert_encoding($input, $output_encoding);
                break;
            default:
                $input = mb_convert_encoding($input, $output_encoding, $encoding);
        }
    }

    // display entire feed as HTML
    function getOutput($output_encoding = 'UTF-8')
    {
        $this->retval = "";
        $start_tag = key($this->output);

        switch ($start_tag) {
            case "FEED":
                // youtube xml format
                $this->display_channel($this->output[$start_tag]);
                break;

            default:
                die("Error: unrecognized start tag '$start_tag' in getOutput()");
        }

        if ($this->retval && is_array($this->retval)) {
            array_walk_recursive($this->retval, 'YouTubeParser::fixEncoding', $output_encoding);
        }
        return $this->retval;
    }

    // return raw data as array
    function getRawOutput($output_encoding = 'UTF-8')
    {
        array_walk_recursive($this->output, 'YouTubeParser::fixEncoding', $output_encoding);
        return $this->output;
    }
}
