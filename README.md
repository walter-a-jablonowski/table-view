# Table view

Made with AI

```php
composer install
```

| File           | Description |
|----------------|-------------|
| `ai.md`        | Initial prompt |
| `index_style.php` | Standard demo |
| `index.php`    | BS-compatible demo |
| `/ajax`        | AJAX impl |
| `/data`        | Sample data files |
| `/table-view`  | Table view component |

## Debug

```
index_style.php?source=data/sample.csv
index.php?source=data/sample.csv        # BS 5.3

index_style.php?source=data/sample.json
index.php?source=data/sample.json

index_style.php?source=data/sample.tsv
index.php?source=data/sample.tsv

index_style.php?source=data/sample.yml
index.php?source=data/sample.yml

# Cols in table

index.php?source=data/login.yml&cols=ID|User|PswdHint|Device
```

## License

Copyright (C) Walter A. Jablonowski 2025, free under [MIT license](LICENSE)

This app is build upon PHP and free software (see [credits](credits.md)).

[Privacy](https://walter-a-jablonowski.github.io/privacy.html) | [Legal](https://walter-a-jablonowski.github.io/imprint.html)
