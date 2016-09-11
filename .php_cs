<?php

$header = trim(file_get_contents(__DIR__ . "/.php_cs_header"));

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers([
        "array_element_no_space_before_comma", // In array declaration, there MUST NOT be a whitespace before each comma.
        "array_element_white_space_after_comma", // In array declaration, there MUST be a whitespace after each comma.
        "blankline_after_open_tag", // Ensure there is no code on the same line as the PHP open tag and it is followed by a blankline.
        "declare_equal_normalize", // Equal sign in declare statement should not be surrounded by spaces.
        "double_arrow_multiline_whitespaces", // Operator => should not be surrounded by multi-line whitespaces.
        "duplicate_semicolon", // Remove duplicated semicolons.
        "extra_empty_lines", // Removes extra empty lines.
        "function_typehint_space", // Add missing space between function's argument and its typehint.
        "hash_to_slash_comment", // Single line comments should use double slashes (//) and not hash (#).
        "heredoc_to_nowdoc", // Convert heredoc to nowdoc if possible.
        "include", // Include/Require and file path should be divided with a single space. File path should not be placed under brackets.
        "join_function", // Implode function should be used instead of join function.
        "list_commas", // Remove trailing commas in list function calls.
        "lowercase_cast", // Cast should be written in lower case.
        "method_argument_default_value", // In method arguments there must not be arguments with default values before non-default ones.
        "namespace_no_leading_whitespace", // The namespace declaration line shouldn't contain leading whitespace.
        "native_function_casing", // Function defined by PHP should be called using the correct casing.
        "new_with_braces", // All instances created with new keyword must be followed by braces.
        "no_blank_lines_after_class_opening", // There should be no empty lines after class opening brace.
        "no_empty_comment", // There should not be an empty comments.
        "no_empty_lines_after_phpdocs", // There should not be blank lines between docblock and the documented element.
        "no_empty_phpdoc", // There should not be empty PHPDoc blocks.
        "no_empty_statement", // Remove useless semicolon statements.
        "object_operator", // There should not be space before or after object T_OBJECT_OPERATOR.
        "operators_spaces", // Binary operators should be surrounded by at least one space.
        "phpdoc_annotation_without_dot", // Phpdocs annotation descriptions should not end with a full stop.
        "phpdoc_indent", // Docblocks should have the same indentation as the documented subject.
        "phpdoc_inline_tag", // Fix phpdoc inline tags, make inheritdoc always inline.
        "phpdoc_no_access", // @access annotations should be omitted from phpdocs.
        "phpdoc_no_empty_return", // @return void and @return null annotations should be omitted from phpdocs.
        "phpdoc_no_package", // @package and @subpackage annotations should be omitted from phpdocs.
        "phpdoc_params", // All items of the @param, @throws, @return, @var, and @type phpdoc tags must be aligned vertically.
        "phpdoc_scalar", // Scalar types should always be written in the same form. "int", not "integer"; "bool", not "boolean"; "float", not "real" or "double".
        "phpdoc_separation", // Annotations in phpdocs should be grouped together so that annotations of the same type immediately follow each other, and annotations of a different type are separated by a single blank line.
        "phpdoc_short_description", // Phpdocs short descriptions should end in either a full stop, exclamation mark, or question mark.
        "phpdoc_single_line_var_spacing", // Single line @var PHPDoc should have proper spacing.
        "phpdoc_to_comment", // Docblocks should only be used on structural elements.
        "phpdoc_trim", // Phpdocs should start and end with content, excluding the very first and last line of the docblocks.
        "phpdoc_type_to_var", // @type should always be written as @var.
        "phpdoc_types", // The correct case must be used for standard PHP types in phpdoc.
        "phpdoc_var_without_name", // @var and @type annotations should not contain the variable name.
        "remove_leading_slash_use", // Remove leading slashes in use clauses.
        "remove_lines_between_uses", // Removes line breaks between use statements.
        "return", // An empty line feed should precede a return statement.
        "self_accessor", // Inside a classy element "self" should be preferred to the class name itself.
        "short_scalar_cast", // Cast "(boolean)" and "(integer)" should be written as "(bool)" and "(int)". "(double)" and "(real)" as "(float)".
        "single_array_no_trailing_comma", // PHP single-line arrays should not have trailing comma.
        "single_blank_line_before_namespace", // There should be exactly one blank line before a namespace declaration.
        "spaces_after_semicolon", // Fix whitespace after a semicolon.
        "spaces_before_semicolon", // Single-line whitespace before closing semicolon are prohibited.
        "spaces_cast", // A single space should be between cast and variable.
        "standardize_not_equal", // Replace all <> with !=.
        "ternary_spaces", // Standardize spaces around ternary operator.
        "trim_array_spaces", // Arrays should be formatted like function/method arguments, without leading or trailing single line space.
        "unary_operators_spaces", // Unary operators should be placed adjacent to their operands.
        "unneeded_control_parentheses", // Removes unneeded parentheses around control statements.
        "unused_use", // Unused use statements must be removed.
        "whitespacy_lines", // Remove trailing whitespace at the end of blank lines.
        "align_double_arrow", // Align double arrow symbols in consecutive lines.
        "combine_consecutive_unsets", // Calling unset on multiple items should be done in one call.
        "concat_with_spaces", // Concatenation should be used with at least one whitespace around.
        "ereg_to_preg", // Replace deprecated ereg regular expression functions with preg. Warning! This could change code behavior.
        "logical_not_operators_with_successor_space", // Logical NOT operators (!) should have one trailing whitespace.
        "mb_str_functions", // Replace non multibyte-safe functions with corresponding mb function. Warning! This could change code behavior.
        "multiline_spaces_before_semicolon", // Multi-line whitespace before closing semicolon are prohibited.
        "no_useless_else", // There should not be useless else cases.
        "no_useless_return", // There should not be an empty return statement at the end of a function.
        "header_comment", // Add, replace or remove header comment.
        "ordered_use", // Ordering use statements.
        "php_unit_construct", // PHPUnit assertion method calls like "->assertSame(true, $foo)" should be written with dedicated method like "->assertTrue($foo)". Warning! This could change code behavior.
        "php_unit_dedicate_assert", // PHPUnit assertions like "assertInternalType", "assertFileExists", should be used over "assertTrue". Warning! This could change code behavior.
        "php_unit_strict", // PHPUnit methods like "assertSame" should be used instead of "assertEquals". Warning! This could change code behavior.
        "phpdoc_order", // Annotations in phpdocs should be ordered so that param annotations come first, then throws annotations, then return annotations.
        "short_array_syntax", // PHP arrays should use the PHP 5.4 short-syntax.
        "strict", // Comparison should be strict. Warning! This could change code behavior.
    ])
    ->finder(Symfony\CS\Finder\DefaultFinder::create()->in(__DIR__));
