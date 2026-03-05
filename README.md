# str_replace — eZ Publish Template Operator Extension

**str_replace** is an eZ Publish Legacy extension that exposes PHP's native `str_replace()` function as the `{ezstr_replace}` template operator, allowing search-and-replace operations directly inside eZ Publish templates.

- **Author:** Alexandre Abric
- **Initial release:** April 2005
- **License:** GNU General Public License v2

---

## About

The extension registers a single template operator, `ezstr_replace`, which wraps PHP's built-in `str_replace()`. It is lightweight, dependency-free, and compatible with any eZ Publish Legacy installation.

---

## Installation

1. Extract or clone the repository into your `extension/` directory so that the path becomes:

   ```
   extension/str_replace/
   ```

2. Activate the extension. Either use the eZ Publish admin interface
   (**Setup → Extensions**), or add it manually to
   `settings/override/site.ini.append.php`:

   ```ini
   [ExtensionSettings]
   ActiveExtensions[]=str_replace
   ```

   If the `[ExtensionSettings]` block already exists, just append the second line.

3. Clear the cache:

   ```bash
   php bin/php/ezcache.php --clear-all
   ```

---

## Usage

Use the `ezstr_replace` operator in any eZ Publish template:

```smarty
{ezstr_replace($search, $replace, $subject)}
```

| Parameter  | Type   | Required | Description                        |
|------------|--------|----------|------------------------------------|
| `$search`  | string | yes      | The value to search for            |
| `$replace` | string | yes      | The replacement value              |
| `$subject` | string | yes      | The string to perform the search on|

### Examples

Replace a word in a plain string:

```smarty
{ezstr_replace('world', 'eZ Publish', 'Hello world!')}
{* Output: Hello eZ Publish! *}
```

Replace content from a node attribute:

```smarty
{def $cleaned = ezstr_replace('-', ' ', $node.name)}
{$cleaned}
```

---

## File Structure

```
extension/str_replace/
├── autoloads/
│   ├── eztemplateautoload.php          # Registers the operator with eZ Publish
│   └── str_replace_controloperator.php # Operator implementation (MyStrReplaceOperator)
├── doc/
│   └── readme.txt                      # Original documentation
├── settings/
│   └── site.ini.append.php             # Extension autoload path setting
├── composer.json
├── ezinfo.php
├── LICENSE
└── README.md
```

---

## License

This file may be distributed and/or modified under the terms of the **GNU General Public License** version 2 as published by the Free Software Foundation.

This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.

The GNU General Public License (GPL) is available at [http://www.gnu.org/copyleft/gpl.html](http://www.gnu.org/copyleft/gpl.html).
