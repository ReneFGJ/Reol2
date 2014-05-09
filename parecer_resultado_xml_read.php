<?php
/**
 * What to use for XML parsing / reading in PHP4
 * @link http://stackoverflow.com/q/132233/367456
 */

$encoding = 'UTF-8';
         // https://gist.github.com/hakre/46386de578619fbd898c
$path     = $arq;
$parser_creator = 'xml_parser_create'; // alternative creator is 'xml_parser_create_ns'

if (!function_exists($parser_creator)) {
    trigger_error(
        "XML Parsers' $parser_creator() not found. XML Parser "
        . '<http://php.net/xml> is required, activate it in your PHP configuration.'
        , E_USER_ERROR
    );
    return;
}

$parser = $parser_creator($encoding);
if (!$parser) {
    trigger_error(sprintf('Unable to create a parser (Encoding: "%s")', $encoding), E_USER_ERROR);
    return;
}

xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);

$data = (file_get_contents($path));
if ($data === FALSE) {
    trigger_error(sprintf('Unable to open file "%s" for reading', $path));
    return;
}
$result = xml_parse_into_struct($parser, $data, $xml_struct_values);
unset($data);
xml_parser_free($parser);
unset($parser);

if ($result === 0) {
    trigger_error(sprintf('Unable to parse data of file "%s" as XML', $path));
    return;
}

define('TREE_NODE_TAG', 'tagName');
define('TREE_NODE_ATTRIBUTES', 'attributes');
define('TREE_NODE_CHILDREN', 'children');

define('TREE_NODE_TYPE_TAG', 'array');
define('TREE_NODE_TYPE_TEXT', 'string');
define('TREE_NODE_TYPE_NONE', 'NULL');

/**
 * XML Parser indezies for parse into struct values
 */
define('XML_STRUCT_VALUE_TYPE', 'type');
define('XML_STRUCT_VALUE_LEVEL', 'level');
define('XML_STRUCT_VALUE_TAG', 'tag');
define('XML_STRUCT_VALUE_ATTRIBUTES', 'attributes');
define('XML_STRUCT_VALUE_VALUE', 'value');

/**
 * XML Parser supported node types
 */
define('XML_STRUCT_TYPE_OPEN', 'open');
define('XML_STRUCT_TYPE_COMPLETE', 'complete');
define('XML_STRUCT_TYPE_CDATA', 'cdata');
define('XML_STRUCT_TYPE_CLOSE', 'close');

/**
 * Tree Creator
 * @return array
 */
function tree_create()
{
    return array(
        array(
            TREE_NODE_TAG        => NULL,
            TREE_NODE_ATTRIBUTES => NULL,
            TREE_NODE_CHILDREN   => array(),
        )
    );
}

/**
 * Add Tree Node into Tree a Level
 *
 * @param $tree
 * @param $level
 * @param $node
 * @return array|bool Tree with the Node added or FALSE on error
 */
function tree_add_node($tree, $level, $node)
{
    $type = gettype($node);
    switch ($type) {
        case TREE_NODE_TYPE_TEXT:
            $level++;
            break;
        case TREE_NODE_TYPE_TAG:
            break;
        case TREE_NODE_TYPE_NONE:
            trigger_error(sprintf('Can not add Tree Node of type None, keeping tree unchanged', $type, E_USER_NOTICE));
            return $tree;
        default:
            trigger_error(sprintf('Can not add Tree Node of type "%s"', $type), E_USER_ERROR);
            return FALSE;
    }

    if (!isset($tree[$level - 1])) {
        trigger_error("There is no parent for level $level");
        return FALSE;
    }

    $parent = & $tree[$level - 1];

    if (isset($parent[TREE_NODE_CHILDREN]) && !is_array($parent[TREE_NODE_CHILDREN])) {
        trigger_error("There are no children in parent for level $level");
        return FALSE;
    }

    $parent[TREE_NODE_CHILDREN][] = & $node;
    $tree[$level]                 = & $node;

    return $tree;
}

/**
 * Creator of a Tree Node
 *
 * @param $value XML Node
 * @return array Tree Node
 */
function tree_node_create_from_xml_struct_value($value)
{
    static $xml_node_default_types = array(
        XML_STRUCT_VALUE_ATTRIBUTES => NULL,
        XML_STRUCT_VALUE_VALUE      => NULL,
    );

    $orig = $value;

    $value += $xml_node_default_types;

    switch ($value[XML_STRUCT_VALUE_TYPE]) {
        case XML_STRUCT_TYPE_OPEN:
        case XML_STRUCT_TYPE_COMPLETE:
            $node = array(
                TREE_NODE_TAG => $value[XML_STRUCT_VALUE_TAG],
                // '__debug1' => $orig,
            );
            if (isset($value[XML_STRUCT_VALUE_ATTRIBUTES])) {
                $node[TREE_NODE_ATTRIBUTES] = $value[XML_STRUCT_VALUE_ATTRIBUTES];
            }
            if (isset($value[XML_STRUCT_VALUE_VALUE])) {
                $node[TREE_NODE_CHILDREN] = (array)$value[XML_STRUCT_VALUE_VALUE];
            }
            return $node;

        case XML_STRUCT_TYPE_CDATA:
            // TREE_NODE_TYPE_TEXT
            return $value[XML_STRUCT_VALUE_VALUE];

        case XML_STRUCT_TYPE_CLOSE:
            return NULL;

        default:
            trigger_error(
                sprintf(
                    'Unkonwn Xml Node Type "%s": %s', $value[XML_STRUCT_VALUE_TYPE], var_export($value, TRUE)
                )
            );
            return FALSE;
    }
}

$tree = tree_create();

while ($tree && $value = array_shift($xml_struct_values)) {
    $node = tree_node_create_from_xml_struct_value($value);
    if (NULL === $node) {
        continue;
    }
    $tree = tree_add_node($tree, $value[XML_STRUCT_VALUE_LEVEL], $node);
    unset($node);
}

if (!$tree) {
    trigger_error('Parse error');
    return;
}

if ($xml_struct_values) {
    trigger_error(sprintf('Unable to process whole parsed XML array (%d elements left)', count($xml_struct_values)));
    return;
}
// tree root is the first child of level 0
?>