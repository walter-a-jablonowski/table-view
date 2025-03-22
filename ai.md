
Make a view for vewing table data

## Table control

### Data sources

- csv
- tsv seperated with 2 spaces
- json
- yml

If json and yml have string keys for records add a field "id" with that string.
Data is loaded via ajax.

### table js class

- construct
  - number of records to show, default: 100
  - columns to show in table
    - style: 'default' = own styles, 'bs' = bootstrap (currently unsupported)
    - names of columns
    - or a number of first columns to show
    - if null default: first 5 columns from the data source

### table ui

In the UI we add an empty div for the tahle.

- full text filter input, filters on enter, also add a filter button
  - use ajax and rebuild the filtered table
  - case insensitive, partial matches
- columns
  - use the header texts from csv/tsv or the keys from json/yml as column headlines
  - make columns sortable (single column, use ajax so that all data is considered)
  - we use no html table but html elemets that enable break on mobile phones
    - break columns that require too much space, make them foldable
- no pagination, instead use a load more button below (ajax) until all data is loaded

## Detail control

A seperate control can be initialized optionally. Make a second js class for this, that is tiggered by the table class to update UI content. In the UI we may add an empty div (content is generated) or a div with predefined sub elements (user defined styling for the view).

- When a record is clicked in the table the detail control will show its data in spans
- All data is shown, also colums that aren't shown in the table

## Demo page

- page header
- table control (scrollable)
- detail control
  - on PC and tablets in landscape we use a full height at the right side of the page
  - on tablets in portrait and mobile phones we use a overlay instead

## Common

- Use PHP, plain javascript
- don't use third party libraries, implement from scratch
- use a basic json ajax format (no complicated rest api)
- provide basic error handling and display errors to the user in a useful way
- no data validation cause we are making read only components
- make it responsive
- use responsive breakpoints similar to bootstrap (but don't include bootstrap)

Important: make it looking nice
