When you write code and I don't specify something else follow these conventions:

- Act as a genius developer and pretend you have an IQ of 160
- Please ask clarifying questions first if you don't understand something

**Code**

- Implement server functionallity in PHP and client functionality in html and plain javascript unless something else is requested
- Important: Make code that is "nice" and easy to understand
- Important: Always keep in mind that we want to make a system that is well structured as a whole
  - Maintain clear separation of concerns
- If implemeting classes choose a good class design
- Unless requested differently prefer saving data in yaml files over database

- Don't implement redundant functions (that are used only once)
- Keep in mind: in PHP `else if` is written as `elseif`
- Dynamic strings: prefer building strings like `"my $string"`, `"my {$this->string}"` instead of joining them with "."
- Don't remove comments or out-comment code in the code unless this makes sense for the current task (e.g. comment get obsolete)

**Codestyle**

- Indent all codes with 2 spaces
- Use of brackets: put the { on the next line
  - exception: try catch is written differently
    ```php
    try {

      // code
    }
    catch( Exception $e ) {
      // code
    }
    ```
  - don't use curly brackets for conditions or loops that have only one line
- Use of blanks
  - loops or conditions: use a blank before and behind the condition
    - `while( $condition )`
  - function definition: use a blank before and behind the arg list, and add blanks to the return
    - `function myFunc( $arg, $arg2 ) : bool`
  - function calls
    - multiple args: use a blank before and behind the arg list `myFunc( $arg, $arg2 )`
    - single arg:    use no blanks `myFunc($arg)`
  - exceptions for funtion calls, loops and conditions
    - no blank when 2 brackets collide `if( ! in_array(...))`
    - no blank when " or ' and bracket collide `in_array('some', $a )`
  - also use blanks around the "!" `if( ! in_array(...)`
- Use of " and ': Prefer ' is you don't need " e.g. for dynamic strings or line breaks
- Comments that are a headline for something get a blank line behind
- Comments that explain something may also be on the same line on the right to save some space

**User Interface**

- **index:** If you make a index.php or index.html don't put it a public folder
- **Prefered page struct** if we have multiple pages (only)
  ```
  /pages/MY_PAGE
  /pages/MY_PAGE/controller.php
  /pages/MY_PAGE/controller.js
  /pages/MY_PAGE/style.css
  /pages/MY_PAGE/view.php or folder /pages/MY_PAGE/view if multiple
  /pages/MY_PAGE/ajax  # folder for ajax handler files
  ```

- **Dynamic html:** If you make html code use no echo but render the html using PHP'a alternative syntax
- **Ajax**
  - If you need ajax calls make a file ajax.php on the root level of the app that forwards the call
  - Don't use form submit, use ajax calls instead that send json with one file per ajax call on the server side that handles the call (no use of REQUEST_METHOD)
  - prefer the fetch api

**API and third party libraries**

- If you need to loop directories prefer scandir 
- For yaml use use Symfony yaml and provide a composer file if missing
- Don't use the DataTable library, instead provide your own implementation if you need to make a table considering the given requirements
- HTTP requests: Use curl or a third party library
- use no Goutte
