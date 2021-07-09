# PHPMarkup coding standards

1. Variable names must be meaningful. One letter variable names must be avoided,
    except for places where the variable has no real meaning or a trivial
    meaning (e.g. `for (i=0; i<100; i++) ...`).

    Rule inherited from [PHP](https://github.com/php/php-src/edit/master/CODING_STANDARDS.md).

2. Variable names should be in lowercase. Use underscores to separate between
    words.

   Good:

    ```php
    $person = new Person();
    $person_id = 1;
    $max_int_value = 2;
    ```

    Bad:

    ```php
    $Person = new Person();
    $personId = 1;
    $maxIntValue = 2;
    ```
    
    Rule inherited from [PHP](https://github.com/php/php-src/edit/master/CODING_STANDARDS.md).

3. Method names follow the *studlyCaps* (also referred to as *bumpy case* or
    *camel caps*) naming convention, with care taken to minimize the letter
    count. The initial letter of the name is lowercase, and each letter that
    starts a new `word` is capitalized:

    Good:

    ```php
    connect()
    getData()
    buildSomeWidget()
    ```

    Bad:

    ```php
    get_Data()
    buildsomewidget()
    getI()
    ```
    
    Rule inherited from [PHP](https://github.com/php/php-src/edit/master/CODING_STANDARDS.md).

4. Class names should be descriptive nouns in *PascalCase* and as short as
    possible. Each word in the class name should start with a capital letter,
    without underscore delimiters. The class name should be prefixed with the
    name of the "parent set" (e.g. the name of the extension) if no namespaces
    are used. Abbreviations and acronyms as well as initialisms should be
    avoided wherever possible, unless they are much more widely used than the
    long form (e.g. HTTP or URL). Abbreviations start with a capital letter
    followed by lowercase letters, whereas acronyms and initialisms are written
    according to their standard notation. Usage of acronyms and initialisms is
    not allowed if they are not widely adopted and recognized as such.

    Good:

    ```php
    Curl
    CurlResponse
    HTTPStatusCode
    URL
    BTreeMap // B-tree Map
    Id // Identifier
    ID // Identity Document
    Char // Character
    Intl // Internationalization
    Radar // Radio Detecting and Ranging
    ```

    Bad:

    ```php
    curl
    curl_response
    HttpStatusCode
    Url
    BtreeMap
    ID // Identifier
    CHAR
    INTL
    RADAR // Radio Detecting and Ranging
    ```

    Rule inherited from [PHP](https://github.com/php/php-src/edit/master/CODING_STANDARDS.md).
