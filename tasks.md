
(all from prompt seen)

- fix tsv format
- minor changes like improve fetch call, ui, ...

- maybe we also need to specify what cols e.g. login does leave out cols
- verify that a string key in json or yml will be col id
- fix responsive breaks
- maybe verify err handling
- detail view is added as empty div
  - verify that we also could add a div with predefined sub elements (layout)

- construct args seem to be right? try usage va raints

  recordsPerPage: 100,
  columns: null,  // Will use first 5 columns by default
  style: 'default'

- try load more button (currently no enough demo data)


Advanced

- make it more nice
- improve what we can put in filter box
- bs compatible version (see construct arg)
- Advanced table functions
- Editable variant of the detail view (also must have select)
